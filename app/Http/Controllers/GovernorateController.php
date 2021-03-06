<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Governorate;

 
class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Governorate::paginate(20);
        return view('governorates.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('governorates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' =>'required'
        ];
        $messages = [
            'name.required' => 'Name is Required'
        ];
        $this->validate($request, $rules , $messages);
        // dd("here");
        $record = new Governorate;
        $record->name = $request->input('name');
        $record->save();
        // $record = Governorate::create($request->all());

        flash()->success('Governorate added Successfully ..');
        return redirect(route('governorate.index'));
        
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
        $model = Governorate::findOrFail($id);
        return view('governorates.edit', compact('model'));
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
        $record = Governorate::findOrFail($id);
        $record->update($request->all());
        flash()->success('Edited Successfully ..');
        // return back();
        return redirect(route('governorate.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Governorate::findOrFail($id);
        // $record->delete();
        // flash()->success('Deleted Successfully ..');
        // return back();
        // return redirect(route('governorate.index'));

        if (!$record) {
            return response()->json([
                'status'  => 0,
                'message' => 'Fail To get information'
            ]);
        }
        if($record->cities()->count())
        {
            return response()->json([
                    'status' => 0,
                    'message' => 'Can not delete there is related',
                ]);
        }
        $record->delete();
        return response()->json([
                'status'  => 1,
                'message' =>'Deleted Successfully ..',
                'id'      => $id
            ]);
    
    }
}
