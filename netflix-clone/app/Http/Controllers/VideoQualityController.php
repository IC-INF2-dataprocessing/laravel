<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\VideoQuality;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoQualityController extends DataController
{
    function index(): Response
    {
        $videoQuality = VideoQuality::all();

        return ApiResponseHelper::formatResponse($videoQuality, 200);
    }

    function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $videoQuality = VideoQuality::create([
            'name' => $validatedData['name'],
        ]);

        return ApiResponseHelper::formatResponse([
            'message' => 'Video quality created successfully',
            'data' => [
                'id' => $videoQuality->id,
                'name' => $videoQuality->name,
            ],
        ], 201);
    }

    function show($id): Response
    {
        $videoQuality = VideoQuality::find($id);

        if (!$videoQuality) {
            return ApiResponseHelper::formatResponse([
                'error' => 'Video quality not found'
            ], 404);
        }

        $videoQualityData = [
            'id' => $videoQuality->id,
            'name' => $videoQuality->name,
        ];

        return ApiResponseHelper::formatResponse($videoQualityData, 200);
    }

    function update(Request $request, $id): Response
    {
        $videoQuality = VideoQuality::find($id);

        if (!$videoQuality) {
            return ApiResponseHelper::formatResponse(['error' => 'Video quality not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (isset($validatedData['name'])) {
            $videoQuality->name = $validatedData['name'];
        }

        $videoQuality->save();

        return ApiResponseHelper::formatResponse([
            'message' => 'Video quality updated successfully',
            'data' => [
                'id' => $videoQuality->id,
                'name' => $videoQuality->name
            ],
        ], 200);
    }

    function destroy($id): Response
    {
        $videoQuality = VideoQuality::find($id);

        if (!$videoQuality) {
            return ApiResponseHelper::formatResponse(['error' => 'Video quality not found'], 404);
        }

        $videoQuality->delete();

        return ApiResponseHelper::formatResponse([
            'message' => 'Video quality deleted successfully',
        ], 200);
    }
}
