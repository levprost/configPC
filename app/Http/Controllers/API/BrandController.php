<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_brand' => 'required|string',
            'logo_brand' => 'required|string',
            'description_brand' => 'required',
            'color_brand' => 'required|string',
        ]);
        Brand::create($request->all());
        return response()->json([
            'status' => 'Création effectuée avec succès'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return response()->json($brand);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $formFields = $request->validate([
            'name_brand' => 'sometimes|string',
            'logo_brand' => 'sometimes|string',
            'description_brand' => 'sometimes',
            'color_brand' => 'sometimes|string',
        ]);
        $brand->update($formFields);
        return response()->json([$brand,'status' => 'Mise à jour effectuée avec succès']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json([
            'status' => 'Suppression effectuée avec succès'
        ]);
    }
}
