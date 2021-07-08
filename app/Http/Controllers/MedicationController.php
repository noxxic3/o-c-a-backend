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
        if( $request->hasFile('image') ){                                     // Check if there is a file, although in the store form is mandatory.
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);          // pathinfo() is PHP, not Laravel. Extract the fileName without the extension
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
        if( $request->hasFile('image') ){                                     // Check if there is a file, in the edit form it is not mandatory.
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);          // pathinfo() is PHP, not Laravel. Extract the fileName without the extension
            // Get just extension, for example:   .jpg
            $extension = $request->file('image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image file to the destination folder
            $path = $request->file('image')->storeAs('public/images/treatments', $fileNameToStore);  // Store file
        }

        $medication = Medication::find($id);
        $medication->name = $request->input('name');
        $medication->posology = $request->input('description');

        // If a new image has been uploaded...
        if( $request->hasFile('image') ) {
            // Delete the previous image stored
            if($medication->image != 'image-solid.svg'){   // We only delete the previous image stored if it was not the default image, since that is shared by other records
                // Delete image file
                Storage::delete('public/images/treatments/'.$medication->image);       //   storage/app/public/images/
            }
            // Next, we update the value of the image field of the table.
            $medication->image = $fileNameToStore;
        }

        // If the user has not uploaded a new image file, the $___->image field is left as is
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
