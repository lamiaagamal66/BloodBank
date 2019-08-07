@extends('layouts.app')

@section('page_title')
    Contacts   
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">List of Contacts </h3>
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
                                    'placeholder' => 'Search name | mobile'
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

                @if ('$reports')
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Name</th>
                                {{-- <th>Email</th> --}}
                                <th>Phone</th>
                                <th>Supject</th>
                                <th>Message</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr class="text-center">
                                    <td>{{$report->id}}</td>
                                    <td>{{$report->name}}</td>
                                    {{-- <td>{{$report->email}}</td> --}}
                                    <td>{{$report->phone}}</td>
                                    <td>{{$report->subject}}</td>
                                    <td>{{$report->message}}</td>
                                    <td>
                                        {!! Form::open([
                                            'action' => ['ContactController@destroy' , $report->id],
                                            'method' => 'delete'
                                        ]) !!}
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </button>
                                        {!! Form::close() !!}
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
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
