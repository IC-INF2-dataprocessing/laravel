<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the currently authenticated user

        // Role Check
        if (!$user->hasRole('Senior')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return response()->json(['message' => 'Welcome, Senior Admin!']);
    }
}
