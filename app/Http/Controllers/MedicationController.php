<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medications = Medication::all();
        return $medications;
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

        $medication = new Medication();
        $medication->name = $request->input('name');
        $medication->image = $fileNameToStore;  //$request->input('image');
        $medication->posology = $request->input('description');
        $medication->save();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function show(Medication $medication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function edit(Medication $medication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)      // Medication $medication
    {

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

        $medication = Medication::find($id);
        $medication->name = $request->input('name');
        $medication->posology = $request->input('description');

        // Si ha subido imagen nueva...
        if( $request->hasFile('image') ) {
            // Eliminamos la anterior que había
            if($medication->image != 'image-solid.svg'){   // Solo borramos la imagen anterior que había si no era la imagen por defecto, ya que esa la usan otros registros
                // Delete image file
                Storage::delete('public/images/treatments/'.$medication->image);        // ruta   storage/app/public/images/patients/
            }
            // A continuación actualizamos el valor del campo image del usuario paciente.
            $medication->image = $fileNameToStore;
        }

        // Si no ha subido archivo de imagen nuevo, el campo  $___>image  se deja tal cual
        $medication->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)     // Medication $medication
    {
        $medication = Medication::find($id);

        if($medication->image != 'image-solid.svg'){
            // Delete image file
            Storage::delete('public/images/treatments/'.$medication->image);
        }

        $medication->delete();
    }
}
