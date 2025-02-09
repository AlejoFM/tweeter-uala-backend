<?php

namespace src\Tweet\Infrastructure\Persistence\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\User\Infrastructure\Persistence\UserEloquentModel;
use Carbon\Carbon;

class TweetEloquentModelFactory extends Factory
{
    protected $model = TweetEloquentModel::class;
    
    // Contador para asegurar fechas únicas y ordenadas
    private static int $sequence = 0;

    public function definition(): array
    {
        self::$sequence++;
        $baseDate = Carbon::parse('2025-01-01');
        
        return [
            'content' => fake()->text(140),
            'user_id' => UserEloquentModel::factory()->create()->id,
            'created_at' => $baseDate->addMinutes(self::$sequence),
            'updated_at' => $baseDate->addMinutes(self::$sequence)
        ];
    }

    public function forUser(UserEloquentModel $user): static
    {
        return $this->state([
            'user_id' => $user->id
        ]);
    }

    public function withContent(string $content): static
    {
        return $this->state([
            'content' => $content
        ]);
    }
}