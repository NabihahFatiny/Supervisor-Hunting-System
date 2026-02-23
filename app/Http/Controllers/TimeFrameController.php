<?php

namespace App\Http\Controllers;

use App\Models\Timeframe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeFrameController extends Controller
{
    public function showTimeframe()
    {
        // Retrieve the latest timeframe
        $timeframe = Timeframe::latest()->first();


         // Retrieve the quota for the authenticated lecturer
         $quota = Auth::user()->quota;
        return view('lecturer.view_timeframe', compact('timeframe', 'quota'));
    }

    public function showTimeframeStudent()
    {
        // Retrieve the latest timeframe
        $timeframe = Timeframe::latest()->first();


         // Retrieve the quota for the authenticated lecturer
         $lecturer = Auth::user();
         $balanceQuota = $lecturer->balance_quota;

        return view('student.view_timeframe', compact('timeframe', 'balanceQuota'));
    }
}

