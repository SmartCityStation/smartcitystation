<?php

namespace Database\Seeders;

use App\Models\Backend\DataVariable;
use Illuminate\Database\Seeder;

class DataVariablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataVariable::create([
            'name' => 'LAeq',
            'description' => 'Nivel Continuo Equivalente de Ruido',
            'type_variable_id'=> 1,

        ]);

        DataVariable::create([
            'name' => 'Temperatura',
            'description' => 'Temperatura',
            'type_variable_id'=> 2,

        ]);

        DataVariable::create([
            'name' => 'Humedad relativa',
            'description' => 'Humedad relativa',
            'type_variable_id'=> 2,

        ]);

        DataVariable::create([
            'name' => 'Presión atmosférica',
            'description' => 'Presión atmosférica',
            'type_variable_id'=> 2,

        ]);

        DataVariable::create([
            'name' => 'PM 10',
            'description' => 'Índice de material particulado de 10 micras',
            'type_variable_id'=> 2,

        ]);
    }
}
