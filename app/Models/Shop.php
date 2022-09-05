<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

  protected $with = ['user'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function scopeEstado($query, $estado)
  {
    if ($estado) {
        $estado = ($estado == 'Activo') ? 1 : 0;

        $query->whereHas('user', function ($query) use ($estado) {
            $query->where('approved', $estado);
        });
    }
  }

  public function scopeTipoNegocio($query, $tipo)
  {
    if ($tipo) {
        $query->where('tipo', $tipo);
    }
  }

  public function scopeTipoEmpresa($query, $tipo)
  {
    if ($tipo) {
        $query->where('tipo_empresa', $tipo);
    }
  }
}
