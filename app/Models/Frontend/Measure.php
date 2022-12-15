<?php

namespace App\Models\Frontend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Measure
 * @package App\Models\Frontend
 * @version May 13, 2021, 5:16 pm UTC
 *
 * @property \App\Models\Frontend\Device $device
 * @property \App\Models\Frontend\DataVariable $dataVariable
 * @property string $date
 * @property time $hour
 * @property string $data
 * @property integer $device_id
 * @property integer $data_variable_id
 */
class Measure extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'measures';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'time',
        'data',
        'device_id',
        'data_variable_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'time' => 'datetime',
        'data' => 'float',
        'device_id' => 'integer',
        'data_variable_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'time' => 'required',
        'data' => 'required',
        'device_id' => 'required',
        'data_variable_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function device()
    {
        return $this->belongsTo(\App\Models\Backend\Device::class, 'device_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function dataVariable()
    {
        return $this->belongsTo(\App\Models\Backend\DataVariable::class, 'data_variable_id', 'id');
    }
}
