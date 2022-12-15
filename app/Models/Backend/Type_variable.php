<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Type_variable
 * @package App\Models\Backend
 * @version April 30, 2021, 5:13 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $dataVariables
 * @property string $name
 * @property string $description
 */
class Type_variable extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'type_variables';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function dataVariables()
    {
        return $this->hasMany(\App\Models\Backend\Data_variable::class, 'type_variable_id', 'id');
    }
}
