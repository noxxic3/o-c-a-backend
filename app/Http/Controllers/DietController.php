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
        // Handle File Upload
        if( $request->hasFile('image') ){                                     // Check if there is a file, although in the register form is mandatory.
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
        // Handle File Upload
        if( $request->hasFile('image') ){                                     // Check if there is a file, in the edit form it is not mandatory
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just extension, for example:   .jpg
            $extension = $request->file('image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image file to the destination folder
            $path = $request->file('image')->storeAs('public/images/treatments', $fileNameToStore);   // Save file
        }

        $diet = Diet::find($id);
        $diet->name = $request->input('name');
        $diet->description = $request->input('description');

        // If the user has uploaded a new image...
        if( $request->hasFile('image') ) {
            // Delete the previous image stored
            if($diet->image != 'image-solid.svg'){   // We only delete the previous image stored if it was not the default image, since that is shared by other records
                // Delete image file
                Storage::delete('public/images/treatments/'.$diet->image);        //  storage/app/public/images/
            }
            // Next, we update the value of the image field of the table.
            $diet->image = $fileNameToStore;
        }

        // If the user has not uploaded a new image file, the $___->image field is left as is
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
