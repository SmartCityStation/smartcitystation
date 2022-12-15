<!-- Device Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('device_id', __('Device:')) !!}
    {!! Form::select('device_id', $devicies,null ,['class' => 'form-control']) !!}
</div>

<!-- Data Variable Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('data_variable_id', __('Type variable:')) !!}
    {!! Form::select('data_variable_id', $variables,null,['class' => 'form-control']) !!}
</div>