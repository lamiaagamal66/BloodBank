@extends('layouts.app')

@section('page_title')
  Client Inormation   
@endsection

@section('content')

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
          {{-- flash message --}}
          @include('flash::message')
            @if ('$client')
            <div class="table-responsive">
                <table class="table margin">
                    <tbody>       
                        <tr>
                          <th>ID :</th>
                          <td>{{$client->id}}</td>
                        </tr>
                        <tr> 
                          <th>Name :</th>
                          <td>{{$client->name}}</td> 
                        </tr>       
                        <tr> 
                          <th>Email :</th>
                          <td>{{$client->email}}</td> 
                        </tr>  
                        <tr>
                           <th>Created at :</th>
                           <td>{{$client->created_at}}</td>
                        </tr>
                        <tr>
                          <th>Updated at :</th>
                          <td>{{$client->updated_at}}</td>
                        </tr>     
                        <tr> 
                          <th>Birth Date :</th>
                          <td>{{$client->date_of_birth}}</td> 
                        </tr>       
                        <tr> 
                          <th>Last Donate :</th>
                          <td>{{$client->last_donate}}</td> 
                        </tr>       
                        <tr> 
                          <th>Mobile :</th>
                          <td>{{$client->mobile}}</td> 
                        </tr>       
                        <tr> 
                          <th>BloodType :</th>
                          <td>{{$client->blood_type}}</td> 
                        </tr> 
                        <tr> 
                          <th>City :</th>
                          <td>{{$client->city_id}}</td>
                            {{-- {{optional($client->cities)->name}} --}}
                        </tr>     
                    </tbody>  
                </table>
            </div>
            @else
                <div class="alert alert-danger" role="alert">
                    No Data 
                </div>
            @endif
        </div>

        <div class="card-footer">
            <div class="row ">
                @if ($client->is_active)
                  <a href="{{url(route('client.deactivate' , $client->id ))}}" class="btn btn-warning btn-xs ml-3">   
                      De-Activate
                  </a>
                @else
                  <a href="{{url(route('client.activate' , $client->id ))}}" class="btn btn-success btn-xs ml-3">
                      Activate
                  </a>
                @endif    
                {!! Form::open([
                    'action' => ['ClientController@destroy' , $client->id],
                    'method' => 'delete'
                ]) !!}
                <button type="submit" class="btn btn-danger btn-xs ml-3">
                    <i class="fa fa-trash"></i>
                    Delete
                </button>
                {!! Form::close() !!}
            </div>
            
        </div>


    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
