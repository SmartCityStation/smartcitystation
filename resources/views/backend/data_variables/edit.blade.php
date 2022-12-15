@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>@lang('Edit type variable')</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($dataVariable, ['route' => ['admin.dataVariables.update', $dataVariable->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('backend.data_variables.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.dataVariables.index') }}" class="btn btn-default">@lang('Cancel')</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
