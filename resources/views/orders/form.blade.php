@inject('model','App\Models\City')
@inject('model','App\Models\BloodType')

<div class="form-group">
    <label for="name">Name</label>
    {!! Form::text('name',null,[
        'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <label for="age">Age</label>
    {!! Form::number('age',null,[
        'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <label for="mobile">Mobile</label>
    {!! Form::text('mobile',null,[
        'class'=>'form-control'
    ]) !!}
    <div class="form-group">
        <label for="hospital_name">Hospital Name </label>
        {!! Form::text('hospital_name',null,[
            'class'=>'form-control'
        ]) !!}
    </div>
    <div class="form-group">
        <label for="hospital_address">Hospital Address </label>
        {!! Form::text('hospital_address',null,[
            'class'=>'form-control'
        ]) !!}
    </div>
    <div class="form-group">
        <label for="note">Notes</label>
        {!! Form::textarea('notes',null,[
            'class'=>'form-control'
        ]) !!}
    </div>
    <div class="form-group">
        <label for="quantity">Blood Quantity</label>
        {!! Form::number('quantity',null,[
            'class'=>'form-control'
        ]) !!}
    </div>
    <div class="form-group">
        <label for="blood_type">Blood Type </label>
        {!! Form::select('blood_type_id',$bloodtypes,[],[
            'class'=>'form-control'
        ]) !!}
    </div>
    <div class="form-group">
        <label for="city">City</label>
        {!! Form::select('city_id',$cities,[],[
            'class'=>'form-control'
        ]) !!}
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit"> Submit</button>
    </div>
</div>