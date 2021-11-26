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

    protected $visible = ['user_id', 'title', 'content', 'status', 'created_at', 'updated_at', 'user', 'category'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

}
