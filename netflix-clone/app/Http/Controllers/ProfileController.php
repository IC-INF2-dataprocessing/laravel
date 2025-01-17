<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends DataController
{

    public function store(Request $request) : Response
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'profile_picture' => 'nullable|integer|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponseHelper::formatResponse($validator->errors(), 422);
        }

        $profile = Profile::create([
            'name' => $request['name'],
            'profile_picture' => $request['profile_picture'] ?? null,
            'date_of_birth' => $request['date_of_birth'] ?? null,
            'user_id' => $request['user_id'],
        ]);

        return ApiResponseHelper::formatResponse($profile, 201);
    }


    public function show($id) : Response
    {
        $profile = Profile::find($id);

        if (!$profile) {
            return ApiResponseHelper::formatResponse(['Error' => 'Profile not found'], 404);
        }

        return ApiResponseHelper::formatResponse($profile, 200);
    }

    public function update(Request $request, $id) : Response {
        $profile = Profile::find($id);

        if (!$profile) {
            return ApiResponseHelper::formatResponse(['error' => 'Profile not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'date_of_birth' => 'sometimes|date',
            'profile_picture' => 'sometimes|nullable|integer',
        ]);

        if(isset($validatedData['name'])) {
            $profile->name = $validatedData['name'];
        }
        if (isset($validatedData['date_of_birth'])) {
            $profile->date_of_birth = $validatedData['date_of_birth'];
        }
        if (isset($validatedData['profile_picture'])) {
            $profile->profile_picture = $validatedData['profile_picture'];
        }

        $profile->save();

        return ApiResponseHelper::formatResponse([
            'message' => 'User updated successfully',
            'user' => $profile,
        ], 200);
    }

    public function destroy($id) : Response
    {
        $profile = Profile::find($id);

        if (!$profile) {
            return ApiResponseHelper::formatResponse(['error' => 'Profile not found'], 404);
        }

        $profile->delete();

        return ApiResponseHelper::formatResponse(['Profile deleted successfully.'], 200);
    }

    function index()
    {
        $profiles = Profile::all();

        return ApiResponseHelper::formatResponse($profiles, 200);
    }
}
