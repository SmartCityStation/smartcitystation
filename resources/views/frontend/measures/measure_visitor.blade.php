@extends('frontend.layouts.app')

@section('title', __('Show measures'))

@section('content')

    <div class="container-fluid">
        {{-- <div class="row mt-3">
            <div class="col-12">
                <!--Renderiza el mapa en la vista con los datos dados-->
                <div class="links" style="height: 700px; width: 1000px;">
                    {!! Mapper::render() !!}
                </div>
            </div>
        </div> --}}

        <!--Muestra los graficos con chart.js-->
        {{-- <div class="card bg-dark">
            <div class="card-body">
                <div id="container" class="text-white"></div>
            </div>
        </div> --}}


        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-center">
                                <iframe
                                    src="http://smartcitystation.com:3000/d/NQnylEiVk/dev_001?orgId=1&refresh=5s&from=now-5m&to=now&kiosk=tv"
                                    width="1750" height="1300" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
    @endsection
