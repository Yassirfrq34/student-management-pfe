<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Get My Profile
    public function me(Request $request)
    {
        $user = $request->user();
        // Load the student data associated with this user
        $student = $user->student;

        return response()->json([
            'status' => true,
            'user' => $user,
            'student_details' => $student
        ]);
    }

    // Update My Profile
    public function update(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        if (!$student) {
            return response()->json(['status' => false, 'message' => 'Student profile not found'], 404);
        }

        // Validate allowed fields
        $request->validate([
            'phone' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        // Update only safe fields
        $student->update([
            'phone' => $request->phone ?? $student->phone,
            'city' => $request->city ?? $student->city,
        ]);

        return response()->json(['status' => true, 'message' => 'Profile Updated', 'data' => $student]);
    }
}
