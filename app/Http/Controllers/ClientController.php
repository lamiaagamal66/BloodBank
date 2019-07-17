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
    public function index()
    {
        $clients = Client::latest()->paginate(20);
        return view('clients.index', compact('clients'));
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
        $client->update(['is_active'=> 1 ,'status'=>'Activated']);
        flash()->success('Activated');
        return back();
    }

    public function deactivate($id)
    {
        $client = Client::findOrFail($id);
        $client->update(['is_active'=> 0 ,'status'=>'De-Activated']);
        flash()->success('De-Activated');
        return back();
    }

    public function search(Request $request) {
        $constraints = [
            'name' => $request['name'],
            'blood_type' => $request['blood_type']
            // 'city' => $request['city']
            ];

       $clients = $this->doSearchingQuery($constraints);
       return view('clients.index', ['clients' => $clients, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Client::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
}
