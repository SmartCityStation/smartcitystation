        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
        <!-- <script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js')}}"></script> -->

        @yield('script')

        <!-- App js -->
        <!-- <script src="{{ URL::asset('assets/js/app.min.js')}}"></script> -->
        <scrit src="{{ mix('js/manifest.js') }}"></scrit>
        <scrit src="{{ mix('js/vendor.js') }}"></scrit>
        <scrit src="{{ mix('js/frontend.js') }}"></scrit>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        @yield('script-bottom')
