<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the currently authenticated user

        // Role Check for Junior Access
        if (!$user->hasRole('Junior')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return response()->json(['message' => 'Welcome, Junior User!']);
    }
}
