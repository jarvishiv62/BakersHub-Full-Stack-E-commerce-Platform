<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
class ProductController extends Controller
{
public function index()
{
    return response()->json(Product::withTrashed()->get());
}

public function store(Request $request)
{

$data = $request->validate([
'name' => 'required|string',
'description' => 'nullable|string',
'price' => 'required|numeric'
]);
$product = Product::create($data);
return response()->json($product, 201);
}

public function show($id)
{
    $product = Product::withTrashed()->findOrFail($id);
    return response()->json($product);
}

public function update(Request $request, $id)
{
    $product = Product::withTrashed()->findOrFail($id);
    $product->update($request->all());
    return response()->json($product);
}

public function destroy($id)
{
    $product = Product::withTrashed()->findOrFail($id);
    
    if ($product->trashed()) {
        $product->forceDelete();
    } else {
        $product->delete();
    }
    
    return response()->json(null, 204);
}
}