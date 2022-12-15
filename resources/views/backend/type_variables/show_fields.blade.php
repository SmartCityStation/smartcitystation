<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('Name:')) !!}
    <p>{{ $typeVariable->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('Description:')) !!}
    <p>{{ $typeVariable->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('Created at:')) !!}
    <p>{{ $typeVariable->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('Updated at:')) !!}
    <p>{{ $typeVariable->updated_at }}</p>
</div>

