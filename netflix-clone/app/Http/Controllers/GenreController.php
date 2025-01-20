<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Genre;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends DataController
{
    function index(): Response
    {
        $genre = Genre::all();

        return ApiResponseHelper::formatResponse($genre, 200);
    }

    function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre = Genre::create([
            'name' => $validatedData['name'],
        ]);

        return ApiResponseHelper::formatResponse([
            'message' => 'Genre created successfully',
            'data' => [
                'id' => $genre->id,
                'name' => $genre->name,
            ],
        ], 201);
    }

    function show($id): Response
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return ApiResponseHelper::formatResponse([
                'error' => 'Genre not found'
            ], 404);
        }

        $genreData = [
            'id' => $genre->id,
            'name' => $genre->name,
        ];

        return ApiResponseHelper::formatResponse($genreData, 200);
    }

    function update(Request $request, $id): Response
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return ApiResponseHelper::formatResponse(['error' => 'Genre not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (isset($validatedData['name'])) {
            $genre->name = $validatedData['name'];
        }

        $genre->save();

        return ApiResponseHelper::formatResponse([
            'message' => 'Genre updated successfully',
            'data' => [
                'id' => $genre->id,
                'name' => $genre->name
            ],
        ], 200);
    }

    function destroy($id): Response
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return ApiResponseHelper::formatResponse(['error' => 'Genre not found'], 404);
        }

        $genre->delete();

        return ApiResponseHelper::formatResponse([
            'message' => 'Genre deleted successfully',
        ], 200);
    }
}
