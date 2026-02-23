<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Exception;

class ApplicationController extends Controller
{
    public function index()
    {
        try {
            // Get lecturer ID from session
            $lecturerId = session('userId');

            if (!$lecturerId) {
                Log::error('No lecturer ID found in session');
                return back()->with('error', 'Please login to view applications');
            }

            Log::info('Fetching applications for lecturer:', ['lecturer_id' => $lecturerId]);

            DB::enableQueryLog(); // Enable query logging

            // Get all applications for this lecturer with complete information
            $applications = DB::table('fyp_application')
                ->join('student', 'fyp_application.student_id', '=', 'student.student_id')
                ->join('fyp_title', 'fyp_application.title_id', '=', 'fyp_title.TitleID')
                ->select(
                    'fyp_application.application_id',
                    'fyp_application.status',
                    'fyp_application.created_at',
                    'fyp_application.remarks',
                    'fyp_application.file_path',
                    'student.studName',
                    'student.student_id',
                    'fyp_title.TitleName',
                    'fyp_title.TitleDescription'
                )
                ->where('fyp_application.lecturer_id', $lecturerId)
                ->orderBy('fyp_application.created_at', 'desc')
                ->get();

            Log::info('Applications retrieved:', [
                'count' => $applications->count(),
                'query' => DB::getQueryLog(),
                'lecturer_id' => $lecturerId
            ]);

            // Return the studentApp view with the applications
            return view('lecturer.studentApp', [
                'applications' => $applications,
                'lecturerId' => $lecturerId
            ]);

        } catch (Exception $e) {
            Log::error('Error fetching applications: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'lecturer_id' => $lecturerId ?? 'not set'
            ]);
            return back()->with('error', 'Error loading applications: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            Log::info('Showing application details', ['id' => $id]);

            DB::enableQueryLog(); // Enable query logging

            // Get application details with all necessary joins
            $application = DB::table('fyp_application')
                ->join('student', 'fyp_application.student_id', '=', 'student.student_id')
                ->join('fyp_title', 'fyp_application.title_id', '=', 'fyp_title.TitleID')
                ->join('lecturers', 'fyp_application.lecturer_id', '=', 'lecturers.lecturerID')
                ->select(
                    'fyp_application.*',
                    'student.studName',
                    'student.student_id',
                    'fyp_title.TitleName',
                    'fyp_title.TitleDescription',
                    'student.program',
                    'lecturers.lecturerName'
                )
                ->where('fyp_application.application_id', $id)
                ->first();

            Log::info('SQL Query:', ['query' => DB::getQueryLog()]);

            if (!$application) {
                Log::warning('Application not found', ['id' => $id]);
                return back()->with('error', 'Application not found.');
            }

            Log::info('Application found', ['application' => $application]);

            return view('lecturer.show', compact('application'));

        } catch (Exception $e) {
            Log::error('Error in show method: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'Error loading application details: ' . $e->getMessage());
        }
    }

    /**
     * Update lecturer's current quota based on actual student count
     */

     private function updateLecturerQuota($lecturerId)
    {
        // Count actual students under supervision
        $studentCount = DB::table('student')
            ->where('lecturer_Id', $lecturerId)
            ->whereNotNull('lecturer_Id')
            ->count();

        // Update lecturer's current quota
        DB::table('lecturers')
            ->where('lecturerID', $lecturerId)
            ->update(['current_quota' => $studentCount]);

        return $studentCount;
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            Log::info('Updating application status', [
                'application_id' => $id,
                'new_status' => $request->status,
                'remarks' => $request->remarks
            ]);

            // Get the application details
            $application = DB::table('fyp_application')
                ->join('student', 'fyp_application.student_id', '=', 'student.student_id')
                ->join('fyp_title', 'fyp_application.title_id', '=', 'fyp_title.TitleID')
                ->select(
                    'fyp_application.*',
                    'student.studName',
                    'student.studEmail',
                    'fyp_title.TitleName',
                    'fyp_title.TitleDescription'
                )
                ->where('fyp_application.application_id', $id)
                ->first();

            if (!$application) {
                throw new Exception('Application not found');
            }

            // Start transaction
            DB::beginTransaction();

            try {
                // If approving
                if ($request->status === 'Approved') {
                    // Count approved applications for this lecturer
                    $approvedCount = DB::table('fyp_application')
                        ->where('lecturer_id', $application->lecturer_id)
                        ->where('status', 'Approved')
                        ->count();

                    // Get lecturer's quota limits
                    $lecturer = DB::table('lecturers')
                        ->where('lecturerID', $application->lecturer_id)
                        ->select('assigned_quota', 'current_quota')
                        ->first();

                    // Check if current quota exceeds assigned quota
                    if (($approvedCount + 1) > $lecturer->assigned_quota) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot approve application. Lecturer has reached their assigned quota limit.'
                        ]);
                    }

                    // Update lecturer's current quota
                    DB::table('lecturers')
                        ->where('lecturerID', $application->lecturer_id)
                        ->update(['current_quota' => $approvedCount + 1]);

                    // Get the title's quota and current approved applications
                    $titleInfo = DB::table('fyp_title')
                        ->where('TitleID', $application->title_id)
                        ->select('Quota')
                        ->first();

                    // Count approved applications for this title
                    $approvedTitleCount = DB::table('fyp_application')
                        ->where('title_id', $application->title_id)
                        ->where('status', 'Approved')
                        ->count();

                    // Update FYP title status to Unavailable only if quota is reached
                    if (($approvedTitleCount + 1) >= $titleInfo->Quota) {
                        DB::table('fyp_title')
                            ->where('TitleID', $application->title_id)
                            ->update([
                                'TitleStatus' => 'Unavailable',
                                'updated_at' => now()
                            ]);
                    } else {
                        DB::table('fyp_title')
                            ->where('TitleID', $application->title_id)
                            ->update([
                                'updated_at' => now()
                            ]);
                    }

                    // Update student's lecturer_id and title_id
                    DB::table('student')
                        ->where('student_id', $application->student_id)
                        ->update([
                            'lecturer_Id' => $application->lecturer_id,
                            'title_Id' => $application->title_id,
                            'updated_at' => now()
                        ]);

                    // Only reject other applications if quota is now full
                    if (($approvedCount + 1) >= $lecturer->assigned_quota) {
                        // Get all pending applications for this lecturer
                        $pendingApplications = DB::table('fyp_application')
                            ->join('student', 'fyp_application.student_id', '=', 'student.student_id')
                            ->select('fyp_application.*', 'student.studEmail')
                            ->where('lecturer_id', $application->lecturer_id)
                            ->where('application_id', '!=', $id)
                            ->where('status', 'Pending')
                            ->get();

                        // Reject and notify each pending application
                        foreach ($pendingApplications as $pendingApp) {
                            // Update status to rejected
                            DB::table('fyp_application')
                                ->where('application_id', $pendingApp->application_id)
                                ->update([
                                    'status' => 'Rejected',
                                    'remarks' => 'Lecturer has reached maximum quota'
                                ]);

                            // Send rejection email
                            Mail::to($pendingApp->studEmail)->send(new \App\Mail\ApplicationStatusMail(
                                $pendingApp,
                                'Rejected',
                                'Lecturer has reached maximum quota'
                            ));
                        }
                    }
                }

                // Update application status and remarks
                DB::table('fyp_application')
                    ->where('application_id', $id)
                    ->update([
                        'status' => $request->status,
                        'remarks' => $request->remarks
                    ]);

                // Send email notification for the current application
                Mail::to($application->studEmail)->send(new \App\Mail\ApplicationStatusMail(
                    $application,
                    $request->status,
                    $request->remarks
                ));

                DB::commit();

                Log::info('Application status updated successfully', [
                    'new_status' => $request->status,
                    'student_email' => $application->studEmail
                ]);

                return response()->json(['success' => true]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error updating application status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function showApplicationForm()
    {
        try {
            Log::info('Starting showApplicationForm method');

            // Get student ID from session
            $student_id = session('userId');
            Log::info('Student ID from session', ['student_id' => $student_id]);

            // Get all lecturers from the correct table name
            $lecturers = DB::table('lecturers')->get();
            Log::info('Lecturers retrieved', [
                'count' => $lecturers->count(),
                'first_lecturer' => $lecturers->first()
            ]);

            // Create title object
            $title = (object)[
                'TitleName' => 'New Application',
                'TitleDescription' => 'Submit your own FYP proposal',
                'current_quota' => 0,
                'Quota' => 1,
                'TitleID' => null
            ];

            // Check if view exists
            $viewPath = 'student.submit_application';
            if (!view()->exists($viewPath)) {
                throw new Exception("View {$viewPath} does not exist");
            }

            Log::info('About to render view', [
                'view' => $viewPath,
                'student_id' => $student_id,
                'lecturer_count' => $lecturers->count()
            ]);

            // Return view with data
            return view($viewPath, [
                'title' => $title,
                'lecturers' => $lecturers,
                'student_id' => $student_id
            ]);

        } catch (Exception $e) {
            Log::error('Error in showApplicationForm: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error loading application form: ' . $e->getMessage());
        }
    }

    public function submitApplication(Request $request)
    {
        try {
            Log::info('Starting application submission', [
                'request_data' => $request->all()
            ]);

            // Validate the request data
            $validatedData = $request->validate([
                'student_id' => 'required',
                'lecturer_id' => 'required',
                'custom_title' => 'required|string|max:255',
                'description' => 'required|string',
                'file' => 'nullable|mimes:pdf,doc,docx|max:20000'
            ]);

            // Handle file upload if present
            $file_path = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file_path = $file->storeAs('applications', $fileName, 'public');
                Log::info('File uploaded', ['path' => $file_path]);
            }

            // First create a new title in fyp_title table
            $titleId = DB::table('fyp_title')->insertGetId([
                'PostID' => 0, // Use 0 for student proposals
                'TitleName' => $validatedData['custom_title'],
                'TitleDescription' => $validatedData['description'],
                'Quota' => 1, // Since this is a custom proposal
                'current_quota' => 1, // Already being applied for
                'TitleStatus' => 'Pending', // Status will be updated based on application
                'created_at' => now()
            ]);

            // Insert the application into the database
            $applicationId = DB::table('fyp_application')->insertGetId([
                'student_id' => $validatedData['student_id'],
                'lecturer_id' => $validatedData['lecturer_id'],
                'title_id' => $titleId, // Use the newly created title ID
                'custom_title' => $validatedData['custom_title'],
                'description' => $validatedData['description'],
                'file_path' => $file_path,
                'status' => 'Pending',
                'remarks' => null,
                'created_at' => now()
            ]);

            Log::info('Application created successfully', [
                'application_id' => $applicationId,
                'title_id' => $titleId
            ]);

            return redirect()->route('student.applications')
                ->with('success', 'Your application has been submitted successfully! You can track its status here.');

        } catch (Exception $e) {
            Log::error('Error submitting application: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Error submitting application: ' . $e->getMessage());
        }
    }

    public function studentApplications()
    {
        try {
            // Get student ID from session
            $student_id = session('userId');

            // Get all applications for this student with complete information
            $applications = DB::table('fyp_application')
                ->join('lecturers', 'fyp_application.lecturer_id', '=', 'lecturers.lecturerID')
                ->leftJoin('fyp_title', 'fyp_application.title_id', '=', 'fyp_title.TitleID')
                ->select(
                    'fyp_application.*',
                    'lecturers.lecturerName',
                    'lecturers.lecturerID',
                    'fyp_title.TitleName',
                    'fyp_title.TitleDescription'
                )
                ->where('fyp_application.student_id', $student_id)
                ->orderBy('fyp_application.created_at', 'desc')
                ->get();

            Log::info('Retrieved student applications', [
                'student_id' => $student_id,
                'count' => $applications->count()
            ]);

            return view('student.applications', compact('applications'));
        } catch (Exception $e) {
            Log::error('Error loading student applications: ' . $e->getMessage());
            return back()->with('error', 'Error loading applications: ' . $e->getMessage());
        }
    }

    public function showSubmitForm()
    {
        try {
            Log::info('Starting showSubmitForm method');
            $student_id = session('userId');

            // Get all lecturers
            $lecturers = DB::table('lecturers')->get();
            Log::info('Lecturers retrieved', [
                'count' => $lecturers->count()
            ]);

            return view('student.submit_application', [
                'lecturers' => $lecturers,
                'student_id' => $student_id
            ]);

        } catch (Exception $e) {
            Log::error('Error in showSubmitForm: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'Error loading submission form: ' . $e->getMessage());
        }
    }

    public function showApplyForm($titleId)
    {
        try {
            DB::enableQueryLog();

            Log::info('Starting showApplyForm method', [
                'titleId' => $titleId,
                'session' => session()->all()
            ]);

            $student_id = session('userId');
            Log::info('Student ID from session', ['student_id' => $student_id]);

            // Get title details with lecturer info
            $title = DB::table('fyp_title')
                ->join('posts', 'fyp_title.PostID', '=', 'posts.PostID')
                ->join('lecturers', 'posts.lecturerID', '=', 'lecturers.lecturerID')
                ->select(
                    'fyp_title.*',
                    'posts.PostDescription',
                    'lecturers.lecturerID as lecturer_id',
                    'lecturers.lecturerName'
                )
                ->where('fyp_title.TitleID', $titleId)
                ->first();

            Log::info('SQL Query:', [
                'query' => DB::getQueryLog(),
                'titleId' => $titleId,
                'title_found' => $title ? true : false
            ]);

            if (!$title) {
                Log::error('Title not found', ['titleId' => $titleId]);
                return redirect()->route('student.topics')->with('error', 'Title not found');
            }

            Log::info('Title found:', ['title' => $title]);

            // Return the apply view for existing titles
            return view('student.apply', [
                'title' => $title,
                'student_id' => $student_id
            ]);

        } catch (Exception $e) {
            Log::error('Error in showApplyForm: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'Error loading application form: ' . $e->getMessage());
        }
    }

    public function applyForTitle(Request $request, $titleId)
    {
        try {
            Log::info('Starting title application submission', [
                'titleId' => $titleId,
                'request_data' => $request->all()
            ]);

            // Validate the request data
            $validatedData = $request->validate([
                'student_id' => 'required',
                'lecturer_id' => 'required',
                'file' => 'required|file|mimes:pdf,doc,docx|max:20000',
            ], [
                'file.required' => 'A proposal document is required.',
                'file.mimes' => 'The proposal document must be a PDF or Word file.',
                'file.max' => 'The proposal document must not be larger than 20MB.'
            ]);

            if (!$request->hasFile('file')) {
                throw new Exception('No file was uploaded.');
            }

            // Handle file upload
            $file = $request->file('file');
            if (!$file->isValid()) {
                throw new Exception('File upload failed.');
            }

            // Create applications directory if it doesn't exist
            if (!Storage::disk('public')->exists('applications')) {
                Storage::disk('public')->makeDirectory('applications');
            }

            $fileName = time() . '_' . $file->getClientOriginalName();
            $file_path = $file->storeAs('applications', $fileName, 'public');

            Log::info('File uploaded', [
                'original_name' => $file->getClientOriginalName(),
                'stored_path' => $file_path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);

            // Get title details
            $title = DB::table('fyp_title')
                ->where('TitleID', $titleId)
                ->first();

            // Insert the application
            $applicationId = DB::table('fyp_application')->insertGetId([
                'student_id' => $validatedData['student_id'],
                'lecturer_id' => $validatedData['lecturer_id'],
                'title_id' => $titleId,
                'custom_title' => $title->TitleName,
                'description' => $title->TitleDescription,
                'file_path' => $file_path,
                'status' => 'Pending',
                'remarks' => null,
                'created_at' => now()
            ]);

            // Update the title's current quota
            DB::table('fyp_title')
                ->where('TitleID', $titleId)
                ->increment('current_quota');

            // If quota is full, update status
            $updatedTitle = DB::table('fyp_title')
                ->where('TitleID', $titleId)
                ->first();

            if ($updatedTitle->current_quota >= $updatedTitle->Quota) {
                DB::table('fyp_title')
                    ->where('TitleID', $titleId)
                    ->update(['TitleStatus' => 'Unavailable']);
            }

            Log::info('Application created successfully', [
                'application_id' => $applicationId,
                'title_id' => $titleId
            ]);

            return redirect()->route('student.applications')
                ->with('success', 'Your application has been submitted successfully! You can track its status here.');

        } catch (Exception $e) {
            Log::error('Error submitting application: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Error submitting application: ' . $e->getMessage());
        }
    }


}
