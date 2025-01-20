<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends DataController
{
    function index(): Response
    {
        $subscription = Subscription::all();

        return ApiResponseHelper::formatResponse($subscription, 200);
    }

    function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'price' => 'nullable|numeric',
        ]);

        $validatedData['price'] = $validatedData['price'] ?? 7.99;

        $subscription = Subscription::create([
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
        ]);

        return ApiResponseHelper::formatResponse([
            'message' => 'Subscription created successfully',
            'data' => [
                'id' => $subscription->id,
                'description' => $subscription->description,
                'price' => $subscription->price,
            ]
        ], 201);
    }

    function show($id): Response
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return ApiResponseHelper::formatResponse([
                'error' => 'Subscription not found'
            ], 404);
        }

        $subscriptionData = [
            'id' => $subscription->id,
            'description' => $subscription->description,
            'price' => $subscription->price,
        ];

        return ApiResponseHelper::formatResponse($subscriptionData, 200);
    }

    function update(Request $request, $id): Response
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return ApiResponseHelper::formatResponse(['error' => 'Subscription not found'], 404);
        }

        $validatedData = $request->validate([
            'description' => 'sometimes|string|max:255',
            'price' => 'nullable|numeric',
        ]);

        if(isset($validatedData['description'])) {
            $subscription->description = $validatedData['description'];
        }
        $subscription->price = $validatedData['price'] ?? 7.99;

        $subscription->save();

        return ApiResponseHelper::formatResponse([
            'message' => 'Subscription created successfully',
            'data' => [
                'id' => $subscription->id,
                'description' => $subscription->description,
                'price' => $subscription->price,
            ]
        ]);
    }

    function destroy($id): Response
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return ApiResponseHelper::formatResponse(['error' => 'Subscription not found'], 404);
        }

        $subscription->delete();

        return ApiResponseHelper::formatResponse([
            'message' => 'Subscription deleted successfully',
        ], 200);
    }
}
