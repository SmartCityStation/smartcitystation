<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    @stack('before-styles')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    <livewire:styles />
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style>
        /* Extra small devices (phones, 600px and down) */
        @media only screen and (max-width: 600px) {
            #chartdiv {
                width: 100%;
            }
        }

        /* Small devices (portrait tablets and large phones, 600px and up) */
        @media only screen and (min-width: 600px) {
            #chartdiv {
                width: 100%;
            }
        }

        /* Medium devices (landscape tablets, 768px and up) */
        @media only screen and (min-width: 768px) {
            #chartdiv {
                width: 100%;
            }
        }

        /* Large devices (laptops/desktops, 992px and up) */
        @media only screen and (min-width: 992px) and (max-width: 1024px) {
            #chartdiv {
                width: 100%;
                height: 550px;
            }
        }

        @media only screen and (min-width: 1280px) {
            #chartdiv {
                margin-left: 150px;
                width: 950px;
                height: 550px;
            }
        }



        /* Extra large devices (large laptops and desktops, 1200px and up) */
        @media (min-width: 1920px) {
            #chartdiv {
                margin-left: 500px;
                width: 950px;
                height: 550px;
            }
        }
    </style>
    @stack('after-styles')
</head>

<body>
    @include('includes.partials.read-only')
    @include('includes.partials.logged-in-as')
    @include('includes.partials.announcements')

    <div id="app">
        @include('frontend.includes.nav')
        @include('includes.partials.messages')

        <main>
            @yield('content')
        </main>
    </div>
    <!--app-->

    @stack('before-scripts')
    @include('frontend.layouts.footer-script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    {{-- <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/frontend.js') }}"></script> --}}
    <livewire:scripts />
    @stack('after-scripts')
</body>

</html>
