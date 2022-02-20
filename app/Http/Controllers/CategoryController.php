<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id','desc')->get();

        return view('backend.category.index', compact('categories'));
    }


    public function create()
    {
        return view('backend.category.create');
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'status' => 'nullable|integer',
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->status = $request->input('status');

        $category->save();

        return redirect()->route('category.index')->with(['msg' => 'Category Added Successfully', 'type' => 'success']);

    }


    public function edit($category_id)
    {
        $category = Category::find($category_id);

        return view('backend.category.edit', compact('category'));
    }


    public function update(Request $request, $category_id)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'nullable|integer',
        ]);

        $category = Category::find($category_id);
        $category->name = $request->input('name');
        $category->status = $request->input('status');

        $category->save();

        return redirect()->route('category.index')->with(['msg' => 'Category Updated Successfully', 'type' => 'success']);
    }


    public function destroy($category_id)
    {
        $category = Category::find($category_id);
        $category->delete();

        return redirect()->route('category.index')->with(['msg' => 'Category has been deleted', 'type' => 'success']);
    }
}
