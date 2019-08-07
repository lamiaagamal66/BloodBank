@extends('layouts.app')

@section('page_title')
    Posts   
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card"> 

            <div class="card-header">
                <h3 class="card-title">List of All Posts </h3>
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
                                    'placeholder' => 'Search Category'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
    

                @if ('$records')
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th class="text-center">القسم</th>
                                    <th class="text-center">Body</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Edit </th>
                                    <th class="text-center">Delete</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr id="removable{{$record->id}}">
                                        <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->title}}</td>
                                    <td class="text-center">{{$record->category->name}}</td>
                                    <td class="text-center">{{$record->body}}</td>
                                    <td>
                                        <img src="{{asset($record->image)}}"  class="img-circle" style="max-width: 50px;">
                                    </td>

                                    <td class="text-center">
                                        <a href="{{url(route('post.edit',$record->id))}}" class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                            
                                        </a>
                                    </td>

                                    <td class="text-center">
                                            {!! Form::open([
                                                'action' => ['PostController@destroy' , $record->id],
                                                'method' => 'delete'
                                            ]) !!}
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            {!! Form::close() !!}
                                    </td>
 
                                       
                                        {{-- <td> 
                                            <a href="{{url(route('post.show' , $record->id ))}}" class="btn btn-info btn-xs">
                                                <i class="fa fa-info"></i>
                                                 Show Details
                                            </a>
                                        </td> --}}
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

                <a href="{{url(route('post.create'))}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                         New Post
                </a>
  
            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
