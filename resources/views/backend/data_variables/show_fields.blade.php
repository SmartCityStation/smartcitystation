<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('Name:')) !!}
    <p>{{ $dataVariable->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('Description:')) !!}
    <p>{{ $dataVariable->description }}</p>
</div>

<!-- Type Variable Name Field -->
<div class="col-sm-12">
    {!! Form::label('type_variable_id', __('Variable:')) !!}
    <p>{{ $dataVariable->typeVariable->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('Created at:')) !!}
    <p>{{ $dataVariable->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('Updated At:')) !!}
    <p>{{ $dataVariable->updated_at }}</p>
</div>

