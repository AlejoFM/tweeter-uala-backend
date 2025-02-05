<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['username' => 'john_doe'],
            ['username' => 'jane_doe'],
            ['username' => 'bob_smith'],
            ['username' => 'alice_jones'],
            ['username' => 'sam_wilson'],
        ];

        DB::table('users')->insert($users);
    }
} 