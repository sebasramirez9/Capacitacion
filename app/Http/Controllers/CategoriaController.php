<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
//use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // if(!$request->ajax()) return redirect('/');
            $buscar= $request->buscar;
            $criterio = $request->criterio;

            if($buscar=='')
            {
                $categoria = Categoria::orderBy('id','desc')->paginate(2);
            }
            else{
                $categoria= Categoria::where($criterio, 'like' , '%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
            }
            return
                [
                    'pagination' =>
                        [
                            'total' => $categoria->total(),
                            'current_page' => $categoria->currentPage(),
                            'per_page' => $categoria->perPage(),
                            'last_page' => $categoria->lastPage(),
                            'from'  => $categoria->firstItem(),
                            'to' => $categoria->lastItem(),
                        ],
                    'categoria'=>$categoria
                ];





    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // if(!$request->ajax()) return redirect('/');
        $categoria = new Categoria();
        $categoria->cat_name=$request->name;
        $categoria->cat_description=$request->description;
        $categoria->cat_condition='1';
        $categoria->save();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $categoria =  Categoria::findOrFail($request->id);
        $categoria->cat_name=$request->name;
        $categoria->cat_description=$request->description;
        $categoria->cat_condition='1';
        $categoria->save();
    }
    public function off(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $categoria =  Categoria::findOrFail($request->id);
        $categoria->cat_condition='0';
        $categoria->save();
    }
    public function on(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $categoria =  Categoria::findOrFail($request->id);
        $categoria->Cat_condition='1';
        $categoria->save();
    }
}
