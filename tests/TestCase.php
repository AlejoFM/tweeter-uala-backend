<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Config;
use src\User\Infrastructure\Persistence\UserEloquentModel;
use Mockery;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configurar Predis para testing
        Config::set('database.redis.client', 'predis');
        
        // Mock Redis con Predis
        $redisMock = Mockery::mock('Predis\Client');
        $redisMock->shouldReceive('get')->andReturn(null);
        $redisMock->shouldReceive('set')->andReturn('OK');
        $redisMock->shouldReceive('setex')->andReturn('OK');
        $redisMock->shouldReceive('del')->andReturn(1);
        $redisMock->shouldReceive('expire')->andReturn(1);
        $redisMock->shouldReceive('flushall')->andReturn('OK');
        $redisMock->shouldReceive('flushdb')->andReturn('OK');
        $redisMock->shouldReceive('incr')->andReturn(1);
        $redisMock->shouldReceive('ttl')->andReturn(300);
        
        Redis::swap($redisMock);
        
        $this->artisan('migrate');
        UserEloquentModel::factory()->create(['id' => 1]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
