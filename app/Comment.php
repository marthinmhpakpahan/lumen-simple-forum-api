<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic_id', 'user_id', 'content', 'status'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
