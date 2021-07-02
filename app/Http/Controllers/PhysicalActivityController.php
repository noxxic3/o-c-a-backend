<?php

namespace App\Http\Controllers;

use App\Models\PhysicalActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhysicalActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $physicalActivities = PhysicalActivity::all();
        return $physicalActivities;
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

        $physical_activity = new PhysicalActivity();
        $physical_activity->name = $request->input('name');
        $physical_activity->image = $fileNameToStore;  //$request->input('image');
        $physical_activity->description = $request->input('description');
        $physical_activity->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhysicalActivity  $physicalActivity
     * @return \Illuminate\Http\Response
     */
    public function show(PhysicalActivity $physicalActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhysicalActivity  $physicalActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(PhysicalActivity $physicalActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhysicalActivity  $physicalActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)      // PhysicalActivity $physicalActivity
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

        $physical_activity = PhysicalActivity::find($id);
        $physical_activity->name = $request->input('name');
        $physical_activity->description = $request->input('description');

        // Si ha subido imagen nueva...
        if( $request->hasFile('image') ) {
            // Eliminamos la anterior que había
            if($physical_activity->image != 'image-solid.svg'){   // Solo borramos la imagen anterior que había si no era la imagen por defecto, ya que esa la usan otros registros
                // Delete image file
                Storage::delete('public/images/treatments/'.$physical_activity->image);        // ruta   storage/app/public/images/patients/
            }
            // A continuación actualizamos el valor del campo image del usuario paciente.
            $physical_activity->image = $fileNameToStore;
        }

        // Si no ha subido archivo de imagen nuevo, el campo  $___>image  se deja tal cual
        $physical_activity->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhysicalActivity  $physicalActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)        // PhysicalActivity $physicalActivity
    {
        $physical_activity = PhysicalActivity::find($id);

        if($physical_activity->image != 'image-solid.svg'){
            // Delete image file
            Storage::delete('public/images/treatments/'.$physical_activity->image);
        }

        $physical_activity->delete();
    }
}
