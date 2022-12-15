<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\AppBaseController;
use App\Models\Backend\DataVariable;
use App\Models\Frontend\Measure;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Mapper;

class MeasureVisitorController extends AppBaseController
{

    public function index()
    {
        //Consultamos la latitud, longitud y dirección de la tabla  location_devices
        $lanLat = DB::table('location_devices')
            ->select('address', 'latitude', 'length')
            ->where('remove_date', '=', null)
            ->get();

        //Se asigna la ubcación en la que se va a centrar el mapa
        Mapper::map(6.15515, -75.37371);

        //Recorremos los datos traidos con son lan y lat el cual se les va a asignar unos markers para mostrarse en el mapa
        foreach ($lanLat as $key => $value) {
            Mapper::marker($value->latitude, $value->length, [
                'icon'      => [
                    'path'         => 'M10.5,0C4.7,0,0,4.7,0,10.5c0,10.2,9.8,19,10.2,19.4c0.1,0.1,0.2,0.1,0.3,0.1s0.2,0,0.3-0.1C11.2,29.5,21,20.7,21,10.5 C21,4.7,16.3,0,10.5,0z M10.5,5c3,0,5.5,2.5,5.5,5.5S13.5,16,10.5,16S5,13.5,5,10.5S7.5,5,10.5,5z',
                    'fillColor'    => '#D11005',
                    'fillOpacity'  => 10,
                    'size'         => [21, 30]
                ],
                'label' => [
                    'text' => $value->address,
                    'color' => '#000000',
                    'fontFamily' => 'Arial',
                    'fontSize' => '15px',
                    'fontWeight' => 'bold',
                ]
            ]);
        }

        $customer = auth()->id();
        $user = User::select('type')->where('id', $customer)->first();


        return view('frontend.measures.measure_visitor', compact('user'));
    }

}
