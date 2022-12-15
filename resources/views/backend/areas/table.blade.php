<div class="table-responsive">
    <table class="table" id="areas-table">
        <thead>
            <tr class="text-center">
                <th>@lang('Name')</th>
                <th>@lang('Village')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody class="text-center">
        @foreach($areas as $area)
            <tr>
                <td>{{ $area->name }}</td>
                <td>{{ $area->village->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.areas.destroy', $area->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.areas.show', [$area->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.areas.edit', [$area->id]) }}" class='btn btn-default btn-xs'>
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
