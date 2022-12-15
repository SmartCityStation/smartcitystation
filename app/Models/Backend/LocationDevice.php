<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LocationDevice
 * @package App\Models\Backend
 * @version May 5, 2021, 10:37 pm UTC
 *
 * @property \App\Models\Backend\Device $device
 * @property \App\Models\Backend\Area $area
 * @property string $address
 * @property string $installation_date
 * @property time $installation_hour
 * @property string $remove_date
 * @property time $remove_hour
 * @property string $latitude
 * @property string $length
 * @property integer $device_id
 * @property integer $area_id
 */
class LocationDevice extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'location_devices';

    protected $guarded = [];
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'address',
        'installation_date',
        'installation_hour',
        'remove_date',
        'latitude',
        'length',
        'device_id',
        'area_id',
        'project_id',
        'subsector_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'address' => 'string',
        'installation_date' => 'date',
        'installation_hour' => 'datetime',
        'remove_date' => 'date',
        'latitude' => 'string',
        'length' => 'string',
        'device_id' => 'integer',
        'area_id' => 'integer',
        'project_id' => 'integer',
        'subsector_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'address' => 'required',
        'device_id' => 'required',
        'area_id' => 'required',
        'project_id'  => 'required',
        'subsector_id' => 'required',
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
    public function area()
    {
        return $this->belongsTo(\App\Models\Backend\Area::class, 'area_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\Backend\Project::class, 'project_id', 'id');
    }

    public function subsector()
    {
        return $this->belongsTo(\App\Models\Backend\Subsector::class, 'subsector_id', 'id');
    }
}
