<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Device
 * @package App\Models\Backend
 * @version May 1, 2021, 12:30 am UTC
 *
 * @property string $device_code
 * @property tinyint $state
 */
class Device extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'devices';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'device_code',
        'state'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'device_code' => 'string',
        // 'state' => 'tinyInteger' 
        // 'state' => 'integer' 
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'device_code' => 'required',
        // 'device_code' => 'unique',
        // 'device_code' => 'required|unique',
        // 'state' => 'required'
    ];

    
}
