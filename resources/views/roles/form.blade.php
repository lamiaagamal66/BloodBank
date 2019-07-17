@inject('perm', 'App\Models\Permission')

<div class="form-group">
    <label for="name">Name</label>
    {!! Form::text('name',null,[
        'class' => 'form-control'
    ]) !!} 
</div>    
<div class="form-group">
    <label for="display_name">Display Name</label>
    {!! Form::text('display_name',null,[
        'class' => 'form-control'
    ]) !!} 
</div>
<div class="form-group">
    <label for="description">Description</label>
    {!! Form::textarea('description',null,[
        'class' => 'form-control'
    ]) !!} 
</div>
<div class="form-group">
    <label for="permissions">Permissions</label><br>
    <input type="checkbox"  id="select-all"><label for="select-all">Select All</label>
    <br>
    <div class="row">
        @foreach ($perm->all() as $permission)
            <div class="col-sm-3">
                <div class="checkbox">
                    <label>
                    <input type="checkbox" name="permissions_list[]" value="{{$permission->id}}"
                        @if ($model->hasPermission($permission->name))
                            checked
                        @endif
                    >
                         {{$permission->display_name}}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit"> Submit</button>
</div>

@push('scripts')
    <script>
        $("#select-all").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
    </script>
@endpush
