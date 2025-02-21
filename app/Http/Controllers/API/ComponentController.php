<?php

namespace App\Http\Controllers\API;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Component;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $components = Component::all()->with(['category', 'brand']);
        return response()->json([
            'components' => $components,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_component' => 'required|string',
            'subtitle_component' => 'required|string',
            'price_component' => 'required|numeric',
            'description_component' => 'required',
            'consumption_component' => 'required|integer',
            'review_component' => 'required',
            'image_component' => 'required|string',
            'video_component' => 'required|string',
            'release_date_component' => 'required|date',
            'type_component' => 'required|string',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
        ]);
        Component::create($request->all());
        return response()->json([
            'status' => 'Création effectuée avec succès'
        ]);
        // Schema::create('components', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name_component');
        //     $table->string('subtitle_component')->nullable();
        //     $table->decimal('price_component');
        //     $table->text('description_component');
        //     $table->integer('consumption_component');
        //     $table->text('review_component');
        //     $table->string('image_component')->nullable();
        //     $table->string('video_component')->nullable();
        //     $table->date('release_date_component');
        //     $table->string('type_component')->nullable();
        //     $table->foreignId('category_id')->constrained();
        //     $table->foreignId('brand_id')->constrained();
        //     $table->timestamps();
        // });
    }

    /**
     * Display the specified resource.
     */
    public function show(Component $component)
    {
        $component->load(['brand', 'category']);

        return response()->json([
            'component' => $component
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Component $component)
    {
        $formFields = $request->validate([
            'name_component' => 'sometimes|string',
            'subtitle_component' => 'sometimes|string',
            'price_component' => 'sometimes|numeric',
            'description_component' => 'sometimes',
            'consumption_component' => 'sometimes|integer',
            'review_component' => 'sometimes',
            'image_component' => 'sometimes|string',
            'video_component' => 'sometimes|string',
            'release_date_component' => 'sometimes|date',
            'type_component' => 'sometimes|string',
            'category_id' => 'sometimes|integer',
            'brand_id' => 'sometimes|integer',
        ]);
        $component->update($formFields);
        return response()->json([$component,'status' => 'Mise à jour effectuée avec succès']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Component $component)
    {
        $component->delete();
        return response()->json([
            'status' => 'Suppression effectuée avec succès'
        ]);
    }
}
