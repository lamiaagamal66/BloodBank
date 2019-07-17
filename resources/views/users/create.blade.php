@extends('layouts.app')

@inject('model', 'App\User')

@section('page_title')
  Create User   
@endsection 

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
             {{-- flash message --}}
             @include('flash::message')
             @include('partials.validation_errors')

            <div class="card-body">
                {!! Form::model($model,[
                    'action' =>  'UserController@store',
                    // 'method' => 'Post'
                ]) !!}
                @include('users.form')
                {!! Form::close() !!}
            </div>  
        </div>
            <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
