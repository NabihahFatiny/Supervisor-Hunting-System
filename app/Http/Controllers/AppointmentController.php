<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Lecturer;
class AppointmentController extends Controller
{
    public function showBookingForm()
    {
           // Fetch all lecturers
        $lecturers = Lecturer::all(['lecturerID', 'lecturerName']);
        return view('student.addAppointmentRequest', compact('lecturers')); // Correct view file name
    }

    // Method to handle the appointment booking
    public function bookAppointment(Request $request)
    {
        $student_id = session('userId');
        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,lecturerID',
            'topic' => 'required|string|max:255',
            'day' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        // Create a new appointment with status 'pending'
        Appointment::create([
            'lecturer_id' => $validated['lecturer_id'],
            'student_id' => $student_id,
            'topic' => $validated['topic'],
            'day' => $validated['day'],
            'time' => $validated['time'],
            'location' => $validated['location'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Appointment has been booked.');
    }
    public function viewStatus()
    {
    // Retrieve all appointments (from the 'appointments' table)
    // Get all appointments from the database for the student
    $student_id = session('userId');
        $appointments = Appointment::where('student_id', $student_id)
        ->with('lecturer') // Load lecturer data
        ->orderBy('updated_at')
        ->orderBy('day')
        ->get();

    // Pass the appointments data to the view
    return view('student.viewStatus', compact('appointments'));
    }


    public function showAppointmentRequests()
    {
        // Get lecturer ID from session
        $lecturer_id = session('userId');

        // Retrieve all appointments for the lecturer (not just pending)
        $appointments = Appointment::where('lecturer_id', $lecturer_id)
            ->with(['lecturer', 'student']) // Eager load relationships
            ->orderBy('updated_at', 'desc') // Show newest first
            ->get();
        return view('lecturer.updateRequest', compact('appointments'));
    }

    // Update the status of an appointment (accept/reject)
    public function updateAppointmentStatus(Request $request, $appointmentId)
    {
        try {
            // Find the appointment
            $appointment = Appointment::findOrFail($appointmentId);

            // Verify this appointment belongs to the logged-in lecturer
            if ($appointment->lecturer_id != session('userId')) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Validate status input
            $request->validate([
                'status' => 'required|in:accepted,rejected',
            ]);

            // Update the appointment's status
            $appointment->status = $request->input('status');
            $appointment->save();

            return redirect()->back()->with('success', 'Appointment status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update appointment status.');
        }
    }



}
