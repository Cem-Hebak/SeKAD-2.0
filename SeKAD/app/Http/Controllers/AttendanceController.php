<?php
// app/Http/Controllers/AttendanceController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        // Retrieve only name and ic_number where role is 'Student'
        $students = User::where('role', 'Student')->get(['name', 'ic_number']);

        return view('attendanceRecord1', compact('students'));
    }
}
