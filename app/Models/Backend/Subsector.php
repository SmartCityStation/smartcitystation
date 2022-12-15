<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subsector extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table = 'subsectors';
    
    protected $dates = ['deleted_at'];


    public $fillable = [
        'description',
        'alert_threshold_day',
        'alert_threshold_night',
        'sector_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
        'alert_threshold_day' => 'float',
        'alert_threshold_night' => 'float',
        'sector_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'description' => 'required',
        'alert_threshold_day' => 'required',
        'alert_threshold_night' => 'required',
        'sector_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sector()
    {
        return $this->belongsTo(\App\Models\Backend\Sector::class, 'sector_id', 'id');
    }
}
