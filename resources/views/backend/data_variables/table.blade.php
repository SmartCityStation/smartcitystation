<div class="table-responsive">
    <table class="table" id="dataVariables-table">
        <thead>
            <tr class="text-center">
                <th>@lang('Name')</th>
                <th>@lang('Description')</th>
                <th>@lang('Variables')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody class="text-center">
        @foreach($dataVariables as $dataVariable)
            <tr>
                <td>{{ $dataVariable->name }}</td>
                <td>{{ $dataVariable->description }}</td>
                <td>{{ $dataVariable->typeVariable->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.dataVariables.destroy', $dataVariable->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.dataVariables.show', [$dataVariable->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.dataVariables.edit', [$dataVariable->id]) }}" class='btn btn-default btn-xs'>
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
