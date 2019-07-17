@extends('layouts.app')

@section('page_title')
    Change Password  
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

                {!! Form::open([
                    'action' => 
                        'UserController@changePasswordSave' ,
                        'method' => 'Post'
                ]) !!}
                <div class="form-group">
                    <label for="old-password">Current Password</label>
                    {!! Form::password('old-password',[
                        'class' => 'form-control'
                    ]) !!}
                </div> 

                <div class="form-group">
                    <label for="password">New Password</label>
                    {!! Form::password('password',[
                        'class' => 'form-control'
                    ]) !!}
                </div> 
                <div class="form-group">
                    <label for="password_confirmation">Password Confirmation</label>
                    {!! Form::password('password_confirmation',[
                        'class' => 'form-control'
                    ]) !!}
                </div> 
                <div class="form-group">
                        <button class="btn btn-primary" type="submit"> Update</button>
                    </div>
                {!! Form::close() !!}  
  
            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
