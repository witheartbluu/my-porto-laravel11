<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogApiController extends Controller
{
    public function index()
    {
        return response()->json(Blog::all());
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|max:255',
    //         'content' => 'required',
    //         'image' => 'required',
    //         'category' => 'required',
    //         'author' => 'required'
    //     ]);

    //     Blog::create($request->only(['title', 'content', 'image', 'category', 'author']));

    //     return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    // }
    public function store(Request $request)
    {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'author' => 'required|string|max:255',
        'image' => 'nullable|string|max:255',
        'category' => 'nullable|in:News,Education,Other',
    ]);

    $blog = Blog::create($validated);

    return response()->json($blog, 201);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required',
            'image' => 'nullable|string',
            'category' => 'required',
        ]);

        $blog->update($request->all());

        return response()->json($blog, 200);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully'], 200);
    }



    // public function show(Blog $blog)
    // {
    //     return response()->json($blog);
    // }
    public function show($id) {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }


    // public function update(Request $request, Blog $blog)
    // {
    //     $request->validate([
    //         'title' => 'required|max:255',
    //         'content' => 'required',
    //         'image' => 'required',
    //         'category' => 'required',
    //         'author' => 'required'
    //     ]);

    //     $blog->update($request->only(['title', 'content', 'image', 'category', 'author']));

    //     return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    // }

    public function adminIndex()
    {
        $blogs = Blog::all();
        return response()->json([
            'admin' => true,
            'blogs' => $blogs
    ]);
    }

}
