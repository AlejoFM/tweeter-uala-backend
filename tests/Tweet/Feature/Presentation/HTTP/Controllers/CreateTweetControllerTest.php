<?php

declare(strict_types=1);

namespace Tests\Tweet\Feature\Presentation\HTTP\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class CreateTweetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_tweet(): void
    {
        $response = $this->postJson('/api/tweets', [
            'content' => 'Hello World'
        ], [
            'X-User-Id' => '1'
        ]);
        Log::info('Response:', [
            'status' => $response->status(),
            'content' => $response->getContent()
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'content' => 'Hello World',
                    'user_id' => 1
                ]
            ]);
    }

    public function test_cannot_create_tweet_without_user_id(): void
    {
        $response = $this->postJson('/api/tweets', [
            'content' => 'Hello World'
        ],[
            
        ]);


        $response->assertStatus(401);
    }
} 