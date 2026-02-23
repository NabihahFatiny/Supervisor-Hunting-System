<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Quota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Notifications\NewTimeframe;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\TimeframeNotification;

class CoordinatorController extends Controller
{
    /**
     * Show the main page for the Coordinator.
     *
     * @return \Illuminate\View\View
     */
    public function mainpage()
    {
        $studentCount = Student::count();
        $lecturerCount = Lecturer::count();

        return view('coordinator.mainpage', compact('studentCount', 'lecturerCount'));
    }

    public function manageusers()
    {
        return view('coordinator.register_user');
    }

    public function bulkregisteruser()
    {
        return view('coordinator.bulk_register_user');
    }

    public function timeframe()
    {
        return view('coordinator.manage_timeframe');
    }

    public function setTimeframe()
    {
        return view('coordinator.set_timeframe');
    }

    public function setQuota()
    {
        // Fetch all lecturers with their quotas using eager loading
        $lecturers = Lecturer::with('quota')->get();

        return view('coordinator.set_quota', compact('lecturers'));
    }

    public function saveQuota(Request $request)
    {
        try {
            DB::beginTransaction();

            // Iterate over the quotas array to update or create quotas
            foreach ($request->quotas as $lecturerId => $quota) {
                Quota::updateOrCreate(
                    ['Lecturer_id' => $lecturerId],
                    ['Assigned_quota' => $quota]
                );

                // Update lecturer's assigned_quota
                Lecturer::where('lecturerID', $lecturerId)
                    ->update([
                        'assigned_quota' => $quota,
                        'updated_at' => now()
                    ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Quotas have been updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating quotas: ' . $e->getMessage());
        }
    }

    public function saveTimeframe(Request $request)
    {
        try {
            DB::beginTransaction();

            Log::info('Starting timeframe save process');

            // Validate the request
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date'
            ]);

            // Create new timeframe
            DB::table('timeframe')->insert([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Get all students with email addresses
            $students = DB::table('student')
                ->whereNotNull('studEmail')
                ->select('student_Id', 'studName', 'studEmail')
                ->get();

            // Get all lecturers with email addresses
            $lecturers = DB::table('lecturers')
                ->whereNotNull('email')
                ->select('lecturerID', 'lecturerName', 'email')
                ->get();

            Log::info('Found students and lecturers:', [
                'student_count' => $students->count(),
                'lecturer_count' => $lecturers->count()
            ]);

            // Send notifications to students
            foreach ($students as $student) {
                try {
                    Log::info('Sending email to student:', [
                        'name' => $student->studName,
                        'email' => $student->studEmail
                    ]);

                    Mail::send('emails.timeframe-notification', [
                        'name' => $student->studName,
                        'role' => 'Student',
                        'startDate' => $request->start_date,
                        'endDate' => $request->end_date
                    ], function($message) use ($student) {
                        $message->to($student->studEmail)
                                ->subject('New Supervisor Hunting Timeframe Announced');
                    });

                    Log::info('Email sent successfully to student');
                } catch (\Exception $e) {
                    Log::error('Failed to send email to student:', [
                        'email' => $student->studEmail,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            // Send notifications to lecturers
            foreach ($lecturers as $lecturer) {
                try {
                    Log::info('Sending email to lecturer:', [
                        'name' => $lecturer->lecturerName,
                        'email' => $lecturer->email
                    ]);

                    Mail::send('emails.timeframe-notification', [
                        'name' => $lecturer->lecturerName,
                        'role' => 'Lecturer',
                        'startDate' => $request->start_date,
                        'endDate' => $request->end_date
                    ], function($message) use ($lecturer) {
                        $message->to($lecturer->email)
                                ->subject('New Supervisor Hunting Timeframe Announced');
                    });

                    Log::info('Email sent successfully to lecturer');
                } catch (\Exception $e) {
                    Log::error('Failed to send email to lecturer:', [
                        'email' => $lecturer->email,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            DB::commit();

            // Check Laravel's mail log
            Log::info('Mail log after sending:', [
                'log' => storage_path('logs/laravel.log')
            ]);

            return redirect()->back()->with('success',
                "Timeframe has been set successfully. Notifications sent to {$students->count()} students and {$lecturers->count()} lecturers.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in saveTimeframe:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Error setting timeframe: ' . $e->getMessage());
        }
    }

    public function generateQuotaReport()
    {
        // Get all lecturers with their quotas
        $lecturers = Lecturer::select(
            'lecturerID',
            'lecturerName',
            'assigned_quota'
        )->get();

        // Calculate current students from the same table
        foreach ($lecturers as $lecturer) {
            $lecturer->current_students = Student::where('lecturer_Id', $lecturer->lecturerID)->count();
        }

        $pdf = PDF::loadView('coordinator.quota_report_pdf', [
            'lecturers' => $lecturers,
            'generatedDate' => now()->format('d/m/Y H:i:s')
        ]);

        return $pdf->download('lecturer_quota_report.pdf');
    }

}
