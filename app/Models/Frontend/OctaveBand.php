<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OctaveBand extends Model
{
    use HasFactory;

    public $table = 'lpdata';

    public $fillable = [
        'device',
        'time',
        '0',
        '1',
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        '17',
        '18',
        '19',
        '20',
        '21',
        '22',
        '23',
        '24',
        '25',
        '26',
        '27',
        '28',
        '29'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'device' => 'required',
        'time' => 'required',
        '0' => 'required',
        '1' => 'required',
        '2' => 'required',
        '3' => 'required',
        '4' => 'required',
        '5' => 'required',
        '6' => 'required',
        '7' => 'required',
        '8' => 'required',
        '9' => 'required',
        '10' => 'required',
        '11' => 'required',
        '12' => 'required',
        '13' => 'required',
        '14' => 'required',
        '15' => 'required',
        '16' => 'required',
        '17' => 'required',
        '18' => 'required',
        '19' => 'required',
        '20' => 'required',
        '21' => 'required',
        '22' => 'required',
        '23' => 'required',
        '24' => 'required',
        '25' => 'required',
        '26' => 'required',
        '27' => 'required',
        '28' => 'required',
        '29' => 'required',
    ];
}
