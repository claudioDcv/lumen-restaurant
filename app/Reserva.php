<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{

    protected $table = 'reserva';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mesa_id'];

    protected $hidden = [];

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    public function mesa()
    {
        return $this->belongsTo('App\Mesa');
    }

    public function pedidos() {
        return $this->hasMany('App\Pedido');
    }
    
}
