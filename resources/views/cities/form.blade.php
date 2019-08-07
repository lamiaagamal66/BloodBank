@inject('model','App\Models\Governorate')

<div class="form-group">
    <label for="name">Name</label>
    {!! Form::text('name',null,[
        'class' => 'form-control'
    ]) !!}
</div>
<div class="form-group">
    {{-- <label for="governorate_id">governorate_id</label> --}}
    {!! Form::select('governorate_id',$governorates,null,[
         'placeholder' => 'اختر المحافظة',
         'class' => 'form-control'
    ]) !!}
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit"> Submit</button>
</div>


