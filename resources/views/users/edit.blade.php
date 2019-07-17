@extends('layouts.app')

@section('page_title')
  Edit User   
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                 {{-- flash message --}}
                @include('flash::message')
                @include('partials.validation_errors')
                {!! Form::model($model,[
                    'action' =>  ['UserController@update' , $model->id],
                    'method' => 'put'
                ]) !!}
                @include('users.form')
                {!! Form::close() !!}
            </div>  
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
