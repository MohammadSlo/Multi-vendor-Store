<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'store'])->latest()->paginate();

        return view('dashboard.products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->except('tags'));

        $tags = json_decode($request->post('tags'));

        $saved_tage = Tag::all();

        $tags_ids = [];

        foreach ($tags as $item) {

            $slug = Str::slug($item->value);

            $tag = $saved_tage->where('slug', $slug)->first(); // this is not a query, it's search in the collection

            if (! $tag) {
                $tag = Tag::create([
                    'name' => $item->value,
                    'slug' => $slug,
                ]);
            }

            $tags_ids[] = $tag->id;
        }

        // the sync function will check if the relation exists in the input it will create it
        $product->tags()->sync($tags_ids);

        return redirect()->route('dashboard.products.index')->with(
            'success', 'Product Updated'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
