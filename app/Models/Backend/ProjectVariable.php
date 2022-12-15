<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectVariable extends Model
{
    use HasFactory;

    public $table = 'project_variables';


    public $fillable = [
        'project_id',
        'data_variable_id'
    ];

    public static $rules = [
        'project_id' => 'required',
        'data_variable_id' => 'required'
    ];
    
    public function project()
    {
        return $this->hasMany(\App\Models\Backend\Project::class, 'project_id', 'id');
    }

    public function dataVariable()
    {
        return $this->hasMany(\App\Models\Backend\DataVariable::class, 'data_variable_id', 'id');
    }
}
