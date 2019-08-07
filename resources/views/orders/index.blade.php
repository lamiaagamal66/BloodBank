@extends('layouts.app')

@section('page_title')
    Clients Requests  
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            {{-- header --}}
            <div class="card-header">
                <h3 class="card-title">List of Requests </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>

            <div class="card-body">
                {{-- flash message --}}
                @include('flash::message')
                <div class="filter">
                    {!! Form::open([
                        'method' => 'get'
                    ]) !!}

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::text('keyword',request('keyword'),[
                                    'class' => 'form-control',
                                    'placeholder' => 'Search ...'
                                ]) !!}
                            </div>
                        </div>
                        @inject('bloodType','App\Models\BloodType')
                        <div class="col-sm-3">
                            {!! Form::select('blood_type',$bloodType->pluck('name','name')->toArray(),request('blood_type'),[
                                    'class' => 'form-control',
                                    'placeholder' => 'Search bloodType'
                                ]) !!}
                        </div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                @if ('$orders')
                <div class="table-responsive">
                    
                    <table class="table no-margin">
                        <thead>
                            <tr class="text-center">
                              <th>No</th>
                              <th>Name</th>
                              <th>Age</th>
                              <th>Mobile</th>
                              <th>Blood Quantity</th>
                              <th>Hospital Name</th>
                              <th>Hospital Address</th>
                              <th>Blood Type</th>
                              <th>City</th>
                              <th>Notes</th>
                              <th>Edit</th>
                              <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)      
                              <tr class="text-center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$order->name}}</td>
                                <td>{{$order->age}}</td>
                                <td>{{$order->mobile}}</td>
                                <td>{{$order->quantity}}</td>
                                <td>{{$order->hospital_name}}</td>
                                <td>{{$order->hospital_address}}</td>
                                <td>{{$order->blood_type}}</td>
                                <td>{{optional($order->city)->name}}</td>
                                <td>{{$order->note}}</td>
                                <td class="text-center">
                                    <a href="{{url(route('order.edit',$order->id))}}" class="btn btn-success btn-xs">
                                        <i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                        {!! Form::open([
                                            'action' => ['OrderController@destroy' , $order->id],
                                            'method' => 'delete'
                                        ]) !!}
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i>
                                            
                                        </button>
                                        {!! Form::close() !!}
                                </td>
                              </tr>
                            @endforeach  
                        </tbody>     
                    </table>
                </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        No Data 
                    </div>
                @endif
            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
