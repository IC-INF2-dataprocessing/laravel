<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Content;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends Controller
{
    public function getContent($contentId): Response
    {
        $content = Content::find($contentId);

        if (!$content) {
            return ApiResponseHelper::formatResponse(['Error' => 'Content not found'], 404);
        }

        return ApiResponseHelper::formatResponse([$content, 200]);
    }

    public function getMovie($contentId): Response
    {
        $movie = Content::doesntHave('series')->find($contentId);

        if (!$movie) {
            return ApiResponseHelper::formatResponse(['Error' => 'Content not found'], 404);
        }

        return ApiResponseHelper::formatResponse([$movie, 200]);
    }

    public function getSerie($contentId): Response
    {
        $series = Content::has('series')->find($contentId);

        if ($series->isEmpty()) {
            return ApiResponseHelper::formatResponse(['Error' => 'No series found'], 404);
        }

        return ApiResponseHelper::formatResponse([$series, 200]);
    }

}
