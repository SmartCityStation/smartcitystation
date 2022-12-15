<div class="table-responsive">
    <table class="table" id="locationDevices-table">
        <thead>
            <tr class="text-center">
                <th>@lang('Address')</th>
                <th>@lang('Installation Date')</th>
                <th>@lang('Installation Hour')</th>
                <th>@lang('Device removal')</th>
                <!-- <th>Remove Hour</th> -->
                <th>@lang('Latitude')</th>
                <th>@lang('Longitude')</th>
                <th>@lang('Device')</th>
                <th>Area</th>
                <th>@lang('Project')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($locationDevices as $locationDevice)
                <tr>
                    <td>{{ $locationDevice->address }}</td>
                    <td>{{ $locationDevice->installation_date->format('d-m-Y') }}</td>
                    <td>{{ $locationDevice->installation_hour->format(' h:i:s A') }}</td>
                    @if ($locationDevice->remove_date != $locationDevice->installation_date)
                        <td>{{ $locationDevice->remove_date }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $locationDevice->latitude }}</td>
                    <td>{{ $locationDevice->length }}</td>
                    <td>{{ $locationDevice->device->device_code }}</td>
                    <td>{{ $locationDevice->area->name }}</td>
                    <td>{{ $locationDevice->project->name }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.locationDevices.destroy', $locationDevice->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.locationDevices.show', [$locationDevice->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.locationDevices.edit', [$locationDevice->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('¿Estas seguro?')",
                            ]) !!} --}}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
