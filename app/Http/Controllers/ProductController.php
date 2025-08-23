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

        // Get all categories with their slugs for the filter
        $allCategories = Product::select('category')
            ->distinct()
            ->orderBy('category')
            ->get()
            ->mapWithKeys(function($item) {
                $slug = strtolower(str_replace(' ', '-', $item->category));
                return [$slug => $item->category];
            });

        // Filter by category if specified
        $selectedCategory = null;
        if ($categorySlug = $request->input('category')) {
            // Find the actual category name from the slug
            $selectedCategory = $allCategories->get($categorySlug);
            if ($selectedCategory) {
                $query->where('category', $selectedCategory);
            }
        }

        // Search functionality
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter out inactive products
        $query->where('is_active', true);

        // Sorting
        $sort = $request->input('sort');
        if ($sort === 'price_asc') {
            $query->orderBy('price');
        } elseif ($sort === 'price_desc') {
            $query->orderByDesc('price');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)
            ->appends([
                'search' => $request->search,
                'category' => $request->category,
                'sort' => $request->sort
            ]);

        return view('products', [
            'products' => $products,
            'categories' => $allCategories,
            'selectedCategory' => $selectedCategory,
            'selectedSort' => $sort,
            'searchQuery' => $request->search,
            'categorySlug' => $request->category
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
