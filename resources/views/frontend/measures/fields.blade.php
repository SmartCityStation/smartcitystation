<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::text('date', null, ['class' => 'form-control']) !!}
</div>

<!-- Hour Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hour', 'Hour:') !!}
    {!! Form::text('hour', null, ['class' => 'form-control']) !!}
</div>

<!-- Data Field -->
<div class="form-group col-sm-6">
    {!! Form::label('data', 'Data:') !!}
    {!! Form::text('data', null, ['class' => 'form-control']) !!}
</div>

<!-- Device Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_id', 'Device:') !!}
    {!! Form::select('device_id', $devices, null, ['class' => 'form-control']) !!}
</div>

<!-- Data Variable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('data_variable_id', 'Data Variable:') !!}
    {!! Form::select('data_variable_id', $dataVariables, null, ['class' => 'form-control']) !!}
</div>