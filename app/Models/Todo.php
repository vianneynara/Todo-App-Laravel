<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model 
{
    use HasFactory;

    protected $primaryKey = 'todo_id';

    protected $fillable = [
        'user_id',
        'description',
        'is_completed',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
        ];
    }

    //many to one relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}