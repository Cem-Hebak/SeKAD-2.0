<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function getLowAttendance()
    {
        $month = now()->month; // Current month
        $lowAttendanceStudents = Attendance::lowAttendance($month)->get();

        // Return as JSON (for AJAX call)
        return response()->json($lowAttendanceStudents);
    }

    public function warningPage()
    {
        $month = now()->month;
        $lowAttendanceStudents = Attendance::lowAttendance($month)->get();
        return view('warning', compact('lowAttendanceStudents'));
    }
}

