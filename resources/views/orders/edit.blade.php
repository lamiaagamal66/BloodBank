@extends('layouts.app')

@section('page_title')
  Request Details  
@endsection

@section('content')

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            @include('partials.validation_errors')
            {{-- flash message --}}
            @include('flash::message')

           {!! Form::model($model,[
               'action' => ['OrderController@update' , $model->id],
               'method' => 'put'
           ]) !!}
           @include('orders.form')
           {!! Form::close() !!}
            
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
