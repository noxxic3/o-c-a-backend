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
        if( $request->hasFile('image') ){                                     // Check if there is a file, in the edit form it is not mandatory.
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just extension, for example:   .jpg
            $extension = $request->file('image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image file to the destination folder
            $path = $request->file('image')->storeAs('public/images/treatments', $fileNameToStore);  // Save file
        }

        $physical_activity = PhysicalActivity::find($id);
        $physical_activity->name = $request->input('name');
        $physical_activity->description = $request->input('description');

        // If a new image has been uploaded...
        if( $request->hasFile('image') ) {
            // Delete the previous image stored
            if($physical_activity->image != 'image-solid.svg'){   // We only delete the previous image stored if it was not the default image, since that is shared by other records
                // Delete image file
                Storage::delete('public/images/treatments/'.$physical_activity->image);        //  storage/app/public/images/
            }
            // Next, we update the value of the image field of the table.
            $physical_activity->image = $fileNameToStore;
        }

        // If the user has not uploaded a new image file, the $___->image field is left as is
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
