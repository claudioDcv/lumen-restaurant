<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $table = 'producto';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $hidden = [];
}
