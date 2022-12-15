<div class="table-responsive">
    <table class="table" id="eventLogs-table">
        <thead>
            <tr class="text-center">
                <th>@lang('Date Event')</th>
                <th>@lang('Type Event')</th>
                <th>@lang('Description')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody class="text-center">
        @foreach($eventLogs as $eventLog)
            <tr>
                <td>{{ $eventLog->date_event->format('d-m-Y h:i:s A') }}</td>
                <td>{{ $eventLog->type_event }}</td>
                <td>{{ $eventLog->description }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.eventLogs.destroy', $eventLog->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.eventLogs.show', [$eventLog->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <!-- <a href="{{ route('admin.eventLogs.edit', [$eventLog->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a> -->
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Estas seguro?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
