<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function list(Request $request)
    {
        $query = Product::select('products.*');

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
            $builder->where('products.model', '=', $selectedType);
        });

        $nameSort = strtolower((string) $request->input('name_sort', ''));
        $priceSort = strtolower((string) $request->input('price_sort', ''));

        $validDirections = ['asc', 'desc'];
        $hasNameSort = in_array($nameSort, $validDirections, true);
        $hasPriceSort = in_array($priceSort, $validDirections, true);

        if ($hasNameSort && $hasPriceSort) {
            // When both are selected, apply both sorts together in a visible way.
            $query->orderBy('products.price', strtoupper($priceSort));
            $query->orderBy('products.name', strtoupper($nameSort));
        } elseif ($hasPriceSort) {
            $query->orderBy('products.price', strtoupper($priceSort));
        } elseif ($hasNameSort) {
            $query->orderBy('products.name', strtoupper($nameSort));
        } else {
            $query->orderBy('products.id', 'DESC');
        }

        // Keep ordering stable when values are equal.
        $query->orderBy('products.id', 'DESC');

        $products = $query->get();

        $productTypes = Product::query()
            ->select('model')
            ->whereNotNull('model')
            ->where('model', '!=', '')
            ->distinct()
            ->orderBy('model', 'ASC')
            ->pluck('model');

        return view('products.list', compact('products', 'minPrice', 'maxPrice', 'selectedType', 'productTypes', 'nameSort', 'priceSort'));
    }

    public function show(Request $request, Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Request $request, ?Product $product = null)
    {
        if (! $product) {
            $product = new Product();
        }

        return view('products.edit', compact('product'));
    }

    public function save(Request $request, ?Product $product = null)
    {
        if (! $product) {
            $product = new Product();
        }

        $validatedData = $request->validate([
            'code' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'photo' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $product->fill($validatedData);
        $product->save();

        return redirect()->route('products_list');
    }

    public function delete(Request $request, Product $product)
    {
        $product->delete();

        return redirect()->route('products_list');
    }
}