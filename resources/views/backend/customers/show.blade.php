@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('Customer Details')</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.customers.index') }}">
                        @lang('Back')
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::label('name', __('Name:')) !!}
                        <p>{{ $customer->name }}</p>
                    </div>
                    
                    <div class="col-sm-12">
                        {!! Form::label('email', __('Email:')) !!}
                        <p>{{ $customer->email }}</p>
                    </div>

                    <div class="col-sm-12">
                        {!! Form::label('type', __('Type user:')) !!}
                        <p>{{ $customer->type }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection