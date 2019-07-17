<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Post::paginate(20);
        return view('posts.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' =>'required',
            'body' =>'required',
            'category_id' =>'required'
        ];
        $messages = [
            'title.required' => 'Post Title is Required',
            'body.required' => 'Post Body is Required',
            'category_id.required' => 'Category_id is Required'
        ];
        $this->validate($request, $rules , $messages);
        // dd("here");
        $record = Post::create($request->all());

        flash()->success('Successfully Added..');
        return redirect(route('post.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Post::findOrFail($id);
        return view('posts.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Post::findOrFail($id);
        return view('posts.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = Post::findOrFail($id);
        $record->update($request->all());
        flash()->success('Edited Successfully ..');
        // return back();
        return redirect(route('post.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Post::findOrFail($id);
        $record->delete();
        flash()->success('Deleted Successfully ..');
        // return back();
        return redirect(route('post.index'));
    }
}
