@extends('layouts.app')

@section('page_title')
    Cities   
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">List of Cities </h3>
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
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Governorate</th>
                                   <th></th>
                                   <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr class="text-center">
                                        <td>{{$record->id}}</td>
                                        <td>{{$record->name}}</td>
                                        <td>{{optional($record->governorate)->name}}</td>
                                        <td>
                                            <a href="{{url(route('city.edit' , $record->id ))}}" class="btn btn-success btn-xs">
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            {!! Form::open([
                                                'action' => ['CityController@destroy' , $record->id],
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

                <a href="{{url(route('city.create'))}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                         New City
                </a>
  
            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
