<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blood Bank</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li> 
        </ul> 
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
            </li>  
        </ul>             
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{url('/home')}}" class="brand-link">
            <img src="{{asset('adminlte/img/AdminLTELogo.png')}}"
                 alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Blood Bank</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar mt-3">
            <!-- Sidebar user (optional) -->
            @if (Auth::User())
            <div class="user-panel ">
                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <div class="image"><img src="{{asset('adminlte/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image"></div>
                                <p>
                                    {{optional(auth()->user())->name}}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url(route('user.changePassword'))}}" class="nav-link">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p> Reset Password </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{url(route('user.edit' , optional(auth()->user())->id ))}}" class="nav-link">
                                        <i class="nav-icon far fa-circle"></i>
                                       <p> Edit Information </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{url(route('user.logout'))}}" class="nav-link">
                                        <i class="nav-icon far fa-circle"></i>
                                       <p> Logout </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            @endif

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    {{-- Users  --}}
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p> User 
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{url(route('user.index'))}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> Users </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url(route('role.index'))}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> Roles </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    
                    {{--Clients--}}
                    <li class="nav-item">
                        <a href="{{url(route('client.index'))}}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p> Clients </p>
                        </a>
                    </li>

                    {{-- Governorates --}}
                    <li class="nav-item">
                        <a href="{{url(route('governorate.index'))}}" class="nav-link">
                            <i class="nav-icon fas fa-map"></i>
                            <p> Governorates </p>
                        </a>
                    </li>
                    
                    {{-- Cities --}}
                    <li class="nav-item">
                        <a href="{{url(route('city.index'))}}" class="nav-link">
                            <i class="nav-icon fas fa-flag"></i>
                            <p> Cities </p>
                        </a>
                    </li>

                    {{-- Categories --}}
                    <li class="nav-item">
                        <a href="{{url(route('category.index'))}}" class="nav-link">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p> Categories </p>
                        </a>
                    </li>

                    {{-- Post--}}
                    <li class="nav-item">
                        <a href="{{url(route('post.index'))}}" class="nav-link">
                            <i class="nav-icon fas fa-sticky-note"></i>
                            <p> Posts</p>
                        </a>
                    </li>

                    {{-- Requests --}}
                    <li class="nav-item">
                        <a href="{{url(route('order.index'))}}" class="nav-link">
                            <i class="nav-icon fas fa-heart"></i>
                            <p> Requests </p>
                        </a>
                    </li>

                    {{-- Contacts --}}
                    <li class="nav-item">
                        <a href="{{url(route('contact.index'))}}" class="nav-link">
                            <i class="nav-icon fas  fa-envelope"></i>
                            <p>  Contacts </p>
                        </a>
                    </li>

                    {{-- Settings --}}
                    <li class="nav-item">
                        <a href="{{url(route('setting.index'))}}" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p> Settings </p>
                        </a>
                    </li>
                    
                    {{-- BloodTypes --}}
                    <li class="nav-item">
                        <a href="{{url(route('bloodType.index'))}}" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p> BloodTypes </p>
                        </a>
                    </li>

                                       
                    <li class="nav-header">MISCELLANEOUS</li>
                    <li class="nav-item">
                        <a href="https://adminlte.io/docs" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>Documentation</p>
                        </a>
                    </li>     
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            @yield('page_title')
                            <small> @yield('small_title') </small>
                        </h1> 
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active"> @yield('page_title') </li>
                        </ol>
                    </div>
                </div>
            </div> <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        @yield('content') 
     
      {{--  <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Title</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    Start creating your amazing application!
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Footer
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section> --}}
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.0-beta.1
        </div>
        <strong>Copyright &copy; 2014-2018 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('adminlte/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('adminlte/js/demo.js')}}"></script>
@stack('scripts')
</body>
</html>
