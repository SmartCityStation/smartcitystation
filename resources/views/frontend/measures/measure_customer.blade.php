@extends('frontend.layouts.app')

@section('title', __('Project customer'))

@section('content')

    <div class="container-fluid py-4">
        <form method="GET" action="{{ route('frontend.exportMeasure') }}" enctype="multipart/form-data">
            <div class="row">
                <!-- query measures -->
                <div class="col-12">
                    <div class="form-group">
                        <label for="project_id" class="font-weight-bold">@lang('Project:') </label>
                        <select class="form-control" id="project_id" name="project">
                            <option disabled selected>Seleccionar...</option>
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-xl-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Variable Type'): </label>
                                <select class="form-control" id="variables_type" name="variable">
                                    <option disabled selected>Seleccionar...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="datoVaribles" class="font-weight-bold">Variable: </label>
                                <select class="form-control" id="variables_data" name="dataVariable">
                                    <option disabled selected> Seleccionar...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="fechaDesde" class="font-weight-bold">@lang('Date From'): </label>
                                <input class="form-control" type="date" id="dateFrom" name="dateFrom" />
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="fechaHasta" class="font-weight-bold">@lang('Date To'): </label>
                                <input class="form-control" type="date" id="dateTo" name="dateTo">
                            </div>
                        </div>
                    </div>
                    <!--row-->

                    <div class="row">
                        <div class="col-xl-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="tipoGraficos" class="font-weight-bold">@lang('type of graph'): </label>
                                <select class="form-control" id="charType" name="charType">
                                    <option value="line">@lang('lines')</option>
                                    <option value="bar">@lang('bars')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="color" class="font-weight-bold">@lang('Color'): </label>
                                <input type="color" class="form-control form-control-color" id="favoriteColor"
                                    value="#99000">
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="fechaDesde">@lang('Time From'): </label>
                                <input class="form-control" type="time" id="timeFrom" disabled>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="fechaHasta">@lang('Hour Until'): </label>
                                <input class="form-control" type="time" id="timeTo" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-sm-3 col-md-12">
                            <div class="form-group">
                                <button type="button" id="show_measures" class="form-control btn btn-primary"
                                    onclick="showMeasures()" disabled>@lang('View measure')
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-3 col-md-12">
                            <div class="form-group">
                                <button type="submit" id="export" class="form-control btn btn-primary"
                                    disabled>@lang('Export Measure')</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--row-->

            </div>
        </form>

        <div class="row mt-3">
            <div class="col-xl-12 col-sm-12 col-md-12">
                <div id="chartdiv">
                </div>
            </div>
        </div>
    </div>




@endsection

@section('script')
    <script>
        /*
         * Global Variables.
         */
        var startDate;
        var endDate;
        var startOrEndDate;
        var datesDiff;
        var idProject;
        var startTime;
        var endTime;

        /*
         * This function is document ready.
         */
        $(document).ready(function() {
            startDates();
            getProjectsUser();
        });

        /*
         *   This function get projects that owner is the login user.
         */
        function getProjectsUser() {
            $.ajax({
                type: 'GET',
                url: "{{ route('frontend.project.getprojectsuser') }}",
                contentType: 'application/json',
                success: function(userProjects_json) {

                    let userProjects = JSON.parse(userProjects_json);

                    console.log(userProjects);

                    let projects = document.getElementById("project_id");
                    let nameProject = 'Seleccione ...';
                    let idProject = 0;
                    let posid = 0;

                    $.each(userProjects, function(index, value) {
                        nameProject = value.name;
                        idProject = value.id;
                        posid = index;
                        let itemProjects = document.createElement("option");
                        itemProjects.textContent = nameProject;
                        itemProjects.value = idProject;
                        projects.appendChild(itemProjects);
                    });
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage + ' status: ' + status + '  error: ' + error);
                }
            });
        }


        /*
         *   This function get only the project, that user like view.
         */
        $("#project_id").change(function() {

            idProject = $(this).val();
            console.log('El proyecto seleccionado es: ' + idProject);

            $.ajax({
                type: 'GET',
                url: "{{ route('frontend.variabletype.getvariabletypeforproj') }}",
                data: {
                    _token: '{!! csrf_token() !!}',
                    projectid: idProject,
                },
                contentType: 'application/json',
                success: function(variablesProject_json) {

                    let variablesProject = JSON.parse(variablesProject_json);

                    console.log(variablesProject);

                    let variables_type = document.getElementById("variables_type");
                    let nameType = 'Seleccione ...';
                    let idType = 0;
                    let variableTypeId = 0;

                    $.each(variablesProject, function(index, value) {
                        nameType = value.name;
                        variableTypeId = value.id;
                        idType = index;
                        let itemVariableType = document.createElement("option");
                        itemVariableType.textContent = nameType;
                        itemVariableType.value = variableTypeId;
                        variables_type.appendChild(itemVariableType);
                    });
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage + ' status: ' + status + '  error: ' + error);
                }
            });

        });

        /*
         *   This function get all Variable Data, that correspond to a Variable Type.
         */
        $("#variables_type").change(function() {
            variableTypeId = $(this).val();

            console.log('El tipo de variable seleccionado es: ' + variableTypeId);
            console.log('El proyecto seleccionado es: ' + idProject);

            $.ajax({
                type: 'GET',
                url: "{{ route('frontend.variabledata.getvariabledata') }}",
                data: {
                    variableTypeId: variableTypeId,
                    projectid: idProject,
                },
                contentType: 'application/json',
                success: function(variableData_json) {

                    console.log(variableData_json);

                    let variableData = JSON.parse(variableData_json);

                    console.log(variableData);

                    let variables_data = document.getElementById("variables_data");
                    $('#variables_data').empty();
                    let nameType = '';
                    let idType = 0;
                    let variableId = 0;

                    $.each(variableData, function(index, value) {
                        nameType = value.name;
                        variableId = value.id;
                        idType = index;
                        let itemVariable = document.createElement("option");
                        itemVariable.textContent = nameType;
                        itemVariable.value = variableId;
                        variables_data.appendChild(itemVariable);
                    });
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage + ' status: ' + status + '  error: ' + error);
                }
            });
        });


        /*
         *   This function get all Varible Data, that correspond to a Variable Type.
         */
        function startDates() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("dateFrom")[0].setAttribute('max', today);
            document.getElementsByName("dateTo")[0].setAttribute('max', today);
        }


        $("#dateFrom").change(function handler(e) {
            startDate = e.target.value;
            startDate = getDate(startDate);

            console.log('startDate = ' + startDate);
            startDate = changeFormaToDates(startDate);

            changeVisibilityOfhours();
        });

        $("#dateTo").change(function handler(e) {
            endDate = e.target.value;
            endDate = getDate(endDate);

            console.log('endDate = ' + endDate);

            $("#show_measures").prop('disabled', false);
            $("#export").prop('disabled', false);
            endDate = changeFormaToDates(endDate);

            changeVisibilityOfhours();
        });

        /*
         * This function Enable or Disable the inputs of time.
         */
        function changeVisibilityOfhours() {
            if (startDate == endDate) {
                $("#timeFrom").prop('disabled', false);
                $("#timeTo").prop('disabled', false);
            } else {
                $("#timeFrom").prop('disabled', true);
                $("#timeTo").prop('disabled', true);
            }
        }


        /*
         * This function change the format to dates.
         */
        function changeFormaToDates(dateStartOrEnd) {

            let splitDate;
            let year;
            let month;
            let day;

            splitDate = dateStartOrEnd.split("/");

            for (let i = 0; i < splitDate.length; i++) {
                switch (i) {
                    case 0:
                        day = splitDate[i];
                        break;
                    case 1:
                        month = splitDate[i];
                        break;
                    case 2:
                        year = splitDate[i];
                        break;
                }
            }

            startOrEndDate = year + '-' + month + '-' + day;
            return startOrEndDate;
        }


        /*
         * This function get the dates diffenrence.
         */
        function getDate(date) {
            datesDiff = '';
            var dateDiff = date.split("-");
            for (var i = dateDiff.length - 1; i > -1; i--) {
                if (i > 0) {
                    datesDiff += dateDiff[i] + "/";
                } else {
                    datesDiff += dateDiff[i];
                }
            }
            return datesDiff;
        }


        /*
         * This function get all records that match the search criterial:
         */
        function showMeasures() {
            if (dateValidate()) {
                if (startDate == endDate) {
                    if (timeValidate()) {
                        getMeasures("S");
                    }
                } else {
                    getMeasures("N");
                }
            }
        }

        /*
         * This function validates that the from date is less than the to date:
         */
        function dateValidate() {
            var res = true;

            if ((startDate == "" || startDate == undefined || startDate == null) || (endDate == "" || endDate ==
                    undefined || endDate == null)) {
                res = false;
            } else {
                let difstartDate = startDate.split("/");
                let difEndDate = endDate.split("/");

                let indSD = 0;
                let newStartDate = new Array(3);

                for (let i = 2; i > -1; i--) {
                    newStartDate[indSD] = difstartDate[i];
                    indSD++;
                }
                let indED = 0;
                let newEndDate = new Array(3);

                for (let i = 2; i > -1; i--) {
                    newEndDate[indED] = difEndDate[i];
                    indED++;
                }

                let getStartDate = newStartDate[0] + " - " + newStartDate[1] + " - " + newStartDate[2];
                let getEndDate = newEndDate[0] + " - " + newEndDate[1] + " - " + newEndDate[2];

                if (getStartDate > getEndDate) {
                    alert("La 'fecha desde' no debe ser mayor a la 'fecha hasta'");
                    res = false;
                }
            }

            return res;
        }

        /*
         * This function validates that the from time is less than the to time:
         */
        function timeValidate() {
            var res = true;

            startTime = document.getElementById("timeFrom").value;
            endTime = document.getElementById("timeTo").value;

            let difstartTime = startTime.split(":");
            let difEndTime = endTime.split(":");

            let iniTime = '';
            for (let i = 0; i < difstartTime.length; i++) {
                iniTime += difstartTime[i];
            }

            let finTime = '';
            for (let i = 0; i < difEndTime.length; i++) {
                finTime += difEndTime[i];
            }

            let intiniTime = parseInt(iniTime);
            let intfinTime = parseInt(finTime);

            console.log(intiniTime, intfinTime)

            if ((intfinTime - intiniTime) <= 0) {
                alert("La 'Hora desde' no debe ser IGUAL o MAYOR a la 'Hora hasta'");
                res = false;
            }
            return res;
        }

        function isEmptyObject(obj) {
            for (var property in obj) {
                if (obj.hasOwnProperty(property)) {
                    return false;
                }
            }
            return true;
        }

        /*
         * This function get the measures data according to the search criteria:
         */
        function getMeasures(hours) {
            var opcVariable = $("#variables_data option:selected").val();
            var opcVariableText = $("#variables_data option:selected").text();
            var opcProject = $('#project_id option:selected').val();
            var typeVar = $('#variables_type option:selected').val();
            var favoriteColor = $("#favoriteColor").val();

            var startHour = '00:00';
            var endHour = '00:00';

            if (hours == "S") {
                if ((startTime == "" || startTime == null) || (endTime == "" || endTime == null)) {
                    startTime = '00:00';
                    endTime = '00:00';
                }
                startHour = startTime + ":00";
                endHour = endTime + ":00";
            } else {
                startHour += ":00";
                endHour += ":00";
            }

            var charType = $("#charType").val();

            console.log("opcVariable: " + opcVariable + " startDate: " + startDate + " endDate: " + endDate +
                " charType: " + charType + " projectId: " + idProject);

            $.ajax({
                type: 'GET',
                url: "{{ route('frontend.measure.showmeasures') }}",
                data: {
                    _token: '{!! csrf_token() !!}',
                    variable: opcVariable,
                    typeVar: typeVar,
                    startDate: startDate,
                    endDate: endDate,
                    project: idProject,
                    startTime: startHour,
                    endTime: endHour
                },
                contentType: 'application/json',
                success: function(Measures_json) {
                    if ((Measures_json == null) || (Measures_json == undefined) || (Measures_json.length = 0) ||
                        isEmptyObject(Measures_json)) {

                        alert("Los criterios de busqueda no arrojaron resultados");

                    } else {

                        var Measures = JSON.parse(Measures_json); // Parsing the json string.

                        var unidad;
                        var min;
                        var max;
                        var stepSize;

                        //toma las opciones de variables para darle formato al gráfico
                        if (typeVar == 1) {
                            unidad = "dBa";
                            min = 20;
                            max = 120;
                            stepSize = 20;
                        } else if (typeVar == 2 && opcVariableText === "Humedad relativa") {
                            unidad = "%H"
                            min = 0;
                            max = 100;
                            stepSize = 20;
                        } else if (typeVar == 2 && opcVariableText === "Presión atmosférica") {
                            unidad = "hPa";
                            min = 0;
                            max = 1000;
                            stepSize = 200;
                        } else if (typeVar == 2 && opcVariableText === "PM 10") {
                            unidad = "μm";
                            min = 0;
                            max = 50;
                            stepSize = 200;
                        } else if (typeVar == 2 && opcVariableText === "PM 2.5") {
                            unidad = "μm";
                            min = 0;
                            max = 50;
                            stepSize = 200;
                        } else {
                            unidad = "°C"
                            min = 0;
                            max = 50;
                            stepSize = 10;
                        }

                        console.log(unidad, opcVariableText, typeVar, min, max);

                        var fechas = [];
                        var datos = [];

                        Measures.forEach(function(item, index) {
                            if (item.hour == null) {
                                fechas[index] = item.time;
                                datos[index] = item.data;
                                console.log("La fecha " + item.time + " y el Dato " + item.data +
                                    " estan en la posición " + index);
                            } else {
                                fechas[index] = item.hour;
                                datos[index] = item.data;
                                console.log("La fecha " + item.hour + " y el Dato " + item.data +
                                    " estan en la posición " + index);
                            }
                        })

                        // the canvas is created dynamically.
                        $('#chartdiv').empty().append(
                            '<canvas id="measureChart"></canvas>'
                        );
                        var measureCanvas = document.getElementById("measureChart").getContext("2d");

                        if (barChart) { // if the instance exists, the instance remove.
                            barChart.destroy();
                        }

                        var barChart = new Chart(measureCanvas, {
                            type: charType,
                            data: {
                                labels: fechas,
                                datasets: [{
                                    label: opcVariableText,
                                    data: datos,
                                    borderColor: favoriteColor,
                                    borderWidth: 3,
                                    fill: false,
                                    lineTension: 0,
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        min: min,
                                        max: max,
                                        ticks: {
                                            // forces step size to be stepSize var units
                                            stepSize: stepSize
                                        },
                                        display: true,
                                        title: {
                                            display: true,
                                            text: unidad,
                                            color: 'rgba(128,128,128)',
                                            font: {
                                                size: 16,
                                                family: 'tahoma',
                                                weight: 'bold',
                                                style: 'italic'
                                            },
                                        }
                                    },
                                }
                            },
                        });

                    }
                },
                error: function() {
                    alert("error");
                }
            });
        }
    </script>
@endsection
