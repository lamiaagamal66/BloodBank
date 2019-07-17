
<div class="form-group">
    <label for="title">Title</label>
    {!! Form::text('title',null,[
        'class' => 'form-control'
    ]) !!}
    <label for="body">Body</label>
    {!! Form::text('body',null,[
        'class' => 'form-control'
    ]) !!}
    <label for="category_id">Category_id</label>
    {!! Form::text('category_id',null,[
        'class' => 'form-control'
    ]) !!}
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit"> Submit</button>
</div> 
