<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowSeeder extends Seeder
{
    public function run(): void
    {
        $follows = [];
        $users = DB::table('users')->pluck('id');
        
        foreach ($users as $followerId) {
            foreach ($users as $followingId) {
                if ($followerId !== $followingId && rand(0, 1)) {
                    $follows[] = [
                        'follower_id' => $followerId,
                        'following_id' => $followingId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('follows')->insert($follows);
    }
} 