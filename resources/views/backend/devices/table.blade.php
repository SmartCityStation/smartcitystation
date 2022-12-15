<div class="table-responsive">
    <table class="table" id="devices-table">
        <thead>
            <tr class="text-center">
                <th>@lang('Device Code')</th>
                <th>@lang('State')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody class="text-center">
        @foreach($devices as $device)
            <tr>
                <td>{{ $device->device_code }}</td>
                @if($device->state == 1)
                    <td>@lang('Active')</td>
                @else
                    <td>@lang('Desactive')</td>
                @endif
                <td width="120">
                    {!! Form::open(['route' => ['admin.devices.destroy', $device->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.devices.show', [$device->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.devices.edit', [$device->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Estas seguro?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
