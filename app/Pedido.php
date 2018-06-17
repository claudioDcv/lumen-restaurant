<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

    protected $table = 'pedido';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $hidden = [];

    public function reserva()
    {
        return $this->belongsTo('App\Reserva');
    }

    public function producto()
    {
        return $this->belongsTo('App\Producto');
    }
}
