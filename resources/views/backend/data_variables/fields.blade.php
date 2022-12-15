<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('Name:')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', __('Description:')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Variable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_variable_id',__('Type Variable:')) !!}
    {!! Form::select('type_variable_id', $typeVariables, null, ['class' => 'form-control']) !!}
</div>