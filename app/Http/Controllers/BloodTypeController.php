<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodType;

class BloodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = BloodType::paginate(20);
        return view('bloodTypes.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bloodTypes.create');
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
            'name' =>'required',
        ];
        $messages = [
            'name.required' => 'Name is Required',
        ];
        $this->validate($request, $rules , $messages);
        $record = new BloodType;
        $record->name = $request->input('name');
        $record->save();

        flash()->success('Successfully Added..');
        return redirect(route('bloodType.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = BloodType::findOrFail($id);
        return view('bloodTypes.edit', compact('model'));
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
        $record = BloodType::findOrFail($id);
        $record->update($request->all());
        flash()->success('Edited Successfully ..');
        return redirect(route('bloodType.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = BloodType::findOrFail($id);
        $record->delete();
        flash()->success('Deleted Successfully ..');
        return redirect(route('bloodType.index'));
    }
}
