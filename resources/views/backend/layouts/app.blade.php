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
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
    <livewire:styles />
    @stack('after-styles')

    <link href="css/togglebutton.css" id="toggle-button-style" rel="stylesheet" type="text/css" />
</head>

<body class="c-app">
    @include('backend.includes.sidebar')

    <div class="c-wrapper c-fixed-components">
        @include('backend.includes.header')
        @include('includes.partials.read-only')
        @include('includes.partials.logged-in-as')
        @include('includes.partials.announcements')

        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        @include('includes.partials.messages')
                        @yield('content')
                    </div>
                    <!--fade-in-->
                </div>
                <!--container-fluid-->
            </main>
        </div>
        <!--c-body-->

        @include('backend.includes.footer')
    </div>
    <!--c-wrapper-->

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/backend.js') }}"></script>
    <!-- my files js should be at the end. -->
    <script src="{{ asset('js/datesandtimes.js') }}"></script>
    <livewire:scripts />
    <script>
        window.onload = function() {

            getTypeVariables();
            if ($('#municipality_id').val() != '') {
                getDataVariables();
            } else {
                $('#data_variable').prop("disabled", true);
            }

        }

        function getTypeVariables() {
            $.ajax({
                type: 'GET',
                url: "{{ route('admin.getTypeVariables') }}",
                success: function(typeVariable_json) {

                    let typeVariable = JSON.parse(typeVariable_json);


                    $.each(typeVariable, function(index, value) {
                        $("#type_variable").append('<option value=' + value.id + '>' + value.name +
                            '</option>');
                    });

                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage + ' status: ' + status + '  error: ' + error);
                }
            });
        }

        function getDataVariables() {
            $.ajax({
                type: 'GET',
                url: "{{ route('admin.getDataVariables') }}",
                success: function(dataVariable_json) {

                    let dataVariable = JSON.parse(dataVariable_json);


                    $.each(dataVariable, function(index, value) {
                        $("#data_variable").append('<option value=' + value.id + '>' + value.name +
                            '</option>');
                    });

                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage + ' status: ' + status + '  error: ' + error);
                }
            });
        }

        $("#type_variable").change(function() {
            let typeVariableId = $(this).val();

            $('#data_variable').prop("disabled", false);

            $.ajax({
                type: 'GET',
                url: "{{ route('admin.getDataVariableForTv') }}",
                data: {
                    typeVariableId: typeVariableId
                },
                contentType: 'application/json',
                success: function($dataVariableIdData_json) {

                    let dvfortv = JSON.parse($dataVariableIdData_json); // Parsing the json string.

                    $('#data_variable').empty();

                    $.each(dvfortv, function(index, value) {
                        $("#data_variable").append('<option value=' + value.id + '>' + value
                            .name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage + ' status: ' + status + '  error: ' + error);
                }
            });
        })


        $(document).ready(function() {
            //Trae lo datos seleccionados en el select
            $('#adicionar').click(function() {

                //obtenemos datos del id select
                var textoService = document.getElementById("type_variable");
                var textoTypeV = document.getElementById("data_variable");

                //verificar que se haya seleccionado datos del select si no manda mensaje
                if (textoService.value == "" && textoTypeV.value == "") {
                    alert('Debe seleccionar un servicio con su tipo de variable');

                    //verifica que tenga los datos de los dos select
                } else if (textoService.value !== "" && textoTypeV.value !== "") {

                    var selectService = textoService.options[textoService.selectedIndex].text;
                    var selectTypeV = textoTypeV.options[textoTypeV.selectedIndex].text;

                    var i = 1;

                    var fila = '<tr id="' + textoTypeV.value + '" class="service"><td value="' +
                        textoTypeV.value + '">' + selectService +
                        '</td><td><input type="text" style="border:0; outline:none;" name="variable[]" value="' +
                        selectTypeV +
                        '"></td><td><button type="button" name="remove" id="' + i +
                        '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila

                    i++;
                } else {
                    var selectService = textoService.options[textoService.selectedIndex].text;
                    var i = 1;

                    var fila = '<tr id="' + textoService.value + '" class="service"><td value="' +
                        textoService.value +
                        '"><input type="text" style="border:0; outline:none;" name="variable" value="' +
                        selectService +
                        '"></td><td> None </td><td><button type="button" name="remove" id="' + i +
                        '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila

                    i++;
                }


                $('#mytable tr:first').after(fila);
                //le resto 1 para no contar la fila del header
                document.getElementById("type_variable").focus();

            });

            //Trae todas las variables desde un json y las pone en la tabla
            $('#todos').click(function() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.variableForTypeVariable') }}",
                    contentType: 'application/json',
                    success: function(dataVariable_json) {

                        var dataVariable = JSON.parse(dataVariable_json);

                        dataVariable.forEach(function(item, index) {

                            console.log("Tipo variable:" + item.dataVar + " Servicio:" +
                                item.typeVar + " Id:" + item.dataId);

                            var fila = '<tr id="' + item.dataId + '"><td>' + item
                                .typeVar +
                                '</td><td><input type="text" style="border:0; outline:none;" name="variable[]" value="' +
                                item.dataVar +
                                '"></td><td><button type="button" name="remove" id="' +
                                index +
                                '" class="btn btn-danger btn_remove">Quitar</button></td></tr>';

                            $('#mytable tr:first').after(fila);

                        });
                    }
                });
            });


            //Elimina los row de la tabla
            $(document).on('click', '.btn_remove', function() {
                event.preventDefault();
                $(this).closest('tr').remove();

            });

        });
    </script>
    @stack('after-scripts')
</body>

</html>
