<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable=['id','cat_name','cat_description','cat_condition'];
    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}
