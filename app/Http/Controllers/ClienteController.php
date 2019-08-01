<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar=='')
        {
            $personas = Persona::orderBy('id','desc')->paginate(3);
        }
        else{
            $personas= Persona::where($criterio, 'like' , '%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }
        return
            [
                'pagination' =>
                    [
                        'total' => $personas->total(),
                        'current_page' => $personas->currentPage(),
                        'per_page' => $personas->perPage(),
                        'last_page' => $personas->lastPage(),
                        'from'  => $personas->firstItem(),
                        'to' => $personas->lastItem(),
                    ],
                'personas'=>$personas
            ];
    }
    public function store(Request $request)
    {

        // if(!$request->ajax()) return redirect('/');


        $personas = new Persona();
        $personas->nombre=$request->name;
        $personas->tipo_documento=$request->type_document;
        $personas->num_documento=$request->num_document;
        $personas->direccion=$request->address;
        $personas->telefono=$request->tel;
        $personas->email=$request->email;
        $personas->save();

    }
    public function update(Request $request)
    {

        //if(!$request->ajax()) return redirect('/');

        $personas =  Persona::findOrFail($request->id);
        $personas->nombre=$request->name;
        $personas->tipo_documento=$request->type_document;
        $personas->num_documento=$request->num_document;
        $personas->direccion=$request->address;
        $personas->telefono=$request->tel;
        $personas->email=$request->email;
        $personas->save();
    }
}
