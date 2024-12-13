<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the currently authenticated user

        // Permission Check
        if (!$user->hasPermission('view_financial')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return response()->json(['message' => 'Welcome to Finance Dashboard!']);
    }
}
