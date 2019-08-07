<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client; 

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::where(function ($query) use($request){
            if ($request->input('keyword'))
            {
                $query->where(function ($query) use($request){
                    $query->where('name','like','%'.$request->keyword.'%');
                    $query->orWhere('mobile','like','%'.$request->keyword.'%');
                    $query->orWhere('email','like','%'.$request->keyword.'%');
                    $query->orWhereHas('city',function ($city) use($request){
                        $city->where('name','like','%'.$request->keyword.'%');
                    }); 
                });
            }
            if ($request->input('blood_type'))
            {
                $query->where('blood_type',$request->blood_type);
            }
        })->paginate(20);
        return view('clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        flash()->success('Deleted Successfully ..');
        return redirect(route('client.index'));
    }

    public function activate($id)
    {
        $client = Client::findOrFail($id);
        $client->update(['is_active'=> 1]);
        flash()->success('Activated');
        return back();
    } 

    public function deactivate($id)
    {
        $client = Client::findOrFail($id);
        $client->update(['is_active'=> 0]);
        flash()->success('De-Activated');
        return back();
    }

    // public function toggleActivation($id)
    // {
    //     $client = Client::findOrFail($id);
    //     $msg = 'تم التفعيل';
    //     if ($client->is_active)
    //     {
    //         $msg = 'تم إلغاء التفعيل';
    //         $client->update(['is_active' => 0]);
    //     }else{
    //         $client->update(['is_active' => 1]);
    //     }
    //     flash()->success($msg);
    //     return back();
    // }

}
