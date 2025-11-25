<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // GET: List all subjects
    public function index()
    {
        // Retrieve all subjects from database
        $subjects = Subject::all();
        return response()->json(['data' => $subjects]);
    }

    // POST: Add a subject (Admin only)
    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:subjects'
        ]);

        $subject = Subject::create($request->all());
        return response()->json(['message' => 'Matière créée', 'data' => $subject], 201);
    }

    // DELETE: Remove a subject (Admin only)
    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        Subject::destroy($id);
        return response()->json(['message' => 'Supprimée']);
    }
}
