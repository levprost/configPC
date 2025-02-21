<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configurations = Configuration::all()->with(['user']);
        return response()->json([$configurations,'user']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_config' => 'required|string',
            'title_config' => 'required|string',
            'subtitle_config' => 'required|string',
            'description_config' => 'required',
            'explication_config' => 'required',
            'image_config' => 'required|string',
            'benchmark_config' => 'required|string',
            'user_id' => 'required|integer',
        ]);
        Configuration::create($request->all());
        return response()->json([
            'status' => 'Création effectuée avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Configuration $configuration)
    {
        return response()->json([$configuration,'user']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Configuration $configuration)
    {
        $formFields = $request->validate([
            'name_config' => 'sometimes|string',
            'title_config' => 'sometimes|string',
            'subtitle_config' => 'sometimes|string',
            'description_config' => 'sometimes',
            'explication_config' => 'sometimes',
            'image_config' => 'sometimes|string',
            'benchmark_config' => 'sometimes|string',
            'user_id' => 'sometimes|integer',
        ]);
        $configuration->update($formFields);
        return response()->json([$configuration,'status' => 'Mise à jour effectuée avec succès']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Configuration $configuration)
    {
        $configuration->delete();
        return response()->json([
            'status' => 'Suppression effectuée avec succès'
        ]);
    }
}
