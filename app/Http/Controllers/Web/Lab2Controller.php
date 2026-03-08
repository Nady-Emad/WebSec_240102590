<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CourseCatalog;
use App\Models\Product;
use App\Models\TranscriptCourse;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class Lab2Controller extends Controller
{
    public function transcript(Request $request): View|RedirectResponse
    {
        $accountUser = $this->resolveCurrentAccountUser($request);

        if (! $accountUser) {
            return redirect()->route('lab3.login')->with('status', 'Please login to view your transcript.');
        }

        $transcriptCourses = TranscriptCourse::query()
            ->orderBy('course_code')
            ->where(function ($query) use ($accountUser) {
                $query->where('student_name', $accountUser->name)
                    ->orWhere('student_number', (string) $accountUser->id)
                    ->orWhere('student_number', $accountUser->email);
            })
            ->get();

        $firstRow = $transcriptCourses->first();

        $student = [
            'name' => $accountUser->name,
            'id' => (string) $accountUser->id,
            'major' => $firstRow?->major ?? ucfirst((string) $accountUser->role),
            'email' => $accountUser->email,
        ];

        $courses = $transcriptCourses->map(function (TranscriptCourse $course) {
            return [
                'code' => $course->course_code,
                'title' => $course->title,
                'credit_hours' => $course->credit_hours,
                'grade' => $course->grade,
            ];
        })->all();

        return view('lab.transcript', compact('student', 'courses'));
    }

    public function products(Request $request): View
    {
        $keywords = trim((string) $request->query('keywords', ''));
        $minPrice = $request->filled('min_price') ? max(0, (float) $request->query('min_price')) : null;
        $maxPrice = $request->filled('max_price') ? max(0, (float) $request->query('max_price')) : null;
        $selectedType = trim((string) $request->query('product_type', ''));
        $nameSort = strtolower((string) $request->query('name_sort', ''));
        $priceSort = strtolower((string) $request->query('price_sort', ''));

        if ($minPrice !== null && $maxPrice !== null && $maxPrice < $minPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        $query = Product::query();

        $query->when($keywords !== '', function ($builder) use ($keywords) {
            $builder->where('name', 'like', "%{$keywords}%");
        });

        $query->when($minPrice !== null, function ($builder) use ($minPrice) {
            $builder->where('price', '>=', $minPrice);
        });

        $query->when($maxPrice !== null, function ($builder) use ($maxPrice) {
            $builder->where('price', '<=', $maxPrice);
        });

        $query->when($selectedType !== '', function ($builder) use ($selectedType) {
            $builder->where('model', $selectedType);
        });

        $validDirections = ['asc', 'desc'];
        $hasNameSort = in_array($nameSort, $validDirections, true);
        $hasPriceSort = in_array($priceSort, $validDirections, true);

        if ($hasNameSort && $hasPriceSort) {
            $query->orderBy('price', $priceSort)->orderBy('name', $nameSort);
        } elseif ($hasPriceSort) {
            $query->orderBy('price', $priceSort);
        } elseif ($hasNameSort) {
            $query->orderBy('name', $nameSort);
        } else {
            $query->orderByDesc('id');
        }

        $products = $query->paginate(9)->withQueryString();

        $productTypes = Cache::remember('products:model-types', now()->addMinutes(10), function () {
            return Product::query()
                ->whereNotNull('model')
                ->where('model', '!=', '')
                ->distinct()
                ->orderBy('model')
                ->pluck('model');
        });

        $cart = $this->getCart($request);
        $cartRows = [];
        $cartTotal = 0.0;

        $cartProducts = Product::query()
            ->whereIn('id', array_map('intval', array_keys($cart)))
            ->get()
            ->keyBy('id');

        foreach ($cart as $productId => $quantity) {
            $product = $cartProducts->get((int) $productId);
            if (! $product) {
                continue;
            }

            $lineTotal = (float) $product->price * (int) $quantity;
            $cartTotal += $lineTotal;

            $cartRows[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => (int) $quantity,
                'line_total' => $lineTotal,
            ];
        }

        return view('lab.products', [
            'products' => $products,
            'cartRows' => $cartRows,
            'cartItemsCount' => array_sum($cart),
            'cartTotal' => $cartTotal,
            'keywords' => $keywords,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'selectedType' => $selectedType,
            'nameSort' => $nameSort,
            'priceSort' => $priceSort,
            'productTypes' => $productTypes,
        ]);
    }

    public function addToCart(Request $request, Product $product): RedirectResponse
    {
        $cart = $this->getCart($request);
        $currentQty = (int) ($cart[$product->id] ?? 0);
        $cart[$product->id] = $currentQty + 1;

        $request->session()->put('lab2_cart', $cart);

        return redirect()->back()->with('status', $product->name . ' added to cart.');
    }

    public function removeFromCart(Request $request, Product $product): RedirectResponse
    {
        $cart = $this->getCart($request);

        if (isset($cart[$product->id])) {
            $cart[$product->id]--;

            if ($cart[$product->id] <= 0) {
                unset($cart[$product->id]);
            }
        }

        $request->session()->put('lab2_cart', $cart);

        return redirect()->back()->with('status', $product->name . ' removed from cart.');
    }

    public function clearCart(Request $request): RedirectResponse
    {
        $request->session()->forget('lab2_cart');

        return redirect()->back()->with('status', 'Cart cleared.');
    }

    public function calculator(): View
    {
        return view('lab.calculator');
    }

    public function gpaSimulator(): View
    {
        $courseCatalog = CourseCatalog::query()
            ->orderBy('course_code')
            ->get(['course_code', 'title', 'credit_hours'])
            ->map(function (CourseCatalog $course) {
                return [
                    'code' => $course->course_code,
                    'title' => $course->title,
                    'credit_hours' => $course->credit_hours,
                ];
            })->all();

        return view('lab.gpa-simulator', compact('courseCatalog'));
    }

    private function getCart(Request $request): array
    {
        $cart = $request->session()->get('lab2_cart', []);

        return is_array($cart) ? $cart : [];
    }

    private function resolveCurrentAccountUser(Request $request): ?User
    {
        $authUser = Auth::user();
        if ($authUser instanceof User) {
            return $authUser;
        }

        $lab3UserId = (int) $request->session()->get('lab3_user_id');
        if ($lab3UserId > 0) {
            return User::query()->find($lab3UserId);
        }

        return null;
    }
}
