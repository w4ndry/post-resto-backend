<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->input('name'), function($query, $name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);
        $type_menu = 'categories';

        return view('pages.categories.index', compact('categories', 'type_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'categories';

        return view('pages.categories.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'description'   => 'required',
            'image'         => 'required',
        ]);

        try {
            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $category->id . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/categories', $imageName);
                $category->image = 'public/categories' . $imageName;
                $category->save();
            }

            return redirect()->route('categories.index')->with('success', 'Category created successfully');
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
        $category = Category::findOrFail($id);
        $type_menu = 'categories';

        return view('pages.categories.edit', compact('category', 'type_menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'          => 'required',
            'description'   => 'required',
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $category->id . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/categories', $imageName);
                $category->image = 'public/categories' . $imageName;
                $category->save();
            }

            return redirect()->route('categories.index')->with('success', 'Category updated successfully');
        } catch (Exception $e) {
            dd($e->getMessage());
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
        $product = Category::find($id);
        $product->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
