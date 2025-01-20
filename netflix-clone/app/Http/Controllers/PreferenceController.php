<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Preference;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreferenceController extends DataController
{
    function index(): Response
    {
        $preferences = Preference::all();

        return ApiResponseHelper::formatResponse($preferences, 200);
    }

    function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $preference = Preference::create([
            'name' => $validatedData['name'],
        ]);

        return ApiResponseHelper::formatResponse([
            'message' => 'Preference created successfully',
            'data' => [
                'id' => $preference->id,
                'name' => $preference->name,
            ],
        ], 201);
    }

    function show($id): Response
    {
        $preference = Preference::find($id);

        if (!$preference) {
            return ApiResponseHelper::formatResponse([
                'error' => 'Preference not found'
            ], 404);
        }

        $preferenceData = [
            'id' => $preference->id,
            'name' => $preference->name,
        ];

        return ApiResponseHelper::formatResponse($preferenceData, 200);
    }

    function update(Request $request, $id): Response
    {
        $preference = Preference::find($id);

        if (!$preference) {
            return ApiResponseHelper::formatResponse(['error' => 'Preference not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (isset($validatedData['name'])) {
            $preference->name = $validatedData['name'];
        }

        $preference->save();

        return ApiResponseHelper::formatResponse([
            'message' => 'Preference updated successfully',
            'data' => [
                'id' => $preference->id,
                'name' => $preference->name
            ],
        ], 200);
    }

    function destroy($id): Response
    {
        $preference = Preference::find($id);

        if (!$preference) {
            return ApiResponseHelper::formatResponse(['error' => 'Preference not found'], 404);
        }

        $preference->delete();

        return ApiResponseHelper::formatResponse([
            'message' => 'Preference deleted successfully',
        ], 200);
    }
}
