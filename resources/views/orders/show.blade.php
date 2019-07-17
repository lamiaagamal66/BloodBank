@extends('layouts.app')

@section('page_title')
  Request Details  
@endsection

@section('content')

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            @if ('$order')
            <div class="table-responsive">
                <table class="table">
                    <tbody>       
                        <tr>
                          <th>No :</th>
                          <td>{{$order->id}}</td>
                        </tr>
                        <tr> 
                          <th>From :</th>
                          <td>{{$order->name}}</td> 
                        </tr>       
                        <tr> 
                          <th>Age :</th>
                          <td>{{$order->age}}</td> 
                        </tr>  
                        <tr> 
                          <th>Mobile :</th>
                          <td>{{$order->mobile}}</td> 
                        </tr>
                        <tr>
                           <th>Created at :</th>
                           <td>{{$order->created_at}}</td>
                        </tr>
                        <tr>
                          <th>Updated at :</th>
                          <td>{{$order->updated_at}}</td>
                        </tr>     
                        <tr> 
                          <th>Quantity :</th>
                          <td>{{$order->quantity}}</td> 
                        </tr>       
                        <tr> 
                          <th>Hospital Name :</th>
                          <td>{{$order->hospital_name}}</td> 
                        </tr>       
                        <tr> 
                          <th>Hospital Address :</th>
                          <td>{{$order->hospital_address}}</td> 
                        </tr>       
                        <tr> 
                          <th>BloodType :</th>
                          <td>{{$order->blood_type}}</td> 
                        </tr> 
                        <tr> 
                          <th>Notes :</th>
                          <td>{{$order->note}}</td> 
                        </tr>     
                        <tr> 
                          <th>City :</th>
                          <td>{{optional($order->city)->name}}</td> 
                        </tr>     
                        <tr> 
                          <th>Client ID :</th>
                          <td>{{$order->client_id}}</td> 
                        </tr>     
                        <tr> 
                          <th>Latitude :</th>
                          <td>{{$order->latitude}}</td> 
                        </tr>     
                        <tr> 
                          <th>Longtude :</th>
                          <td>{{$order->longtude}}</td> 
                        </tr>     
                    </tbody>  
                </table>
            </div>
            @else
                <div class="alert alert-danger" role="alert">
                    No Data 
                </div>
            @endif

            <a href="{{url(route('order.index'))}}" class="btn btn-success">
                <i class="fa fa-mail-reply"></i>
                 Back 
            </a>
            {{-- {!! Form::open([
                'action' => ['OrderController@destroy' , $order->id],
                'method' => 'delete'
            ]) !!}
            <button type="submit" class="btn btn-danger btn-xs">
                <i class="fa fa-trash"></i>
                Delete
            </button>
            {!! Form::close() !!} --}}
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
