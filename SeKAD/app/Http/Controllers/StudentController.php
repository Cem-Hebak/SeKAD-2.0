<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function showAssignForm()
    {
        // Fetch students and group by year of birth
        $students = User::where('role', 'student')->get()->groupBy(function ($student) {
            $yearOfBirth = $student->dob ? date('Y', strtotime($student->dob)) : null;
            return $yearOfBirth ? 2011 - $yearOfBirth : 'Unknown'; // Adjust year calculation
        });

        return view('assign-student', compact('students'));
    }

    public function assignStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:1|max:5',
            'class' => 'required|in:Pendeta,Cendekiawan,Intelek,Sarjana',
        ]);

        $student = User::find($request->student_id);
        $student->class = $request->year . $request->class; // Example: "1Pendeta"
        $student->save();

        return redirect()->route('assign-student')->with('success', 'Student assigned to class successfully!');
    }
}
?>