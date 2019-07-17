@extends('layouts.app')
@inject('client', 'App\Models\Client')
@inject('order', 'App\Models\Order')
@inject('category', 'App\Models\Category')
@inject('city', 'App\Models\City')
@inject('contact', 'App\Models\Contacts')
@inject('governorate', 'App\Models\Governorate')
@inject('post', 'App\Models\Post')
@section('page_title')
    BloodBank Dashboard   
@endsection
@section('small_title')
    Statistics
@endsection

@section('content')     
        <!-- Main content -->
       <section class="content">
            <!-- Default box -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">BloodBank DashBoard</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                
                <div class="card-body">
                    {{-- first row --}}
                    <div class="row">
                        
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Clients</span>
                                  <span class="info-box-number">{{$client->count()}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                
                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>
                
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-map"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Governorates</span>
                                  <span class="info-box-number">{{$governorate->count()}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-flag"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Cities</span>
                                  <span class="info-box-number">{{$city->count()}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-dark"><i class="fa fa-newspaper"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Categories</span>
                                  <span class="info-box-number">{{$category->count()}}</span>
                                </div>
                            <!-- /.info-box-content -->
                            </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    {{-- second row --}}
                    <div class="row">

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-sticky-note"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Posts</span>
                                  <span class="info-box-number">{{$post->count()}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                
                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>
                
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-secondary"><i class="fa fa-heart"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Donation Requests</span>
                                  <span class="info-box-number">{{$order->count()}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-pink"><i class="fas fa-envelope"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Contacts</span>
                                  <span class="info-box-number">{{$contact->count()}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->


                </div>   
                <!-- /.card-body -->
               
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->

@endsection
