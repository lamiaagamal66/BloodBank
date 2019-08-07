
@inject('categories','App\Models\Category')
<div class="form-group">
    <label for="image">Choose  Image : </label>
    {!! Form::file('image', [
    // 'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <label for="title">Title :</label>
    {!! Form::text('title',null,[
        'class' => 'form-control'
    ]) !!}
    <label for="body">Body :</label>
    {!! Form::text('body',null,[
        'class' => 'form-control'
    ]) !!}
    <label for="select">Category :</label>
    {!! Form::select('category_id',$categories->pluck('name','id')->toArray(),null,[
        'class' => 'form-control'
    ]) !!}

    <label for="publish_date">Publish Date :  </label>
    {{ Form::date('publish_date', null, [
        'class' => 'form-control'
    ]) }}
    
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit"> Submit</button>
</div> 
