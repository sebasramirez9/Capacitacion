<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'article';
    protected $fillable =
        [
            'art_catId','art_codigo',	'art_name',	'art_precio_venta',	'art_descripcion',	'art_condition',	'created_at',	'updated_at'
        ];
    public function categoria()
    {
        return $this->belongsTo('App\Categoria');

    }

}
