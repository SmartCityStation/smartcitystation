<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Area
 * @package App\Models\Backend
 * @version May 3, 2021, 10:22 pm UTC
 *
 * @property \App\Models\Backend\Village $village
 * @property string $name
 * @property integer $village_id
 */
class Area extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'areas';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'village_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'village_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'village_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function village()
    {
        return $this->belongsTo(\App\Models\Backend\Village::class, 'village_id', 'id');
    }
}
