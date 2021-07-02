<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xxx;

class XxxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $xxx = Xxx::all();
        //$xxx = Xxx::orderBy('id', 'desc')->get();           //  ->take(1) antes de ->get() si queremos limitar la cantidad de resultados.
        return $xxx;
    }
    /*
    public function index($id){
        return 'XXX ' . $id;
    }
    */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*$this->validate( $request, [

        ]);*/

        $xxx = new Xxx();
                                                            // El ID de la TABLA no se asigna al atributo de la instancia, el método id() de la Migración creo que ya genera un ID automático para la instancia.
        //$xxx->created_at = $request->input('created_at');
        //$xxx->updated_at = $request->input('updated_at');
        $xxx->title = $request->input('title');             // El nombre del atributo de la instancia $xxx->__  es el mismo que tiene la tabla de la BD al que queremos asignar el valor      // El nombre que ponemos en el  ->input('__') es el nombre del atributo que queremos acceder del objeto recibido que se ha enviado a través de AJAX.
        $xxx->name = $request->input('name');

        $xxx->save();               // save() generará un evento de confirmación que recibirá la petición POST del frontend de retorno. Los datos enviados desde el frontend se podrán ver en la propiedad 'config.data' del objeto que podemos consultar en el console.log() que recibe el frontend de retorno.
        //return 'Fuck';              // Si retornamos algo se añadirá al evento de confirmación a su propiedad 'data'
                                      // No sé si es aquí donde Laravel asigna el token en el caso del UserController cuando se hace la autenticación.
                                      // En el caso de Firebase dice que en la propiedad ".data" de la instancia del evento de confirmación recibido se recibe el ID que le ha asignado la BD al registro.
        //return $request->query();
        //return $request->input('created_at');
                                      // Si usamos Laravel no como API REST, aquí se retornaría una Vista de Laravel con un mensaje que escribimos de confirmación.
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return $id;
        return Xxx::find($id);
        //return Xxx::where('title', 'Title 2')->get();
        //return 'Fuck';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $xxx = Xxx::find($id);
        // El ID de la TABLA no se asigna al atributo de la instancia, el método id() de la Migración creo que ya genera un ID automático para la instancia.
        //$xxx->created_at = $request->input('created_at');
        //$xxx->updated_at = $request->input('updated_at');
        return $request->input('title');
        $xxx->title = $request->input('title');
        $xxx->name = $request->input('name');
        $xxx->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $xxx = Xxx::find($id);
        $xxx->delete();
    }
}
