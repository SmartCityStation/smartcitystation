@extends('frontend.layouts.app')

@section('title', __('Query Measures'))

@section('content')
<div class="container py-4">
    <div>
        <!-- <div class="row justify-content-center"> -->
        <div class="row">
            <div class="col-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <label>@lang('Variable Type'): </label>
                    <select class="form-control" id="variables_type">
                        <option>Seleccionar...</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="datoVaribles">Variable: </label>
                    <select class="form-control" id="variables_data">
                        <option>Seleccionar...</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="fechaDesde">@lang('Date From'): </label>
                    <input class="form-control" type="date" id="dateFrom" name="dateFrom" />
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="fechaHasta">@lang('Date To'): </label>
                    <input class="form-control" type="date" id="dateTo" name="dateTo">
                </div>
            </div>
        </div>
        <!--row-->
        <br>

        <div class="row">
            <div class="col-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="tipoGraficos">@lang('type of graph'): </label>
                    <select class="form-control" id="charType" name="charType">
                        <option value="line">@lang('lines')</option>
                        <option value="bar">@lang('bars')</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="color">@lang('color'): </label>
                    <input type="color" class="form-control form-control-color" id="favoriteColor" value="#99000">
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="fechaHasta">@lang('Time From'): </label>
                    <input class="form-control" type="time" id="timeFrom" disabled>
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="fechaHasta">@lang('Hour Until'): </label>
                    <input class="form-control" type="time" id="timeTo" disabled>
                </div>
            </div>
        </div>
        <!--row-->
        <div class="row">
            <div class="col-12 col-sm-3 col-md-12">
                <div class="form-group">
                    <label for=""></label>
                    <button type="button" id="show_measures" class="form-control btn btn-primary" onclick="showMeasures()" disabled>@lang('View measure')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--container-->
<hr>
<div class="container">
    <div class="col-12 col-sm-10 col-md-12">
        <div id="chartdiv">
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
    var startTime;
    var endTime;


    /*
     *   This function get all Varible Type.
     */
    function getVariableType() {

        console.log("Llego a getVariableType ... ");

        $.ajax({
            type: 'GET',
            url: "{{ route('frontend.variabletype.getvariabletype') }}",
            data: {
                _token: '{!! csrf_token() !!}',
            },
            contentType: 'application/json',
            success: function(variablesType_json) {

                let variablesType = JSON.parse(variablesType_json); // Parsing the json string.

                let variables_type = document.getElementById("variables_type");
                let nameType = 'Seleccione ...';
                let idType = 0;
                let variableTypeId = 0;

                $.each(variablesType, function(index, value) {
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
    }

    /*
     *   This function get all Varible Data, that correspond to a Variable Type.
     */
    $("#variables_type").change(function() {
        let variableTypeId = $(this).val();
        console.log('El valor seleccionado es: ' + variableTypeId);

        $.ajax({
            type: 'GET',
            url: "{{ route('frontend.variabledata.getvariabledata') }}",
            data: {
                _token: '{!! csrf_token() !!}',
                variableTypeId: variableTypeId
            },
            contentType: 'application/json',
            success: function(variableData_json) {

                let variableData = JSON.parse(variableData_json); // Parsing the json string.

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

        if ((startDate == "" || startDate == undefined || startDate == null) || (endDate == "" || endDate == undefined || endDate == null)) {
            res = false;
        } else {
            let difstartDate = startDate.split("/");
            let difEndDate = endDate.split("/");

            let iniDate = '';
            for (let i = 0; i < difstartDate.length; i++) {
                iniDate += difstartDate[i];
            }

            let finDate = '';
            for (let i = 0; i < difEndDate.length; i++) {
                finDate += difEndDate[i];
            }

            let intiniDate = parseInt(iniDate);
            let intfinDate = parseInt(finDate);

            if ((intfinDate - intiniDate) < 0) {
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

        if ((intfinTime - intiniTime) <= 0) {
            alert("La Hora Desde No debe ser mayor o igual a la Hora Hasta");
            res = false;
        }
        return res;
    }

    /*
     * This function get the measures data according to the search criteria:
     */
    function getMeasures(hours) {
        var opcVariable = $("#variables_data option:selected").val();
        var opcVariableText = $("#variables_data option:selected").text();

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

        console.log("opcVariable: " + opcVariable + " startDate: " + startDate + " endDate: " + endDate + " startHour: " + startHour + " endHour: " + endHour + " charType: " + charType);

        $.ajax({
            type: 'GET',
            url: "{{ route('frontend.measure.showmeasures') }}",
            data: {
                _token: '{!! csrf_token() !!}',
                variable: opcVariable,
                startDate: startDate,
                endDate: endDate,
                startTime: startHour,
                endTime: endHour
            },
            contentType: 'application/json',
            success: function(Measures_json) {
                if ((Measures_json == null) || (Measures_json == undefined) || (Measures_json.length == 0)) {
                    alert("Los criterios de busqueda no arrojaron resultados");
                } else {
                    var Measures = JSON.parse(Measures_json); // Parsing the json string.

                    console.log(Measures_json);

                    var hours = [];
                    var datos = [];
                    Measures.forEach(function(item, index) {
                        hours[index] = item.hour;
                        datos[index] = item.data;
                        console.log("La Hora " + item.hour + " y el Dato " + item.data + " estan en la posición " + index);
                    })

                    // the canvas is created dynamically.
                    $('#chartdiv').empty().append('<canvas id="measureChart" style="position: relative; height: 350px;"></canvas>');
                    var measureCanvas = document.getElementById("measureChart").getContext("2d");

                    if (barChart) { // if the instance exists, the instance remove.
                        barChart.destroy();
                    }

                    var barChart = new Chart(measureCanvas, {
                        type: charType,
                        data: {
                            labels: hours,
                            datasets: [{
                                label: opcVariableText,
                                data: datos,
                                backgroundColor: favoriteColor,
                                strokeColor: "brown",
                                borderWidth: 1
                            }]
                        },
                        responsive: true
                    });

                }
            },
            error: function() {
                alert("error");
            }
        });
    }

    /*
     * This function is document ready.
     */
    $(document).ready(function() {
        getVariableType();
        startDates()
    });
</script>
@endsection