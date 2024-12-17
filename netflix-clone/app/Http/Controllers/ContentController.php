<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getContent($contentId): JsonResponse
    {
        $content = Content::find($contentId);

        if (!$content) {
            return response()->json(['Error' => 'Content not found'], 404);
        }

        return response()->json([$content, 200]);
    }

    public function getMovie($contentId): JsonResponse
    {
        $movie = Content::doesntHave('series')->find($contentId);

        if (!$movie) {
            return response()->json(['Error' => 'Content not found'], 404);
        }

        return response()->json([$movie, 200]);
    }

    public function getSerie($contentId): JsonResponse
    {
        $series = Content::has('series')->find($contentId);

        if ($series->isEmpty()) {
            return response()->json(['Error' => 'No series found'], 404);
        }

        return response()->json([$series, 200]);
    }

}
