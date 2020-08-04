<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories=Category::orderBy('created_at','DESC')->paginate(3);
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories=Category::all();
        return view('admin.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title'=>'required|min:5',
            'slug'=>'required|min:5|unique:categories'
        ]);
        //dd($request);
        $categories=Category::create($request->only('title','description','slug'));
        $categories->childrens()->attach($request->parent_id);
        return back()->with('message','Category added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        $categories=Category::where('id','!=',$category->id)->get();
        return view('admin.categories.create',['categories'=>$categories,'category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $request->validate([
            'title'=>'required|min:5',
            'slug'=>'required|min:5|unique:categories'
        ]);
        $category->title=$request->title;
        $category->description=$request->description;
        $category->slug=$request->slug;
        $category->childrens()->detach();
        $category->childrens()->attach($request->parent_id);
        $saved=$category->save();
        if($saved)
        {
            return back()->with('message','Record successfully updated');
        }
        else
        {
            return back()->with('message','Record not updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        if ($category->childrens()->detach() && $category->forceDelete()) {
            # code...
            return back()->with('message','Record Successfully Deleted');
        } else {
            # code...
            return back()->with('message','Record not deleted');
        }
        
    }
    public function trash()
    {
        $categories=Category::onlyTrashed()->orderBy('created_at','DESC')->paginate(3);
        return view('admin.categories.index',['categories'=>$categories ,'checktrash'=>'Yes']);
    }
    public function recover($id)
    {
        $category=Category::withTrashed()->findOrFail($id);
        if ($category->restore()) {
            # code...
            return back()->with('message','Record Successfully recoverd');
        } else {
            # code...
            return back()->with('message','Record not recovered');
        }
    }
    public function remove(Category $id)
    {
        if ($id->delete()) {
            # code...
            return back()->with('message','Record Successfully Trash');
        } else {
            # code...
            return back()->with('message','Record not trash');
        }
    }
}
