@extends('layouts.app')

@section('page_title')
  Edit BloodType   
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Edit BloodType </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>

            <div class="card-body">
                @include('partials.validation_errors')
                 {{-- flash message --}}
                 @include('flash::message')

                {!! Form::model($model,[
                    'action' => ['BloodTypeController@update' , $model->id],
                    'method' => 'put'
                ]) !!}
                @include('bloodTypes.form')
                {!! Form::close() !!}
            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
