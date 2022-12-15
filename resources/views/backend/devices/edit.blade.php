@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>@lang('Edit Device')</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($device, ['route' => ['admin.devices.update', $device->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        {!! Form::label('device_code', __('Device Code:')) !!}
                        {!! Form::text('device_code', null, ['class' => 'form-control']) !!}
                    </div>
                    
                    <!-- State with toggle switch Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('state', __('Status:')) !!}
                        @if($device->state == 1)
                            {!! Form::checkbox('state', 'active', true,['class' => 'form-control switch-button']) !!}
                        @else
                            {!! Form::checkbox('state', 'active', false,['class' => 'form-control switch-button']) !!}
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.devices.index') }}" class="btn btn-default">@lang('Cancel')</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
