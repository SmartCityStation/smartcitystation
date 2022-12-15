@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')

    @include('flash::message')
    <x-backend.card>
        <x-slot name="header">
        @lang('Welcome :Name', ['name' => $logged_in_user->name])          
        </x-slot>
        <x-slot name="body">
            {{-- @lang('Welcome to the Dashboard') --}}
            <div class="row">
                <div class="col-12">
                    @include('backend.includes.calendar')
                </div>
            </div>
        </x-slot>
    </x-backend.card>
@endsection
