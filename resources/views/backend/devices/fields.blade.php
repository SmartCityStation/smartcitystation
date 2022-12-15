<!-- Device Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_code', __('Device Code:')) !!}
    {!! Form::text('device_code', null, ['class' => 'form-control']) !!}
</div>

<!-- State with toggle switch Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', ('Status:')) !!}
    {!! Form::checkbox('state', 'active', true,['class' => 'form-control switch-button']) !!}
</div>