<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function index()
    {
        // Fetch students grouped by year
        $students = User::where('role', 'student')->get()->groupBy(function ($student) {
            $yearOfBirth = $student->dob ? date('Y', strtotime($student->dob)) : null;
            return 2011 - $yearOfBirth; // Calculate the year (e.g., Year 1, Year 2)
        });

        return view('students.index', compact('students'));
    }

    public function assign(Request $request)
    {
        // Validate input
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'class' => 'required|in:Pendeta,Cendekiawan,Intelek,Sarjana',
            'year' => 'required|integer|min:1|max:5',
        ]);

        // Update student class
        $student = User::find($request->student_id);
        $student->class = $request->year . $request->class; // E.g., "1Pendeta"
        $student->save();

        return redirect()->route('students.index')->with('success', 'Student assigned to class successfully!');
    }
}
