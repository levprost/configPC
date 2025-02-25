<?php

namespace App\Http\Controllers\API;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
            'media_file.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,wmv',
            'media_type' => 'required|string',
            'post_id' => 'required|integer',
        ]);

        if ($request->hasFile('media_file')) {
            foreach ($request->file('media_file') as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                $filenameWithExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = $filenameWithExt . '_' . time() . '.' . $extension;
                $file->storeAs('uploads', $filename);

                Media::create([
                    'media_file' => $filename,
                    'media_type' => $formFields['media_type'],
                    'post_id' => $formFields['post_id'],
                ]);
            }
        }

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

    public function update(Request $request)
    {
        // Validation des données entrantes
        $formFields = $request->validate([
            'media_file.*' => 'sometimes|file|image|mimes:jpeg,png,jpg,gif,svg', // Les fichiers doivent être des images valides
            'media_type'   => 'required|string', // Type de média obligatoire
            'post_id'      => 'required|integer|exists:posts,id', // Vérifie que post_id existe dans la table posts
        ]);

        // Récupération des médias existants pour ce post
        $oldMedia = Media::where('post_id', $formFields['post_id'])->get();

        if ($request->hasFile('media_file')) {
            // Si de nouveaux fichiers sont fournis, nous devons supprimer les anciens fichiers
            foreach ($oldMedia as $media) {
                if ($media->media_file && Storage::exists('uploads/' . $media->media_file)) {
                    Storage::delete('uploads/' . $media->media_file); // Supprime le fichier de stockage
                }
                $media->delete(); // Supprime l'entrée de la base de données
            }

            // Parcourir chaque fichier téléchargé
            foreach ($request->file('media_file') as $file) {
                // Générer un nom unique pour chaque fichier
                $filenameBase = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = $filenameBase . '_' . time() . '.' . $extension;

                // Stocker le fichier dans le dossier 'uploads'
                $file->storeAs('uploads', $filename);

                // Créer une nouvelle entrée dans la base de données
                Media::create([
                    'media_file' => $filename,
                    'media_type' => $formFields['media_type'],
                    'post_id'    => $formFields['post_id'],
                ]);
            }
        } else {
            // Si aucun fichier n'est fourni, on met seulement à jour le type de média
            foreach ($oldMedia as $media) {
                $media->update([
                    'media_type' => $formFields['media_type'] // Mise à jour du type de média
                ]);
            }
        }

        return response()->json([
            'status' => 'Mise à jour effectuée avec succès' // Retourne un message de succès
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        if ($media->media_file && Storage::exists('uploads/' . $media->media_file)) {
            Storage::delete('uploads/' . $media->media_file);
        }
        $media->delete();
        return response()->json('Media supprimé');
    }

}
