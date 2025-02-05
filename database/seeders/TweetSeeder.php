<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TweetSeeder extends Seeder
{
    public function run(): void
    {
        $tweets = [];
        $users = DB::table('users')->pluck('id');
        
        foreach ($users as $userId) {
            for ($i = 1; $i <= 5; $i++) {
                $tweets[] = [
                    'user_id' => $userId,
                    'content' => "Tweet #{$i} from user {$userId}",
                    'created_at' => now()->subHours(rand(1, 48)),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('tweets')->insert($tweets);
    }
} 