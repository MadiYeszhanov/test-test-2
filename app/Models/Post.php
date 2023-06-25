<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id','title', 'body','status', 'published_at', 'blocked_at', 'blocked_comment'
    ];

    protected $appends = [
        'short'
    ];

    protected $hidden = [
        'blocked_at',
        'blocked_comment',
        'created_at',
        'updated_at',
        'user_id'
    ];

    public function getShortAttribute(){
        return substr($this->attributes['body'], 0, 100);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
