<div class="table-responsive">
    <table class="table" id="measures-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Hour</th>
                <th>Data</th>
                <th>Device</th>
                <th>Data Variable</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($measures as $measure)
            <tr>
                <td>{{ $measure->date }}</td>
                <td>{{ $measure->hour }}</td>
                <td>{{ $measure->data }}</td>
                <td>{{ $measure->device->device_code }}</td>
                <td>{{ $measure->dataVariable->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['frontend.measures.destroy', $measure->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('frontend.measures.show', [$measure->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('frontend.measures.edit', [$measure->id]) }}" class='btn btn-default btn-xs'>
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
