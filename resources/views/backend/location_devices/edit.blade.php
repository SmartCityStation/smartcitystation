@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>@lang('Edit device location')</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::model($locationDevice, ['route' => ['admin.locationDevices.update', $locationDevice->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('backend.location_devices.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.locationDevices.index') }}" class="btn btn-default">@lang('Cancel')</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
