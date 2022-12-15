<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DataVariable
 * @package App\Models\Backend
 * @version April 30, 2021, 10:06 pm UTC
 *
 * @property \App\Models\Backend\Type_variable $typeVariable
 * @property string $name
 * @property string $description
 * @property string $alert_threshold
 * @property integer $type_variable_id
 */
class DataVariable extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'data_variables';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'type_variable_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'type_variable_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type_variable_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function typeVariable()
    {
        return $this->belongsTo(\App\Models\Backend\Type_variable::class, 'type_variable_id', 'id');
    }
}
