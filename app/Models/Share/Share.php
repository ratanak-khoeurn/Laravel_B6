<?php

namespace App\Models\Share;

use App\Models\Comment\Comment;
use App\Models\Post\Like;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;
    protected $table = 'shares';
    protected $primaryKey = ['id'];

    public function getAllComments(){
        return $this->hasMany(Comment::class, 'share_id');
    }
    public function getAllLikes(){
        return $this->hasMany(Like::class, 'share_id');
    }
}
