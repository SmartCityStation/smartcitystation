<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('Name:')) !!}
    <p>{{ $village->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('Created at:')) !!}
    <p>{{ $village->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('Updated at:')) !!}
    <p>{{ $village->updated_at }}</p>
</div>

