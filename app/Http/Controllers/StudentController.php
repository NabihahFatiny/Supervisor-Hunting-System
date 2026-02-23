<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function mainpage()
    {
        try {
            $student_id = session('userId');

            // Get application count for the student
            $applicationCount = DB::table('fyp_application')
                ->where('student_id', $student_id)
                ->count();

            return view('student.mainpage', compact('applicationCount'));
        } catch (\Exception $e) {
            Log::error('Error in student mainpage: ' . $e->getMessage());
            return back()->with('error', 'Error loading main page');
        }
    }

    public function profile()
    {
        try {
            $student_id = session('userId');

            // Get student details
            $student = DB::table('student')
                ->where('student_id', $student_id)
                ->first();

            return view('student.profile', compact('student'));
        } catch (\Exception $e) {
            Log::error('Error in student profile: ' . $e->getMessage());
            return back()->with('error', 'Error loading profile');
        }
    }
}
