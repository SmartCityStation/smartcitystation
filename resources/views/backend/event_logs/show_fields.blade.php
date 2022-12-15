<!-- Date Event Field -->
<div class="col-sm-12">
    {!! Form::label('date_event', __('Date Event:')) !!}
    <p>{{ $eventLog->date_event }}</p>
</div>

<!-- Type Event Field -->
<div class="col-sm-12">
    {!! Form::label('type_event', __('Type Event:')) !!}
    <p>{{ $eventLog->type_event }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('Description:')) !!}
    <p>{{ $eventLog->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('Create at:')) !!}
    <p>{{ $eventLog->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('Updated At:')) !!}
    <p>{{ $eventLog->updated_at }}</p>
</div>

