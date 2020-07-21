<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'author', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
