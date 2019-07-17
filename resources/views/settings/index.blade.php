@extends('layouts.app')
@inject('model', 'App\Models\Setting')

@section('page_title')
  Settings   
@endsection

@section('content')

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            @if ('$item')
            
            <table class="table margin">
                    <tbody> 
                            @foreach ($item as $item)      
                        <tr>
                          <th>Facebook Link :</th>
                          <td>{{$item->fb_link}}</td>
                        </tr>
                        <tr> 
                          <th>Twitter Link :</th>
                          <td>{{$item->tw_link}}</td> 
                        </tr>       
                        <tr> 
                          <th>Insta Link :</th>
                          <td>{{$item->insta_link}}</td> 
                        </tr>  
                        <tr>
                           <th>WhatsApp Link :</th>
                           <td>{{$item->whatsApp_link}}</td>
                        </tr>
                        <tr>
                          <th>Youtube Link :</th>
                          <td>{{$item->youtube_link}}</td>
                        </tr>     
                        <tr> 
                          <th>Google Plus Link :</th>
                          <td>{{$item->g_plus_link}}</td> 
                        </tr>       
                        <tr> 
                          <th>Mobile :</th>
                          <td>{{$item->mobile}}</td> 
                        </tr>       
                        <tr> 
                          <th>Email :</th>
                          <td>{{$item->email}}</td> 
                        </tr>       
                        <tr> 
                          <th>About App :</th>
                          <td>{{$item->about_app}}</td> 
                        </tr>
                        @endforeach 
                    </tbody>  
                </table>
            
            @else
                <div class="alert alert-danger" role="alert">
                    No Data 
                </div>
            @endif

            <a href="{{url(route('setting.edit' , $item->id ))}}" class="btn btn-success btn-xs">
                    <i class="fa fa-edit"></i>
                    Update
                </a>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
