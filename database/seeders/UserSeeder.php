<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@library.com',
                'password' => '$2y$10$46YMQa3AiHzQKMd2GHOq8OqCNjHGuis8Gkefor89EJyxk/vtdj7.C',
                'is_admin' => true,
            ],
        ]);

        User::factory(5)->create();
    }
}
