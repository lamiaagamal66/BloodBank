<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
// use Intervention\Image\ImageManagerStatic as Image;
use Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Post::where(function ($query) use($request){
            if ($request->input('keyword'))
            {
                $query->where(function ($query) use($request){
                    $query->orWhereHas('category',function ($category) use($request){
                        $category->where('name','like','%'.$request->keyword.'%');
                    }); 
                });
            }
        })->paginate(20);
        return view('posts.index', compact('records'));
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->toArray();
        return view('posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'Post Title is Required',
            'body.required' => 'Post Body is Required',
            'category_id.required' => 'Category_id is Required',
            'image.required' => 'image is Required',
            'publish_date.required' => 'publish_date is Required'
        ];
        $rules = [
            'title' =>'required',
            'body' =>'required',
            'category_id' =>'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'publish_date' => 'required',  
        ];
        
        $this->validate($request, $rules , $messages);
        // dd("here");
        $record = Post::create($request->all());

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/images/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $record->image = 'uploads/images/' . $name;
        }
        $record->save();
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
        $rules = [
            'title' =>'required',
            'body' =>'required',
            'category_id' =>'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'publish_date' => 'required',  
        ];
        $messages = [
            'title.required' => 'Post Title is Required',
            'body.required' => 'Post Body is Required',
            'category_id.required' => 'Category_id is Required',
            'image.required' => 'image is Required',
            'publish_date.required' => 'publish_date is Required'
        ];
        $this->validate($request, $rules , $messages);

        $record = Post::findOrFail($id);
        $record->update($request->all());

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(100, 100)->save( public_path('/uploads/' . $filename ) );
            $record->image = $filename;
                $record->save();
            }
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
