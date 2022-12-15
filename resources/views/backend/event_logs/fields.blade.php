<!-- Date Event Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_event', __('Date Event:')) !!}
    {!! Form::date('date_event', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Event Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_event', __('Type Event:')) !!}
    {!! Form::text('type_event', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('Description:')) !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>