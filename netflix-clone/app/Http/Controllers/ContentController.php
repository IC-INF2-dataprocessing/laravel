<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Content;
use App\Models\Series;
use App\Models\Genre;
use App\Models\Subtitle;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends Controller
{
    public function getContent($contentId): Response
    {
        $content = Content::with(['genres', 'subtitles'])->find($contentId);

        if (!$content) {
            return ApiResponseHelper::formatResponse(['Error' => 'Content not found'], 404);
        }

        return ApiResponseHelper::formatResponse($content, 200);
    }

    public function getMovie($contentId): Response
    {
        $movie = Content::doesntHave('series')->with(['genres', 'subtitles'])->find($contentId);

        if (!$movie) {
            return ApiResponseHelper::formatResponse(['Error' => 'Movie not found'], 404);
        }

        return ApiResponseHelper::formatResponse($movie, 200);
    }

    public function getSerie($seriesId): Response
    {
        $series = Series::with(['episodes.content', 'genres'])->find($seriesId);

        if (!$series) {
            return ApiResponseHelper::formatResponse(['Error' => 'Series not found'], 404);
        }

        return ApiResponseHelper::formatResponse($series, 200);
    }

    public function getContentByGenre($genreId): Response
    {
        $contents = Content::whereHas('genres', function ($query) use ($genreId) {
            $query->where('id', $genreId);
        })->with(['genres', 'subtitles'])->get();

        if ($contents->isEmpty()) {
            return ApiResponseHelper::formatResponse(['Error' => 'No content found for this genre'], 404);
        }

        return ApiResponseHelper::formatResponse($contents, 200);
    }

    public function getSubtitles($contentId): Response
    {
        $subtitles = Subtitle::where('content_id', $contentId)->with('language')->get();

        if ($subtitles->isEmpty()) {
            return ApiResponseHelper::formatResponse(['Error' => 'No subtitles found'], 404);
        }

        return ApiResponseHelper::formatResponse($subtitles, 200);
    }

    public function addContentProgress($contentId, $profileId, $progress, $watchCount): Response
    {
        $contentProgress = ContentProgress::updateOrCreate(
            [
                'content_id' => $contentId,
                'profile_id' => $profileId,
            ],
            [
                'progress' => $progress,
                'watch_count' => $watchCount,
            ]
        );

        return ApiResponseHelper::formatResponse($contentProgress, 200);
    }

    public function addToWatchList($profileId, $contentId = null, $seriesId = null): Response
    {
        $watchListItem = WatchList::create([
            'profile_id' => $profileId,
            'content_id' => $contentId,
            'series_id' => $seriesId,
        ]);

        return ApiResponseHelper::formatResponse($watchListItem, 201);
    }
}
