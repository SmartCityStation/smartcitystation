<!-- Device Field -->
<div class="col-sm-12">
    {!! Form::label('device_id', __('Device:')) !!}
    <p>{{ $variableDevice->device->device_code }}</p>
</div>

<!-- Data Variable Field -->
<div class="col-sm-12">
    {!! Form::label('data_variable_id', __('Type variable:')) !!}
    <p>{{ $variableDevice->dataVariable->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('Created at:')) !!}
    <p>{{ $variableDevice->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('Updated at:')) !!}
    <p>{{ $variableDevice->updated_at }}</p>
</div>

