<?php

namespace App\Models\Share;

use App\Models\Share\Comment;
use App\Models\Share\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;
    protected $table = 'shares';
    protected $guarded = ['id'];
    public function getUser(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getAllComments(){
        return $this->hasMany(Comment::class, 'share_id');
    }
    public function getAllLikes(){
        return $this->hasMany(Like::class, 'share_id');
    }
}
