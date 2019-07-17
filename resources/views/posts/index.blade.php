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

                @if ('$records')
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Show</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td>{{$record->id}}</td>
                                        <td>{{$record->title}}</td>
                                        <td> 
                                            <a href="{{url(route('post.show' , $record->id ))}}" class="btn btn-info btn-xs">
                                                <i class="fa fa-info"></i>
                                                 Show Details
                                            </a>
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
