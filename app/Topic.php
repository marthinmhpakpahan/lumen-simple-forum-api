<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'content', 'status'];

    protected $visible = ['id', 'user_id', 'title', 'content', 'status', 'created_at', 'updated_at', 'user', 'commentsCount'];

    protected $appends = ['commentsCount'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function comment() {
        return $this->hasMany(Comment::class, 'topic_id');
    }

    public function getCommentsCountAttribute()
    {
        return $this->comment()->count();
    }

}
