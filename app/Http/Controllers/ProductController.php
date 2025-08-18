<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by category if specified
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($sort = $request->input('sort')) {
            if ($sort === 'price_asc') {
                $query->orderBy('price');
            } elseif ($sort === 'price_desc') {
                $query->orderByDesc('price');
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('products', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $request->category,
            'selectedSort' => $request->sort,
            'searchQuery' => $request->search
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
