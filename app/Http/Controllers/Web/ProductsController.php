<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function list(Request $request): View
    {
        $query = Product::query()->select('products.*');

        $keywords = trim((string) $request->get('keywords', ''));
        $minPrice = $request->filled('min_price') ? max(0, (float) $request->get('min_price')) : null;
        $maxPrice = $request->filled('max_price') ? max(0, (float) $request->get('max_price')) : null;
        $selectedType = trim((string) $request->get('product_type', ''));

        if ($minPrice !== null && $maxPrice !== null && $maxPrice < $minPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        $query->when($keywords !== '', function ($builder) use ($keywords) {
            $builder->where('products.name', 'like', '%' . $keywords . '%');
        });

        $query->when($minPrice !== null, function ($builder) use ($minPrice) {
            $builder->where('products.price', '>=', $minPrice);
        });

        $query->when($maxPrice !== null, function ($builder) use ($maxPrice) {
            $builder->where('products.price', '<=', $maxPrice);
        });

        $query->when($selectedType !== '', function ($builder) use ($selectedType) {
            $builder->where('products.model', $selectedType);
        });

        $nameSort = strtolower((string) $request->input('name_sort', ''));
        $priceSort = strtolower((string) $request->input('price_sort', ''));

        $validDirections = ['asc', 'desc'];
        $hasNameSort = in_array($nameSort, $validDirections, true);
        $hasPriceSort = in_array($priceSort, $validDirections, true);

        if ($hasNameSort && $hasPriceSort) {
            $query->orderBy('products.price', $priceSort);
            $query->orderBy('products.name', $nameSort);
        } elseif ($hasPriceSort) {
            $query->orderBy('products.price', $priceSort);
        } elseif ($hasNameSort) {
            $query->orderBy('products.name', $nameSort);
        } else {
            $query->orderByDesc('products.id');
        }

        $products = $query->paginate(12)->withQueryString();

        $productTypes = Cache::remember('products:model-types', now()->addMinutes(10), function () {
            return Product::query()
                ->select('model')
                ->whereNotNull('model')
                ->where('model', '!=', '')
                ->distinct()
                ->orderBy('model', 'ASC')
                ->pluck('model');
        });

        return view('products.list', compact(
            'products',
            'keywords',
            'minPrice',
            'maxPrice',
            'selectedType',
            'productTypes',
            'nameSort',
            'priceSort'
        ));
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    public function edit(?Product $product = null): View
    {
        if (! $product) {
            $product = new Product();
        }

        return view('products.edit', compact('product'));
    }

    public function save(Request $request, ?Product $product = null): RedirectResponse
    {
        $isNew = ! $product;

        if (! $product) {
            $product = new Product();
        }

        $validatedData = $request->validate([
            'code' => ['required', 'string', 'max:255', Rule::unique('products', 'code')->ignore($product->id)],
            'model' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'photo' => [
                'nullable',
                'string',
                'max:2048',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! is_string($value) || trim($value) === '') {
                        return;
                    }

                    $value = trim($value);
                    $isHttpUrl = filter_var($value, FILTER_VALIDATE_URL)
                        && in_array(strtolower((string) parse_url($value, PHP_URL_SCHEME)), ['http', 'https'], true);

                    $isLocalPath = (bool) preg_match('/^[A-Za-z0-9_\-\.\/]+$/', $value);

                    if (! $isHttpUrl && ! $isLocalPath) {
                        $fail('The photo must be a valid HTTP/HTTPS URL or a safe local image path.');
                    }
                },
            ],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($request->hasFile('photo_file')) {
            if ($product->photo && str_starts_with($product->photo, 'products/')) {
                Storage::disk('public')->delete($product->photo);
            }

            $validatedData['photo'] = $request->file('photo_file')->store('products', 'public');
        }

        unset($validatedData['photo_file']);

        $product->fill($validatedData);
        $product->save();

        Cache::forget('products:model-types');

        return redirect()
            ->route('lab1.products.index')
            ->with('status', $isNew ? 'Product created successfully.' : 'Product updated successfully.');
    }

    public function delete(Product $product): RedirectResponse
    {
        $productName = $product->name;

        if ($product->photo && str_starts_with($product->photo, 'products/')) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        Cache::forget('products:model-types');

        return redirect()
            ->route('lab1.products.index')
            ->with('status', "Product '{$productName}' deleted successfully.");
    }
}
