<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('Name:')) !!}
    <p>{{ $area->name }}</p>
</div>

<!-- Village Name Field -->
<div class="col-sm-12">
    {!! Form::label('village_id', __('Village:')) !!}
    <p>{{ $area->village->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('Created at:')) !!}
    <p>{{ $area->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('Updated at:')) !!}
    <p>{{ $area->updated_at }}</p>
</div>

