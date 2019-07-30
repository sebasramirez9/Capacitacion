<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar=='')
        {
            $articulos = Articulo::join('categorias','article.art_catId','=','categorias.id')->
            select('article.id','article.art_catId','article.art_codigo','article.art_name','categorias.cat_name as nombre_categoria','article.art_precio_venta','article.art_descripcion','article.art_condition')->
            orderBy('article.id','desc')->paginate(2);
        }
        else{
            $articulos = Articulo::join('categorias','article.art_catId','=','categorias.id')->
            select(all)->
            where('article.'.$criterio, 'like' , '%'.$buscar.'%')->
            orderBy('article.id','desc')->paginate(2);

        }
        return
            [
                'pagination' =>
                    [
                        'total' => $articulos->total(),
                        'current_page' => $articulos->currentPage(),
                        'per_page' => $articulos->perPage(),
                        'last_page' => $articulos->lastPage(),
                        'from'  => $articulos->firstItem(),
                        'to' => $articulos->lastItem(),
                    ],
                'articulos'=>$articulos
            ];


    }
    public function store(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');
        $articulo = new Articulo();
        $articulo->art_catId=$request->IdCategory;
        $articulo->art_codigo=$request->code;
        $articulo->art_name=$request->name;
        $articulo->art_precio_venta=$request->price;
        $articulo->art_descripcion=$request->description;
        $articulo->art_condition='1';
        $articulo->save();

    }
    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $articulo =  Articulo::findOrFail($request->id);
        $articulo->art_catId=$request->IdCategory;
        $articulo->art_codigo=$request->code;
        $articulo->art_name=$request->name;
        $articulo->art_precio_venta=$request->price;
        $articulo->art_descripcion=$request->description;
        $articulo->art_condition='1';
        $articulo->save();
    }
    public function off(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $articulo=  Articulo::findOrFail($request->id);
        $articulo->art_condition='0';
        $articulo->save();
    }
    public function on(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $articulo =  Categoria::findOrFail($request->id);
        $articulo->art_condition='1';
        $articulo->save();
    }
}
