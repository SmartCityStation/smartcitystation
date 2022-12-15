<?php

namespace App\Exports;

use App\Models\Backend\LocationDevice;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MeasuresExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{

    //se toman las variables mandadas por el formulario
    public $TypeVariable, $variable, $startDate, $endDate, $project;

    function __construct($TypeVariable, $variable, $startDate, $endDate, $project)
    {
        $this->TypeVariable = $TypeVariable;
        $this->variable = $variable;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->project = $project;
    }

    //se da el nombre de las columnas con las que va a recibir datos
    public function headings(): array
    {
        return [
            'Tiempo',
            'Datos',
            'Tipo de variable',
            'Variable',
            'Proyecto'
        ];
    }

    //tamaño de las columnas
    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 35,
            'C' => 35,
            'D' => 35,
            'E' => 35,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling an entire row.
            1  => ['font' => ['size' => 13]],

        ];
    }



    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //se hace la consulta de los datos que se van a traer, traerlas en el orden como estan el nombre de las columnas
        $exportMeasure = LocationDevice::select('measures.time', 'measures.data', 'type_variables.name as tipo variable', 'data_variables.name as variable', 'projects.name as proyecto')
            ->join('devices', 'location_devices.device_id', '=', 'devices.id')
            ->join('projects', 'location_devices.project_id', '=', 'projects.id')
            ->join('measures', 'measures.device_id', '=', 'devices.id')
            ->join('data_variables', 'data_variables.id', '=', 'measures.data_variable_id')
            ->join('type_variables', 'type_variables.id', '=', 'data_variables.type_variable_id')
            ->where('project_id', '=', $this->project)
            ->where('data_variable_id', '=', $this->variable)
            ->whereBetween(DB::raw('DATE(measures.time)'), [$this->startDate, $this->endDate])
            ->get();

        return $exportMeasure;
    }
}
