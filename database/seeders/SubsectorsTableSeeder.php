<?php

namespace Database\Seeders;

use App\Models\Backend\Subsector;
use Illuminate\Database\Seeder;

class SubsectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subsector::create([
            'description' => 'Hospitales, bibliotecas, guarderías, sanatorios, hogares geriátricos.',
            'alert_threshold_day' => 55,
            'alert_threshold_night' => 50,
            'sector_id' => 1,
        ]);

        Subsector::create([
            'description' => 'Zonas residenciales o exclusivamentes destinadas para desarrollo habitacional, hostelería y hospedajes.',
            'alert_threshold_day' => 65,
            'alert_threshold_night' => 55,
            'sector_id' => 2,
        ]);

        Subsector::create([
            'description' => 'Universidades, colegios, escuelas, centros de estudio e investigación.',
            'alert_threshold_day' => 65,
            'alert_threshold_night' => 55,
            'sector_id' => 2,
        ]);

        Subsector::create([
            'description' => 'Parques en zonas urbanas diferentes a los parques mecanicos al aire libre.',
            'alert_threshold_day' => 65,
            'alert_threshold_night' => 55,
            'sector_id' => 2,
        ]);

        Subsector::create([
            'description' => 'Zonas con usos permitidos industriales, como industrias en general, zonas portuarias, parques industriales, zonas francas',
            'alert_threshold_day' => 75,
            'alert_threshold_night' => 75,
            'sector_id' => 3,
        ]);

        Subsector::create([
            'description' => 'Zonas con usos permitidos comerciales como centros comerciales, almacenes, locales o intalaciones de tipo comercial, talleres de mecánica automotriz e insdustrial, centros deportivos y recreativos, gimnasios, restaurantes, bares, tabernas, discotecas, bingos, casinos.',
            'alert_threshold_day' => 70,
            'alert_threshold_night' => 60,
            'sector_id' => 3,
        ]);

        Subsector::create([
            'description' => 'Zonas con uso permitido de oficinas.',
            'alert_threshold_day' => 65,
            'alert_threshold_night' => 55,
            'sector_id' => 3,
        ]);

        Subsector::create([
            'description' => 'Zona con uso institucionales.',
            'alert_threshold_day' => 65,
            'alert_threshold_night' => 55,
            'sector_id' => 3,
        ]);

        Subsector::create([
            'description' => 'Zonas con otros usos relacionados, como parques mecánicos al aire lible, 
            áreas destinadas a espectáculos públicos al aire libre.',
            'alert_threshold_day' => 80,
            'alert_threshold_night' => 75,
            'sector_id' => 3,
        ]);

        Subsector::create([
            'description' => 'Residencia suburbana.',
            'alert_threshold_day' => 55,
            'alert_threshold_night' => 50,
            'sector_id' => 4,
        ]);

        Subsector::create([
            'description' => 'Rural habitada destinad a explotación agropecuaria.',
            'alert_threshold_day' => 55,
            'alert_threshold_night' => 50,
            'sector_id' => 4,
        ]);

        Subsector::create([
            'description' => 'Zonas de recreación y descanso. como parques naturales y reservas naturales',
            'alert_threshold_day' => 55,
            'alert_threshold_night' => 50,
            'sector_id' => 4,
        ]);
    }
}
