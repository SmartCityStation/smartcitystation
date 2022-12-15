<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class EventLog
 * @package App\Models\Backend
 * @version August 19, 2021, 5:20 pm UTC
 *
 * @property string $date_event
 * @property string $type_event
 * @property string $description
 */
class EventLog extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'event_logs';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'date_event',
        'type_event',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_event' => 'datetime',
        'type_event' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date_event' => 'required',
        'type_event' => 'required',
        'description' => 'required'
    ];

    
}
