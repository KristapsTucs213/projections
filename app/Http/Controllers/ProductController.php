<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tag;

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
            'tags' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        // Handle tags (comma separated)
        $tagNames = $this->parseTags($request->tags);
        $tagIds = $this->syncTags($tagNames);

        $product->tags()->sync($tagIds);

        return redirect()
            ->route('products.show', $product)
            ->with('status', "Product created successfully");
    }

    public function show(Product $product) {
        $product->load('tags');
        return view('products.show', compact('product'));
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()
            ->route('products.index')
            ->with('status', "Product deleted successfully");
    }

    public function edit(Product $product) {
        $product->load('tags');
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'quantity' => 'required|integer',
            'description' => 'required',
            'tags' => 'nullable|string',
        ]);

        $product->update($validated);

        // Tags
        $tagNames = $this->parseTags($request->tags);
        $tagIds = $this->syncTags($tagNames);

        $product->tags()->sync($tagIds);

        return redirect()
            ->route('products.show', $product)
            ->with('status', "Product updated successfully");
    }

    private function parseTags($string)
    {
        if (!$string) {
            return [];
        }

        return array_filter(array_map('trim', explode(',', $string)));
    }

    private function syncTags($tagNames)
    {
        $tagIds = [];

        foreach ($tagNames as $name) {
            $tagIds[] = Tag::firstOrCreate(['name' => $name])->id;
        }

        return $tagIds;
    }

    public function decreaseQuantity(Request $request, Product $product) {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        if (($product->quantity - $request->amount) < 0) {
            return back()->withErrors(['amount' => 'Not enough stock.']);
        }

        $product->quantity -= $request->amount;
        $product->save();

        return back()->with('status', 'Quantity decreased');
    }

    public function increseQuantity(Request $request, Product $product){
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $product->quantity += $request->amount;
        $product->save();

        return back()->with('status', 'Quantity increased');
    }
}

