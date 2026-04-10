<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->get();
        return view('product.index', compact('products'));
    }

    public function create() {
    Gate::authorize('manage-product'); // Hanya Admin
    $users = User::orderBy('name')->get();
    return view('product.create', compact('users'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'user_id' => 'required|exists:user,id',
        ]);

        Product::create($validated);
        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'qty' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
            'user_id' => 'sometimes|exists:user,id',
        ]);

        $product->update($validated);
        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product); 
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}