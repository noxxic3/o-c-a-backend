<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DietController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diets = Diet::all();
        return $diets;
    }

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
        //return $request;
        //return $request->file('image')->getClientOriginalName();


        // Handle File Upload
        if( $request->hasFile('image') ){                                     // Verificamos si hay archivo, aunque en este caso es obligatiorio.
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);          // pathinfo()  es una función de PHP, no de Laravel. Extract the fileName without the extension
            // Get just extension, for example:   .jpg
            $extension = $request->file('image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image file to the destination folder
            $path = $request->file('image')->storeAs('public/images/treatments', $fileNameToStore);
        } else {
            $fileNameToStore = 'image-solid.svg';
        }

        $diet = new Diet();
        $diet->name = $request->input('name');
        $diet->image = $fileNameToStore;  //$request->input('image');
        $diet->description = $request->input('description');
        $diet->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Diet  $diet
     * @return \Illuminate\Http\Response
     */
    public function show(Diet $diet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Diet  $diet
     * @return \Illuminate\Http\Response
     */
    public function edit(Diet $diet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Diet  $diet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)           // Diet $diet
    {
        //return $request;

        // Handle File Upload
        if( $request->hasFile('image') ){                                     // Verificamos si hay archivo, en el formulario de edición no es obligatorio
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);          // pathinfo()  es una función de PHP, no de Laravel. Extract the fileName without the extension
            // Get just extension, for example:   .jpg
            $extension = $request->file('image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image file to the destination folder
            $path = $request->file('image')->storeAs('public/images/treatments', $fileNameToStore);  // <-- Guarda archivo
        }

        $diet = Diet::find($id);
        $diet->name = $request->input('name');
        $diet->description = $request->input('description');

        // Si ha subido imagen nueva...
        if( $request->hasFile('image') ) {
            // Eliminamos la anterior que había
            if($diet->image != 'image-solid.svg'){   // Solo borramos la imagen anterior que había si no era la imagen por defecto, ya que esa la usan otros registros
                // Delete image file
                Storage::delete('public/images/treatments/'.$diet->image);        // ruta   storage/app/public/images/patients/
            }
            // A continuación actualizamos el valor del campo image del usuario paciente.
            $diet->image = $fileNameToStore;
        }

        // Si no ha subido archivo de imagen nuevo, el campo  $diet->image  se deja tal cual
        $diet->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Diet  $diet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)        // Diet $diet
    {
        $diet = Diet::find($id);

        if($diet->image != 'image-solid.svg'){
            // Delete image file
            Storage::delete('public/images/treatments/'.$diet->image);
        }

        $diet->delete();
    }
}
