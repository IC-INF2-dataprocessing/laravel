<?php


namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Profile;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends DataController
{

    public function index(): Response
    {
        $users = User::with('role')->get();

        $userData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ? $user->role->name : null,
            ];
        });

        return ApiResponseHelper::formatResponse($userData, 200);
    }

    public function show($id): Response
    {
        $user = User::with('role')->find($id);

        if (!$user) {
            return ApiResponseHelper::formatResponse(['error' => 'User not found'], 404);
        }

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ? $user->role->name : null,
        ];

        return ApiResponseHelper::formatResponse($userData, 200);
    }

    public function update(Request $request, $id): Response
    {
        $user = User::find($id);

        if (!$user) {
            return ApiResponseHelper::formatResponse(['error' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
            'role_id' => 'sometimes|exists:roles,id',
        ]);

        if (isset($validatedData['name'])) {
            $user->name = $validatedData['name'];
        }
        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }
        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        if (isset($validatedData['role_id'])) {
            $user->role_id = $validatedData['role_id'];
        }

        $user->save();

        return ApiResponseHelper::formatResponse([
            'message' => 'User updated successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ? $user->role->name : null,
            ],
        ], 200);
    }

    public function destroy($userId): Response
    {
        $user = User::find($userId);

        if (!$user) {
            return ApiResponseHelper::formatResponse(['error' => 'User not found'], 404);
        }

        $user->delete();

        return ApiResponseHelper::formatResponse([
            'message' => 'User deleted successfully',
        ], 200);
    }

    public function getProfiles($userId): Response
    {
        $profileIds = Profile::where('user_id', $userId)->pluck('id')->toArray();

        if (!$profileIds) {
            return ApiResponseHelper::formatResponse(['error' => 'No profiles found'], 404);
        }

        return ApiResponseHelper::formatResponse($profileIds, 200);
    }

    public function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'sometimes|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => $validatedData['role_id'] ?? null,
        ]);

        return ApiResponseHelper::formatResponse([
            'message' => 'User created successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ? $user->role->name : null,
            ],
        ], 201);
    }
}

