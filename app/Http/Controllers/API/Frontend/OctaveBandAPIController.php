<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\EventLog;
use App\Models\Frontend\OctaveBand;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class OctaveBandAPIController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }


    public function octaveBandRecord(Request $request)
    {
        if ($request->isMethod('post')) {
            $result = $this->validateJson($request);
            
            if ($result == "Ok") {
                if ($this->insertMeasure($request) == 200) {
                    return ["Ok" => "200"];
                } else {
                    $this->insertEventLog('501 Error: Al ingresar los datos sobre la Base de Datos');
                    return ["501" => "Error: Al ingresar los datos sobre la Base de Datos"];
                }
            } else {
                $reply = substr($result, 0, 3);
                switch ($reply) {
                    case '502':
                        //return $this->sendResponse(502, $result);  
                        return ["502" => $result];
                        break;
                    case '503':
                        //return $this->sendResponse(503, $result); 
                        return ["503" => $result];
                        break;
                    case '504':
                        //return $this->sendResponse(504, $result); 
                        return ["504" => $result];
                        break;
                    case '505':
                        //return $this->sendResponse(505, $result); 
                        return ["505" => $result];
                        break;
                }
            }
        }
    }

    private function validateJson($data)
    {
        $result = "";

        $lpData = $data->input();


        foreach ($lpData as $value) {
            if (empty($value['device'])) {
                $result = '502 Error: No hay dato en device';
                $this->insertEventLog($result);
                break;
            } else {
                foreach ($value['data'] as $value2) {
                    if (empty($value2['time'])) {
                        $result = '503 Error: No hay dato en time. ';
                        $this->insertEventLog($result);
                        break;
                    } else {
                        if ((float)$value2['lp'] == 0) {
                            $result = '504 Error: No hay dato en lp. ';
                            $this->insertEventLog($result);
                            break;
                        } else {
                            $result = "Ok";
                        }
                    }
                }
            }
        }

        return $result;
    }

    private function insertMeasure($inRequest)
    {

        $lpData = $inRequest->input();

        foreach ($lpData as $device) {
            $existLp = DB::table('lpData')->select('device')->where('device', $device['device'])->first();
        }

        // dd($existLp);
        try {
            $data = [];
            if (is_null($existLp)) {
                foreach ($lpData as $value) {
                    foreach ($value['data'] as $value2) {
                        foreach ($value2['lp'] as $key => $value3) {
                            $data['device'] = $value["device"];
                            $data['time'] = $value2["time"];
                            $data[$key] = $value3;
                        }
                    }
                }

                DB::table('lpData')->insert([
                    $data
                ]);
            } else {
                foreach ($lpData as $value) {
                    foreach ($value['data'] as $value2) {
                        foreach ($value2['lp'] as $key => $value3) {
                            $data[$key] = $value3;
                        }
                    }
                }
                DB::table('lpData')->where('device', $existLp->device)->update($data);
            }
        } catch (\Throwable $th) {
            dd($th);
            return 501;
        }

        return 200;
    }

    /**
     * This function save the event logs
     */
    private function insertEventLog($description): void
    {
        try {
            $dateEvent = Carbon::now()->toDateTimeString();

            EventLog::insert([
                'date_event' => $dateEvent,
                'type_event' => "Register Measure",
                'description' => $description,
                'created_at' => $dateEvent,
                'updated_at' => $dateEvent
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
