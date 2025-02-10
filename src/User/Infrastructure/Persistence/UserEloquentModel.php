<?php

declare(strict_types=1);

namespace src\User\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use src\User\Infrastructure\Persistence\Factories\UserEloquentModelFactory;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;

class UserEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['username'];

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected static function newFactory()
    {
        return UserEloquentModelFactory::new();
    }

    /**
     * Get the tweets associated with the user.
     *

     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function tweets()
    {
        return $this->hasMany(TweetEloquentModel::class, 'user_id');
    }

    public function following()
    {
        return $this->belongsToMany(UserEloquentModel::class, 'follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(UserEloquentModel::class, 'follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }
    

}
