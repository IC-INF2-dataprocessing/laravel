<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Subtitle;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubtitleController extends DataController
{
    function index(): Response
    {
        $subtitle = Subtitle::all();

        return ApiResponseHelper::formatResponse($subtitle, 200);
    }

    function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'content_id' => 'required|exists:contents,id',
            'language_id' => 'required|exists:languages,id',
            'subtitle_path' => 'required|string|max:255',
        ]);

        $subtitle = Subtitle::create([
            'content_id' => $validatedData['content_id'],
            'language_id' => $validatedData['language_id'],
            'subtitle_path' => $validatedData['subtitle_path'],
        ]);

        return ApiResponseHelper::formatResponse([
            'message' => 'Subtitle created successfully',
            'data' => [
                'id' => $subtitle->id,
                'content_id' => $subtitle->content_id,
                'language_id' => $subtitle->language_id,
                'subtitle_path' => $subtitle->subtitle_path,
            ]
        ]);
    }

    function show($id): Response
    {
        $subtitle = Subtitle::find($id);

        if (!$subtitle) {
            return ApiResponseHelper::formatResponse([
                'error' => 'Subtitle not found'
            ], 404);
        }

        $subtitleData = [
            'id' => $subtitle->id,
            'name' => $subtitle->name,
        ];

        return ApiResponseHelper::formatResponse($subtitleData, 200);
    }

    function update(Request $request, $id): Response
    {
        $subtitle = Subtitle::find($id);

        if (!$subtitle) {
            return ApiResponseHelper::formatResponse(['error' => 'Subtitle not found'], 404);
        }

        $validatedData = $request->validate([
            'content_id' => 'required|exists:contents,id',
            'language_id' => 'required|exists:languages,id',
            'subtitle_path' => 'required|string|max:255',
        ]);

        $subtitle->content_id = $validatedData['content_id'];
        $subtitle->language_id = $validatedData['language_id'];
        $subtitle->subtitle_path = $validatedData['subtitle_path'];

        $subtitle->save();

        return ApiResponseHelper::formatResponse([
            'message' => 'Subtitle created successfully',
            'data' => [
                'id' => $subtitle->id,
                'content_id' => $subtitle->content_id,
                'language_id' => $subtitle->language_id,
                'subtitle_path' => $subtitle->subtitle_path,
            ]
        ]);
    }

    function destroy($id): Response
    {
        $subtitle = Subtitle::find($id);

        if (!$subtitle) {
            return ApiResponseHelper::formatResponse(['error' => 'Subtitle not found'], 404);
        }

        $subtitle->delete();

        return ApiResponseHelper::formatResponse([
            'message' => 'Subtitle deleted successfully',
        ], 200);
    }
}
