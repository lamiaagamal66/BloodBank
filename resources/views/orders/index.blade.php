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

                @if ('$orders')
                <form method="POST" action="{{ route('order.search') }}">
                        {{ csrf_field() }}
                        @component('layouts.search', ['title' => 'Search'])
                            @component('layouts.two-cols-search-row', ['items' => ['Name', 'Blood_Type'], 
                            'oldVals' => [isset($searchingVals) ? $searchingVals['name'] : '', isset($searchingVals) ? $searchingVals['blood_type'] : '']])
                            @endcomponent
                            @component('layouts.two-cols-search-row', ['items' => ['Age', 'Hospital_Name'], 
                            'oldVals' => [isset($searchingVals) ? $searchingVals['age'] : '', isset($searchingVals) ? $searchingVals['hospital_name'] : '']])
                            @endcomponent
                            {{-- @component('layouts.two-cols-search-row', ['items' => ['City'], 'oldVals' => [isset($searchingVals) ? $searchingVals['city'] : '']])
                            @endcomponent --}}
                        @endcomponent
                    </form> <br>
                <div class="table-responsive">
                    
                    <table class="table no-margin">
                        <thead>
                            <tr class="text-center">
                              <th>No</th>
                              <th>Name</th>
                              <th>Blood Type</th>
                              <th></th>
                              <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)      
                              <tr class="text-center">
                                <td>{{$order->id}}</td>
                                <td>{{$order->name}}</td>
                                <td>{{$order->blood_type}}</td>
                                <td> 
                                    <a href="{{url(route('order.show' , $order->id ))}}" class="btn btn-info btn-xs">
                                            <i class="fa fa-info"></i>
                                             Show Details
                                    </a>
                                </td>
                                <td> 
                                    {!! Form::open([
                                        'action' => ['OrderController@destroy' , $order->id],
                                        'method' => 'delete'
                                    ]) !!}
                                    <button type="submit" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i>
                                        Delete
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
