@extends('layouts.app')

@section('page_title')
 Update Setting   
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

                {!! Form::model($item,[
                    'action' => ['SettingController@update' , $item->id],
                    'method' => 'put'
                ]) !!}
                @include('settings.form')
                {!! Form::close() !!}
            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
