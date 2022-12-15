@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>@lang('Create event logs')</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'admin.eventLogs.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('backend.event_logs.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.eventLogs.index') }}" class="btn btn-default">@lang('Cancel')</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
