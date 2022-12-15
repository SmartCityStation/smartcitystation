<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VariableDevice
 * @package App\Models\Backend
 * @version May 8, 2021, 2:28 pm UTC
 *
 * @property \App\Models\Backend\Device $device
 * @property \App\Models\Backend\DataVariable $dataVariable
 * @property integer $device_id
 * @property integer $data_variable_id
 */
class VariableDevice extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'variable_devices';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
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
        'device_id' => 'integer',
        'data_variable_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
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
