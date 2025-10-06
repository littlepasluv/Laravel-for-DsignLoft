<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Save or update user profile
     */
    public function save(Request $request): JsonResponse
    {
        $request->validate([
            'firebase_uid' => 'required|string',
            'user_data' => 'required|array'
        ]);

        try {
            $profile = UserProfile::updateOrCreate(
                ['firebase_uid' => $request->firebase_uid],
                [
                    'user_data' => $request->user_data,
                    'profile_photo_url' => $request->profile_photo_url ?? null
                ]
            );

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user profile by firebase_uid
     */
    public function get(Request $request): JsonResponse
    {
        $request->validate([
            'firebase_uid' => 'required|string'
        ]);

        try {
            $profile = UserProfile::where('firebase_uid', $request->firebase_uid)->first();

            if (!$profile) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User profile not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'user_data' => $profile->user_data,
                'profile_photo_url' => $profile->profile_photo_url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'firebase_uid' => 'required|string'
        ]);

        try {
            $profile = UserProfile::where('firebase_uid', $request->firebase_uid)->first();

            return response()->json([
                'status' => 'success',
                'profile_photo_url' => $profile ? $profile->profile_photo_url : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }
}
