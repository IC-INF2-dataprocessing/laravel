<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Content;
use App\Models\Series;
use App\Models\Subtitle;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends Controller
{
    public function getContent($contentId): Response
    {
        $content = Content::find($contentId);

        if (!$content) {
            return ApiResponseHelper::formatResponse(['Error' => 'Content not found'], 404);
        }

        return ApiResponseHelper::formatResponse($content, 200);
    }

    public function getMovie($contentId): Response
    {
        $movie = Content::whereNull('series_id')->find($contentId);

        if (!$movie) {
            return ApiResponseHelper::formatResponse(['Error' => 'Movie not found'], 404);
        }

        return ApiResponseHelper::formatResponse($movie, 200);
    }

    public function getSerie($seriesId): Response
    {
        $series = Series::with('episodes.content')->find($seriesId);

        if (!$series) {
            return ApiResponseHelper::formatResponse(['Error' => 'Series not found'], 404);
        }

        return ApiResponseHelper::formatResponse($series, 200);
    }

    public function getSubtitles($contentId): Response
    {
        $subtitles = Subtitle::where('content_id', $contentId)->with('language')->get();

        if ($subtitles->isEmpty()) {
            return ApiResponseHelper::formatResponse(['Error' => 'No subtitles found'], 404);
        }

        return ApiResponseHelper::formatResponse($subtitles, 200);
    }
}
