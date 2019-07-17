<div class="box">
  
    <div class="card-header ">
      <h4 class="card-title">{{isset($title) ? $title : 'Search'}}</h4>
      <div class="card-tools pull-right">
        <button type="button" class="btn btn-card-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
      {{ $slot }}
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <button type="submit" class="btn btn-primary ml-3">
        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
        Search
      </button>
    </div>
</div>