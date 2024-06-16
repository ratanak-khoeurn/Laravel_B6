<?php

namespace App\Models\Share;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table = 'like_shares';
    protected $guarded = ['id'];
}
