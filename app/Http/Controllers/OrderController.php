<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Order;
use App\Models\BloodType;
use App\Models\City;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::where(function ($query) use($request){
            if ($request->input('keyword'))
            {
                $query->where(function ($query) use($request){
                    $query->where('name','like','%'.$request->keyword.'%');
                    $query->orWhere('age','like','%'.$request->keyword.'%');
                    $query->orWhere('quantity','like','%'.$request->keyword.'%');
                    $query->orWhere('hospital_name','like','%'.$request->keyword.'%');
                    $query->orWhere('hospital_address','like','%'.$request->keyword.'%');
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
        return view('orders.index',compact('orders'));
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bloodtypes = BloodType::pluck('name', 'id')->toArray();
        $cities = City::pluck('name', 'id')->toArray();
        $model = Order::findOrFail($id);
        return view('orders.edit', compact('model', 'bloodtypes', 'cities'));
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
            'name' => 'required',
            'age'  => 'required',
            'hospital_name'    => 'required',
            'hospital_address' => 'required',
            'quantity'  => 'required',
            'mobile'    => 'required',
            'blood_type'  => 'required',
            'city_id'     => 'required',
            // 'notes'       => 'required',
        ];
        $this->validate($request, $rules);
        $record = Order::findOrFail($id);
        $record->update($request->all());
        flash()->success('Updated Successfully');
        return redirect(route('order.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        flash()->success('Deleted Successfully ..');
        return redirect(route('order.index'));
    }

}
