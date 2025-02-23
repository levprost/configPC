<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $media = Media::all();
        return response()->json($media);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'media_file' => 'required|string',
            'media_type' => 'required|string',
            'post_id' => 'required|integer',
        ]);
        $filename = "";
        if ($request->hasFile('media_file')) {
            $filenameWithExt = $request->file('media_file')->getClientOriginalName();
            $filenameWithExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('media_file')->getClientOriginalExtension();
            $filename = $filenameWithExt . '_' . time() . '.' . $extension;
            $request->file('media_file')->storeAs('uploads', $filename);
        } else {
            $filename = Null;
        }
        Media::create($formFields);
        return response()->json([
            'status' => 'Création effectuée avec succès'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        return response()->json($media);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        $formFields = $request->validate([
            'media_file' => 'required|string',
            'media_type' => 'required|string',
            'post_id' => 'required|integer',
        ]);
        $filename = "";
        if ($request->hasFile('media_file')) {
            $filenameWithExt = $request->file('media_file')->getClientOriginalName();
            $filenameWithExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('media_file')->getClientOriginalExtension();
            $filename = $filenameWithExt . '_' . time() . '.' . $extension;
            $request->file('media_file')->storeAs('uploads', $filename);
        } else {
            $filename = Null;
        }
        $formFields['media_file'] = $filename;
        $media->update($formFields);
        return response()->json([
            'status' => 'Mise à jour effectuée avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        $media->delete();
        return response()->json([
            'status' => 'Suppression effectuée avec succès'
        ]);
    }
}
