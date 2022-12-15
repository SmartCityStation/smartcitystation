@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>@lang('Create device with variables')</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'admin.variableDevices.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('backend.variable_devices.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.variableDevices.index') }}" class="btn btn-default">@lang('Cancel')</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
