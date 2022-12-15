<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', __('Address:')) !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Installation Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('installation_date', __('Installation date:')) !!}
    @if ($desde == 'Edit')
        <label class="font-weight-bold">{{ $locationDevice->installation_date->format('d-m-Y') }}</label>
    @endif
    {{ Form::date('installation_date', null, ['class' => 'form-control']) }}

</div>

<!-- Installation Hour Field -->
<div class="form-group col-sm-6">
    {!! Form::label('installation_hour', __('Installation hour:')) !!}
    @if ($desde == 'Edit')
        <label class="font-weight-bold">{{ $locationDevice->installation_hour->format('H:m:s A') }}</label>
    @endif
    {!! Form::time('installation_hour', null, ['class' => 'form-control']) !!}
</div>

@if ($desde == 'Edit')
    <!-- Remove Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('remove_date', __('Device removal')) !!}
        <label class="font-weight-bold">{{ $locationDevice->remove_date }}</label>
        {{ Form::date('remove_date', null, ['class' => 'form-control']) }}
    </div>
@endif

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', __('Latitude:')) !!}
    {!! Form::number('latitude', null, ['class' => 'form-control', 'step' => 'any']) !!}
</div>

<!-- Length Field -->
<div class="form-group col-sm-6">
    {!! Form::label('length', __('Longitude:')) !!}
    {!! Form::number('length', null, ['class' => 'form-control', 'step' => 'any']) !!}
</div>

<!-- Device Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_id', __('Device:')) !!}
    {!! Form::select('device_id', $devices, null, ['class' => 'form-control']) !!}
</div>

<!-- Area Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area_id', 'Area:') !!}
    {!! Form::select('area_id', $areas, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('project_id', __('Projects:')) !!}
    {!! Form::select('project_id', $projects, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    <table id="mytable" class="table table-bordered table-hover ">
        <thead class="thead-dark">
            <tr>
                <th>@lang('Sector')</th>
                <th>@lang('Subsector')</th>
                <th>@lang('Alert threshold day')</th>
                <th>@lang('Alert threshold night')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subsectors as $subsector)
                <tr>
                    <td>
                        {{ $subsector->name }}
                    </td>
                    <td>
                        {{ $subsector->description }}
                    </td>
                    <td>
                        {{ $subsector->alert_threshold_day }}
                    </td>
                    <td>
                        {{ $subsector->alert_threshold_night }}
                    </td>

                    <td>
                        @if (isset($subsectorEdit))
                            <input type="radio" name="subsector_id" id="subsector" value="{{ $subsector->subsecId }}"
                                {{ $subsector->subsecId == $subsectorEdit->subsector_id ? 'checked' : '' }}>
                        @else
                            <input type="radio" name="subsector_id" id="subsector" value="{{ $subsector->subsecId }}">
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $subsectors->links() }}
</div>
