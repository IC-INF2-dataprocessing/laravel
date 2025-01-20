<?php

namespace App\Http\ExternalControllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;


class ProfilePictureController extends Controller
{
    public function random(): Response
    {
        $seed = random_int(1,999);

        $response = Http::get("https://api.dicebear.com/9.x/avataaars-neutral/svg?seed={$seed}");

        if ($response->successful()) {
            return ApiResponseHelper::formatResponse([
                'seed' => $seed,
                'svg' => $response->body(),
            ], 200);
        } else {
            return ApiResponseHelper::formatResponse([
                'error' => 'Failed to fetch avatar',
            ], 500);
        }
    }

    public function show($id): Response
    {
        $response = Http::get('https://api.dicebear.com/9.x/avataaars-neutral/svg?seed=' . $id);
        if ($response->successful()) {
            return ApiResponseHelper::formatResponse(['svg' => $response->body()], 200);
        } else {
            // Handle the error if the request fails
            return ApiResponseHelper::formatResponse('Failed to fetch avatar', 500);
        }
    }
}
