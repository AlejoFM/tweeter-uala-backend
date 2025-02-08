<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use src\User\Infrastructure\Persistence\UserEloquentModel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock Redis para tests
        $mock = \Mockery::mock('alias:Illuminate\Support\Facades\Redis');
        $mock->shouldReceive('incr')->andReturn(1);
        $mock->shouldReceive('get')->andReturn(1);
        $mock->shouldReceive('set')->andReturn(true);
        $mock->shouldReceive('expire')->andReturn(true);
        $mock->shouldReceive('setex')->andReturn(true);
        $mock->shouldReceive('del')->andReturn(true);
        $mock->shouldReceive('ttl')->andReturn(1000);
        
        $this->artisan('migrate');
        UserEloquentModel::factory()->create(['id' => 1]);
    }
}
