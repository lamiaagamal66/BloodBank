@extends('layouts.app')

@section('page_title')
    Clients   
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            {{-- card header --}}
            <div class="card-header">
                <h3 class="card-title">List of Latest Clients </h3>
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

                <form method="POST" action="{{ route('client.search') }}">
                    {{ csrf_field() }}
                    @component('layouts.search', ['title' => 'Search'])
                        @component('layouts.two-cols-search-row', ['items' => ['Name', 'Blood_Type'], 
                        'oldVals' => [isset($searchingVals) ? $searchingVals['name'] : '', isset($searchingVals) ? $searchingVals['blood_type'] : '']])
                        @endcomponent
                        
                        {{-- @component('layouts.two-cols-search-row', ['items' => ['City'],
                        'oldVals' => [isset($searchingVals) ? $searchingVals['city'] : '']])
                        @endcomponent --}}
                   @endcomponent
                 </form> <br>

                @if ('$clients')
                    <div class="row">
                        <div class="col-sm-12 ">
                            <table class="table no-margin table-responsive">
                                <thead>
                                    <tr role="row">
                                      <th >ID</th>
                                      <th >Name</th>
                                      <th >Email</th>
                                      <th >Data Of Birth</th>
                                      <th >Last Donate</th>
                                      <th >Mobile</th>
                                      <th >Blood Type</th>
                                      <th >City</th>
                                      <th >Is_Active</th>
                                      <th >Delete</th>
                                    </tr>
                                </thead>

                                <tbody> 
                                    @foreach ($clients as $client)      
                                    <tr role="row" class="odd">
                                      <td>{{$client->id}}</td>
                                      <td>{{$client->name}}</td>
                                      <td>{{$client->email}}</td>
                                      <td>{{$client->date_of_birth}}</td>
                                      <td>{{$client->last_donate}}</td>
                                      <td>{{$client->mobile}}</td>
                                      <td>{{$client->blood_type}}</td>
                                      <td>{{optional($client->cities)->name}}</td>
                                      <td>
                                        @if ($client->is_active)
                                            <a href="{{url(route('client.deactivate' , $client->id ))}}" class="btn btn-warning btn-xs ">   
                                                De-Activate
                                            </a>
                                        @else
                                            <a href="{{url(route('client.activate' , $client->id ))}}" class="btn btn-success btn-xs ">
                                                Activate
                                            </a>
                                        @endif    
                                      </td>
                                      <td> 
                                        {!! Form::open([
                                            'action' => ['ClientController@destroy' , $client->id],
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
