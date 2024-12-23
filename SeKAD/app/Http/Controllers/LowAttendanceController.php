<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class LowAttendanceController extends Controller
{
    public function index()
    {
        $month = now()->month; // Current month
        $lowAttendanceStudents = Attendance::lowAttendance($month)->get();

        return view('low-attendance', compact('lowAttendanceStudents'));
    }
}

