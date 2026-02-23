<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LecturerController extends Controller
{
    public function mainpage()
    {
        $lecturerCurrentQuota = DB::table('lecturers')
            ->where('lecturerID', session('userId'))
            ->value('current_quota');

        return view('lecturer.mainpage', [
            'lecturerCurrentQuota' => $lecturerCurrentQuota ?? 0
        ]);
    }
}
