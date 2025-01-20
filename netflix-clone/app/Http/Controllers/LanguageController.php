<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Language;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends DataController
{
    function index(): Response
    {
        $language = Language::all();

        return ApiResponseHelper::formatResponse($language, 200);
    }

    function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $language = Language::create([
            'name' => $validatedData['name'],
        ]);

        return ApiResponseHelper::formatResponse([
            'message' => 'Language created successfully',
            'data' => [
                'id' => $language->id,
                'name' => $language->name,
            ],
        ], 201);
    }

    function show($id): Response
    {
        $language = Language::find($id);

        if (!$language) {
            return ApiResponseHelper::formatResponse([
                'error' => 'Language not found'
            ], 404);
        }

        $languageData = [
            'id' => $language->id,
            'name' => $language->name,
        ];

        return ApiResponseHelper::formatResponse($languageData, 200);
    }

    function update(Request $request, $id): Response
    {
        $language = Language::find($id);

        if (!$language) {
            return ApiResponseHelper::formatResponse(['error' => 'Language not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (isset($validatedData['name'])) {
            $language->name = $validatedData['name'];
        }

        $language->save();

        return ApiResponseHelper::formatResponse([
            'message' => 'Language updated successfully',
            'data' => [
                'id' => $language->id,
                'name' => $language->name
            ],
        ], 200);
    }

    function destroy($id): Response
    {
        $language = Language::find($id);

        if (!$language) {
            return ApiResponseHelper::formatResponse(['error' => 'Language not found'], 404);
        }

        $language->delete();

        return ApiResponseHelper::formatResponse([
            'message' => 'Language deleted successfully',
        ], 200);
    }
}
