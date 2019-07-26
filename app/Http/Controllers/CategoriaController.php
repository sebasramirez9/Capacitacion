<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoria = Categoria::all();
        return $categoria;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $categoria =  Categoria::findOrFail($request->id);
        $categoria->cat_name=$request->name;
        $categoria->cat_description=$request->description;
        $categoria->cat_condition='1';
        $categoria->save();
    }
    public function off(Request $request)
    {
        $categoria =  Categoria::findOrFail($request->id);
        $categoria->cat_condition='0';
        $categoria->save();
    }
    public function on(Request $request)
    {
        $categoria =  Categoria::findOrFail($request->id);
        $categoria->Cat_condition='1';
        $categoria->save();
    }
}
