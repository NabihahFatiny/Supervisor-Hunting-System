<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Lecturer;

class LecturerScheduleController extends Controller
{

    //show schedule page
    public function showSchedule(){
        return view('student.schedule');
    }
    public function showScheduleLecturer(){
        return view('lecturer.schedule');
    }
    //view lecturer timetable
    public function viewTimetable()
    {
        // First get all lecturers
        $lecturers = Lecturer::orderBy('lecturerName')->get();

        // Create a collection to store all schedules (including empty ones)
        $schedules = collect();

        foreach ($lecturers as $lecturer) {
            // Get schedules for each lecturer, or empty collection if none exist
            $lecturerSchedules = Schedule::where('lecturer_id', $lecturer->lecturerID)
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

            // Add to main collection, using lecturer name as key
            $schedules[$lecturer->lecturerName] = $lecturerSchedules;
        }

        return view('student.viewTimetable', compact('schedules'));
    }
    public function showUploadSchedule()
    {
        // Fetch schedules for the lecturer id
        $lecturerId = session('userId');
        $schedules = Schedule::where('lecturer_id', $lecturerId)->get();

        // Pass the schedules to the view
        return view('lecturer.uploadSchedule', compact('schedules'));
    }

    public function updateSchedule(Request $request)
    {
        $lecturerId = session('userId');
        $lecturerName = Lecturer::where('lecturerID', $lecturerId)->value('lecturerName');
        // Get input data
        $scheduleIds = $request->input('schedule_ids', []);
        $subjects = $request->input('subjects', []);
        $days = $request->input('days', []);
        $startTimes = $request->input('start_times', []);
        $endTimes = $request->input('end_times', []);
        $locations = $request->input('locations', []);

        // Update existing schedules
        foreach ($scheduleIds as $index => $scheduleId) {
            Schedule::where('schedule_id', $scheduleId)->update([
                'subject' => $subjects[$index],
                'day' => $days[$index],
                'start_time' => $startTimes[$index],
                'end_time' => $endTimes[$index],
                'location' => $locations[$index],
                'updated_at' => now()
            ]);
        }

        // Add new schedules
        for ($i = count($scheduleIds); $i < count($subjects); $i++) {
            Schedule::create([
                'lecturer_id' => $lecturerId,
                'subject' => $subjects[$i],
                'day' => $days[$i],
                'start_time' => $startTimes[$i],
                'end_time' => $endTimes[$i],
                'location' => $locations[$i],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
     

        return redirect()->back()->with('success', 'Schedule updated successfully.');
    }
}
