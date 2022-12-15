<!-- Date Field -->
<div class="col-sm-12">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $measure->date }}</p>
</div>

<!-- Hour Field -->
<div class="col-sm-12">
    {!! Form::label('hour', 'Hour:') !!}
    <p>{{ $measure->hour }}</p>
</div>

<!-- Data Field -->
<div class="col-sm-12">
    {!! Form::label('data', 'Data:') !!}
    <p>{{ $measure->data }}</p>
</div>

<!-- Device Field -->
<div class="col-sm-12">
    {!! Form::label('device_id', 'Device:') !!}
    <p>{{ $measure->device->device_code }}</p>
</div>

<!-- Data Variable Field -->
<div class="col-sm-12">
    {!! Form::label('data_variable_id', 'Data Variable:') !!}
    <p>{{ $measure->dataVariable->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Creado El:') !!}
    <p>{{ $measure->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Actualizado El:') !!}
    <p>{{ $measure->updated_at }}</p>
</div>

