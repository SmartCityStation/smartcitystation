<!-- Device Code Field -->
<div class="col-sm-12">
    {!! Form::label('device_code', __('Device Code:')) !!}
    <p>{{ $device->device_code }}</p>
</div>

<!-- State Field -->
<div class="col-sm-12">
    {!! Form::label('state', __('Status:')) !!}
    @if ($device->state == 1)
        <p>@lang('Active')</p>
    @else
        <p>@lang('Desactive')</p>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('Created at:')) !!}
    <p>{{ $device->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('Update at:')) !!}
    <p>{{ $device->updated_at }}</p>
</div>
