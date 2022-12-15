<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        td,
        th {
            text-align: center;
            padding: 8px;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid rgb(0, 0, 0);

        }
    </style>
</head>

<body>
    <div class=" w-auto">
        <h3 class="text-center"> 
                 SmartCityStation te informa que los niveles de ruido de la estación {{ $device->device }} han superado los valores máximos permitidos para la zona {{ $subsector->sector }} en la programacion del último minuto
        </h3>
        <table class="table ">
            <thead>
                <tr>
                    <th scope="col">Dispositivo</th>
                    <th scope="col">Fecha y hora de Registro</th>
                    <th scope="col">Tipo de variables</th>
                    <th scope="col">Dato</th>
                    <th scope="col">Umbral</th>
                    <th scope="col">Diferencia</th>
                </tr>
            </thead>
            <tbody>
                {{-- if is array the variable measuresAlerts make continue... --}}
                @if (is_array($measuresAlerts))
                    {{-- travels array this position 1 --}}
                    @for ($row = 0; $row < count($measuresAlerts); $row++)
                        <tr>
                            {{-- echo content this array --}}
                            @for ($col = 0; $col < 6; $col++)
                                <td>{{ $measuresAlerts[$row][$col] }}</td>
                            @endfor
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>
    </div>

</body>

</html>
