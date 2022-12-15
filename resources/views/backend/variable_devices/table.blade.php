<div class="table-responsive">
    <table class="table" id="variableDevices-table">
        <thead>
            <tr class="text-center">
                <th>@lang('Device')</th>
                <th>Variable</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody class="text-center">
        @foreach($variableDevices as $variableDevice)
            <tr>
                <td>{{ $variableDevice->device->device_code }}</td>
                <td>{{ $variableDevice->dataVariable->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.variableDevices.destroy', $variableDevice->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.variableDevices.show', [$variableDevice->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.variableDevices.edit', [$variableDevice->id]) }}" class='btn btn-default btn-xs'>
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
