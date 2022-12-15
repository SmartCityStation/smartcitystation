@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>@lang('Edit area')</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($area, ['route' => ['admin.areas.update', $area->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('backend.areas.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.areas.index') }}" class="btn btn-default">@lang('Cancel')</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
