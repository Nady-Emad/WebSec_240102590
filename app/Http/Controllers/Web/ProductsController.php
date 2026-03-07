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

        $query->when($request->filled('keywords'), function ($builder) use ($request) {
            $builder->where('products.name', 'like', '%' . $request->keywords . '%');
        });

        $query->when($request->filled('min_price'), function ($builder) use ($request) {
            $builder->where('products.price', '>=', $request->min_price);
        });

        $query->when($request->filled('max_price'), function ($builder) use ($request) {
            $builder->where('products.price', '<=', $request->max_price);
        });

        $orderBy = $request->get('order_by');
        $orderDirection = strtoupper($request->get('order_direction', 'ASC'));

        $allowedOrderBy = ['name', 'price'];
        $allowedOrderDirection = ['ASC', 'DESC'];

        $query->when(
            in_array($orderBy, $allowedOrderBy, true),
            function ($builder) use ($orderBy, $orderDirection, $allowedOrderDirection) {
                $direction = in_array($orderDirection, $allowedOrderDirection, true) ? $orderDirection : 'ASC';
                $builder->orderBy("products.{$orderBy}", $direction);
            },
            function ($builder) {
                $builder->orderBy('products.id', 'DESC');
            }
        );

        $products = $query->get();

        return view('products.list', compact('products'));
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

        $product->fill($request->all());
        $product->save();

        return redirect()->route('products_list');
    }

    public function delete(Request $request, Product $product)
    {
        $product->delete();

        return redirect()->route('products_list');
    }
}