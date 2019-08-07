@extends('layouts.app')

@section('page_title')
    Users  
@endsection

@section('content')

    <!-- Main content -->  
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                 {{-- flash message --}}
                 @include('flash::message')
                 @if ('$users')
                    <div class="table-responsive">
                        <table class="data-table table no-margin">
                            <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Role</th>
                                  <th>Created at</th>
                                  <th>Updated at</th>
                                  <th class="text-center">Edit</th>
                                  <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($users as $user)      
                                  <tr id="removable{{$user->id}}">
                                    <td>{{$count}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <label class="label label-info"> {{$role->display_name}}</label>
                                        @endforeach
                                    </td>
                                    <td>{{$user->created_at}}</td>
                                    <td>{{$user->updated_at}}</td>
                                   
                                    <td class="text-center">
                                        {{-- @if (Hash::check($user->email , optional(auth()->user())->email )) --}}
                                        <a href="{{url(route('user.edit' , $user->id ))}}" class="btn btn-success btn-xs">
                                        <i class="fa fa-edit"></i>
                                            
                                        </a>
                                        {{-- @endif --}}
                                         
                                    </td> 
                                    <td class="text-center">
                                            {!! Form::open([
                                                'action' => ['UserController@destroy' , $user->id],
                                                'method' => 'delete'
                                            ]) !!}
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i>
                                                
                                            </button>
                                            {!! Form::close() !!}
                                    </td> 
                                  </tr>
                                @php $count ++; @endphp  
                                @endforeach  
                            </tbody>       
                        </table>
                    </div>
                    <div class="text-center">
                        {!! $users->render() !!}
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        No Data 
                    </div>
                @endif
                    
            </div>
            <div class="card-footer">
                <a href="{{url(route('user.create'))}}" class="btn btn-primary btn-xs">
                    <i class="fa fa-plus"></i>
                    New User
                </a>
            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
