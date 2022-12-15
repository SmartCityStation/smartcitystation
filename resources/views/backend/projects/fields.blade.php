<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer', __('Customer:')) !!}
    {!! Form::select('user_id', $customers, null, ['class' => 'form-control']) !!}
</div>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('Name:')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', __('Description:')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- company Field -->
<div class="form-group col-sm-4">
    {!! Form::label('company', __('Company:')) !!}
    {!! Form::text('company', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-4">
    {!! Form::label('start_date', __('Start date:')) !!}
    <input type="date" name="start_date" id="start_date" class="form-control">
</div>

@push('scripts')
    <script type="text/javascript">
        $('#start_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            icons: {
                up: "icon-arrow-up-circle icons font-2xl",
                down: "icon-arrow-down-circle icons font-2xl"
            },
            sideBySide: true
        })
    </script>
@endpush


<div class="form-group col-sm-4">
    {!! Form::label('end_date', __('End date:')) !!}
    <input type="date" name="end_date" id="end_date" class="form-control">
</div>

@push('scripts')
    <script type="text/javascript">
        $('#end_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            icons: {
                up: "icon-arrow-up-circle icons font-2xl",
                down: "icon-arrow-down-circle icons font-2xl"
            },
            sideBySide: true
        })
    </script>
@endpush


<div class="form-group col-sm-6">
    <label for="type_variable" class="form-label">@lang('Services:')</label>
    <select class="form-control" name="type_variable" id="type_variable">
        <option value="" disabled selected>@lang('Select a service..')</option>
    </select>
</div>

<div class="form-group col-sm-6">
    <label for="data_variable" class="form-label">@lang('Type variable:')</label>
    <select class="form-control custom-select" name="data_variable" id="data_variable">
        <option value="" disabled selected>@lang('Select type variable...')</option>
    </select>
</div>

<div class="form-group col-sm-4">
    <button id="adicionar" class="btn btn-success" type="button">@lang('Add')</button>
    <button id="todos" class="btn btn-success" type="button">@lang('All')</button>
</div>

<div class="form-group col-sm-12">
    <table id="mytable" class="table table-bordered table-hover ">
        <thead class="thead-dark">
            <tr>
                <th>@lang('Service')</th>
                <th>@lang('Type variable')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($projects))
                @foreach ($projects as $project)
                    <tr id="{{ $project->data_variable_id }}">
                        <td>
                            {{ $project->service }}
                        </td>
                        <td>
                            <input type="text" style="border:0; outline:none;" name="variable[]"
                                value="{{ $project->datName }}">
                        </td>
                        <td>
                            <button type="button" name="remove"
                                class="btn btn-danger btn_remove">@lang('delete')</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
