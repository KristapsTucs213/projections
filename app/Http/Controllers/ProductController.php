<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|unique:products|max:255',
            'quantity' => 'required|integer',
            'description' => 'required',
        ]);

        $product = Product::create($validated);

        return redirect()
                ->route('products.show', [$product]) // vai ['product' => $product]
                ->with('status', "Product created successfully");
    }

    public function show(Product $product) {
        return view('products.show', compact('product'));
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()
                ->route('products.index')
                ->with('status', "Product deleted successfully");
    }

    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        
        $validated = $request->validate([
            'name' => 'required|max:255',
            'quantity' => 'required|integer',
            'description' => 'required',
        ]);

        $product->update($validated);
        return redirect()
                ->route('products.show', [$product])
                ->with('status', "Product updated successfully");
    }

    public function decreaseQuantity(Request $request, Product $product) {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $amount = $request->input('amount');

        $lol = $product->quantity -= $amount;
        if ($lol < 0) {
            return redirect()
                ->route('products.show', [$product])
                ->withErrors(['amount' => 'Not enough stock to decrease quantity.']);
        } else {
            $product->save();
           return redirect()
                ->route('products.show', [$product]) // vai ['product' => $product]
                ->with('status', "Product created successfully"); 
        }
        
    }

    public function increseQuantity(Request $request, Product $product){
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $amount = $request->input('amount');

        $product->quantity += $amount;
        $product->save();

        return redirect()
                ->route('products.show', [$product]) // vai ['product' => $product]
                ->with('status', "Product created successfully");
    }
}
