<?php

namespace Database\Seeders;

use App\Models\Backend\Device;
use Illuminate\Database\Seeder;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Device::create([
            'device_code'=> 'DEV_001',
            'state' => 1
        ]);

        Device::create([
            'device_code'=> 'DEV_002',
            'state' => 1
        ]);
    }
}
