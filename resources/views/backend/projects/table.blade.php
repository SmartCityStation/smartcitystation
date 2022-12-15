<div class="table-responsive">
    <table class="table" id="dataVariables-table">
        <thead>
            <tr class="text-center">
                <th>@lang('Customer')</th>
                <th>@lang('Company')</th>
                <th>@lang('Name project')</th>
                <th colspan="3">@lang('Action')</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->usName }}</td>
                    <td>{{ $project->company}}</td>
                    <td>{{ $project->proName }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.projects.destroy', $project->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.projects.show', [$project->id]) }}" onclick="showVariables({{$project->id}})" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', [$project->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('¿Estas seguro?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
