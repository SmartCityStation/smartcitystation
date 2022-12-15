<?php

namespace Database\Seeders;

use App\Models\Backend\Type_variable;
use Illuminate\Database\Seeder;

class TypeVariablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type_variable::create([
            'id' => 1,
            'name' => 'Ruido',
            'description' => 'Ruido'
        ]);

        Type_variable::create([
            'id' => 2,
            'name' => 'Variable ambiental',
            'description' => 'Variable ambiental'
        ]);
    }
}
