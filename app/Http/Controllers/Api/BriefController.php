<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brief;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BriefController extends Controller
{
    /**
     * Get all briefs for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        
        $briefs = Brief::with(['package', 'creator'])
            ->when($user->role === 'client', function ($query) use ($user) {
                return $query->where('created_by', $user->id);
            })
            ->latest()
            ->get();

        return response()->json($briefs);
    }

    /**
     * Store a new creative brief
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand_style' => 'nullable|array',
            'colors' => 'nullable|array',
            'package_id' => 'required|exists:packages,id',
        ]);

        $brief = Brief::create([
            ...$validated,
            'created_by' => Auth::id(),
            'status' => 'pending',
        ]);

        $brief->load(['package', 'creator']);

        return response()->json([
            'message' => 'Brief created successfully',
            'brief' => $brief
        ], 201);
    }

    /**
     * Get a specific brief
     */
    public function show(Brief $brief)
    {
        $this->authorize('view', $brief);

        $brief->load(['package', 'creator', 'items', 'statusHistory']);

        return response()->json($brief);
    }

    /**
     * Update a brief
     */
    public function update(Request $request, Brief $brief)
    {
        $this->authorize('update', $brief);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'brand_style' => 'nullable|array',
            'colors' => 'nullable|array',
            'package_id' => 'sometimes|exists:packages,id',
            'status' => 'sometimes|string|in:pending,in_progress,review,completed,cancelled',
        ]);

        $brief->update($validated);

        return response()->json([
            'message' => 'Brief updated successfully',
            'brief' => $brief->load(['package', 'creator'])
        ]);
    }

    /**
     * Delete a brief
     */
    public function destroy(Brief $brief)
    {
        $this->authorize('delete', $brief);

        $brief->delete();

        return response()->json([
            'message' => 'Brief deleted successfully'
        ]);
    }
}

