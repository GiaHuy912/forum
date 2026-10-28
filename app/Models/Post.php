<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    /**
     * Get the user who wrote the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments of the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
    return $this->belongsTo(Category::class);
    }
}