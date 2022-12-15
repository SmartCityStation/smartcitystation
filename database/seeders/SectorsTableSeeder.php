<?php

namespace Database\Seeders;

use App\Models\Backend\Sector;
use Illuminate\Database\Seeder;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sector::create([
            'id' => 1,
            'name' => 'Sector A. Tranquilidad y silencio'
        ]);

        Sector::create([
            'id' => 2,
            'name' => 'Sector B. Tranquilidad y ruido moderado'
        ]);

        Sector::create([
            'id' => 3,
            'name' => 'Sector C. Ruido intermedio restrigido'
        ]);

        Sector::create([
            'id' => 4,
            'name' => 'Sector D. Zona suburbana o rural de tranquilidad y ruido moderado'
        ]);
    }
}
