<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function show($id): Response
    {
        $user = User::find($id);

        if (!$user) {
            return ApiResponseHelper::formatResponse(['error' => 'User not found'], 404);
        }

        $userData = [
            [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ];

        return ApiResponseHelper::formatResponse($userData, 200);
    }

    public function update(Request $request, $id): Response {
        $user = User::find($id);

        if (!$user) {
            return ApiResponseHelper::formatResponse(['error' => 'User not found'], 404);
        }

        // Validate the request input
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
        ]);

        // Update the user's attributes
        if (isset($validatedData['name'])) {
            $user->name = $validatedData['name'];
        }
        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }
        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']->password);
        }

        $user->save();

        // Return a success response
        return ApiResponseHelper::formatResponse([
            'message' => 'User updated successfully',
            'user' => $user,
        ], 200);
    }

    public function destroy($userId): Response {
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return ApiResponseHelper::formatResponse(['error' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        // Return a success response
        return ApiResponseHelper::formatResponse([
            'message' => 'User deleted successfully',
        ], 200);
    }

    public function getProfiles($userId): Response {
        $profileIds = Profile::where('user_id', $userId)->pluck('id')->toArray();

        if (!$profileIds) {
            return ApiResponseHelper::formatResponse(['error' => 'No profiles found'], 404);
        }

        return ApiResponseHelper::formatResponse($profileIds, 200);
    }
}
