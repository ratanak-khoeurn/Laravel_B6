<?php

namespace App\Models\Post;

use App\Models\Comment\Comment;
use App\Models\Post\Like;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = ['id'];


    public function getUser(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAllComment(){
        return $this->hasMany(Comment::class, 'post-id');
    }
    public function getAllLike(){
        return $this->hasMany(Like::class, 'post-id');
    }
}
