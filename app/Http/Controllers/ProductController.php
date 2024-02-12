<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::when($request->input('name'), function($query, $name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);
        $type_menu = 'products';

        return view('pages.products.index', compact('products', 'type_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $type_menu = 'products';

        return view('pages.products.create', compact('categories', 'type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'   => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric',
            'image'         => 'required',
            'status'        => 'required|boolean',
            'is_favorite'   => 'required|boolean',
        ]);

        try {
            $product = new Product();
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->status = $request->status;
            $product->is_favorite = $request->is_favorite;
            $product->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $product->id . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/products', $imageName);
                $product->image = 'public/products' . $imageName;
                $product->save();
            }

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
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
        $categories = Category::all();
        $type_menu = 'products';

        return view('pages.products.edit', compact('product', 'categories', 'type_menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id'   => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric',
            'status'        => 'required|boolean',
            'is_favorite'   => 'required|boolean',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->status = $request->status;
            $product->is_favorite = $request->is_favorite;
            $product->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $product->id . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/products', $imageName);
                $product->image = 'public/products' . $imageName;
                $product->save();
            }

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
