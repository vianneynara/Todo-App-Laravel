<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'password',
    ];
    

    protected $hidden = [
        'password',
    ];
    
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    //one to many relationship
    public function todos()
    {
        return $this->hasMany(Todo::class, 'user_id', 'user_id');
    }
}
