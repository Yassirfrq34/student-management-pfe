<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // GET: Everyone can see the list
    public function index(Request $request)
    {
        $students = Student::with('user')->get();
        return response()->json(['status' => true, 'data' => $students]);
    }

    // POST: Create Student (ADMIN ONLY)
    public function store(Request $request)
    {
        // 👇 SECURITY CHECK
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé. Administrateurs seulement.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student'
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'city' => $request->city,
            'level' => $request->level,
        ]);

        return response()->json(['status' => true, 'message' => 'Étudiant créé avec succès', 'data' => $student], 201);
    }

    // GET: View One (Everyone)
    public function show($id)
    {
        $student = Student::with('user')->find($id);
        return $student
            ? response()->json(['status' => true, 'data' => $student])
            : response()->json(['status' => false, 'message' => 'Étudiant non trouvé'], 404);
    }

    // PUT: Update Student (ADMIN ONLY)
    public function update(Request $request, $id)
    {
        // 👇 SECURITY CHECK
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $student = Student::find($id);
        if (!$student) return response()->json(['status' => false, 'message' => 'Étudiant non trouvé'], 404);

        $student->update($request->only(['first_name', 'last_name', 'phone', 'city', 'level']));

        // Optional: Update email/name in User table if needed
        if ($request->has('email')) {
            $student->user->update(['email' => $request->email]);
        }

        return response()->json(['status' => true, 'message' => 'Mis à jour avec succès', 'data' => $student]);
    }

    // DELETE: Delete Student (ADMIN ONLY)
    public function destroy(Request $request, $id)
    {
        // 👇 SECURITY CHECK
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $student = Student::find($id);
        if (!$student) return response()->json(['status' => false, 'message' => 'Étudiant non trouvé'], 404);

        $student->user->delete();
        return response()->json(['status' => true, 'message' => 'Supprimé avec succès']);
    }
}
