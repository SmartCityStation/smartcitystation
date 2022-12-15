<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Add the master administrator, user id of 1
        User::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'Juan Esteban',
            'surname' => 'Gonzalez',
            'phone'=> '3146133941',
            'address'=>'',
            'email' => 'Phononsas@gmail.com',
            'password' => 'Jgonzalez2020',
            'email_verified_at' => now(),
            'active' => true,
        ]);

        // if (app()->environment(['local', 'testing'])) {
            User::create([
                'type' => User::TYPE_USER,
                'name' => 'Test User',
                'email' => 'visitor@smartcitystation.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'active' => true,
            ]);

            User::create([
                'type' => User::TYPE_CUSTOMER,
                'name' => 'Test Customer',
                'email' => 'customer@smartcitystation.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'active' => true,
            ]);
        // }

        $this->enableForeignKeys();
    }
}
