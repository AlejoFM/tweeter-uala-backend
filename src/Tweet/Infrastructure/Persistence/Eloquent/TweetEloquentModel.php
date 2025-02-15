<?php

declare(strict_types=1);

namespace src\Tweet\Infrastructure\Persistence\Eloquent;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use src\User\Domain\Models\Entities\User;
use src\User\Infrastructure\Persistence\UserEloquentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use src\Tweet\Infrastructure\Persistence\Factories\TweetEloquentModelFactory;

class TweetEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'tweets';
    
    protected $fillable = [
        'user_id',
        'content',
        'created_at'
    ];

    protected $with = ['user'];

    protected static function newFactory(): TweetEloquentModelFactory
    {
        return TweetEloquentModelFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id');
    }

    public function userEloquentModel(): BelongsTo
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at->toDateTime();
    }


    // Si necesitas el usuario como modelo de dominio
    public function getDomainUser(): User
    {
        return User::fromPrimitives(
            $this->user->id,
            $this->user->username,
        );
    }

    public static function factory(): TweetEloquentModelFactory
    {
        return TweetEloquentModelFactory::new();
    }
}

