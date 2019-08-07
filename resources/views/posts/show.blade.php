@extends('layouts.app')

@section('page_title')
  Post Inormation   
@endsection

@section('content')
<!-- Main content -->
<section class="content">
        <!-- Default box -->
    <div class="card">
        @if ('$record')
        <h3 class="card-header">{{$record->title}}</h3>
        <div class="card-body">
            <div> {{$record->body}} </div><br>  
            <div>Category of : {{optional($record->category)->name}} </div><br>
            <span class="time"><i class="fa fa-clock"></i> Created at : {{$record->created_at}}</span><br><br>
            <a href="{{url(route('post.edit' , $record->id ))}}" class="btn btn-success btn-xs">
                <i class="fa fa-edit"></i>
                Edit
            </a>
            <a href="{{url(route('post.create'))}}" class="btn btn-primary btn-xs">
                <i class="fa fa-plus"></i>
                 Create Post
            </a>     
        </div>
        <div class="card-footer"> 
                {!! Form::open([
                    'action' => ['PostController@destroy' , $record->id],
                    'method' => 'delete'
                    ]) !!}
                    <button type="submit" class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                        Delete
                    </button>
                    {!! Form::close() !!}
        </div>
        @else
            <div class="alert alert-danger" role="alert">
                No Data 
            </div>
        @endif
        
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection






