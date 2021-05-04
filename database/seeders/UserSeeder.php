<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Michal',
                'email' => 'jj@tt.com',
                'password' => bcrypt('secret'),
            ],
            [
                'first_name' => 'Malcolm',
                'last_name' => 'Dick',
                'email' => 'mm@tt.com',
                'password' => bcrypt('secret'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
