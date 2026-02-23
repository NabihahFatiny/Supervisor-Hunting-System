<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserShs;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Coordinator;
use App\Notifications\UserRegistered;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('signin'); // Return your login view
    }
    public function showone()
    {
        return view('dashboard'); // Return your login view
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:user_shs',
            'email' => 'required|email',
            'user_id' => 'required|string',
            'role' => 'required|in:Student,Lecturer',
        ]);

        try {
            DB::beginTransaction();

            // Generate a random temporary password
            $tempPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 12);

            // Create user_shs record
            $user = UserShs::create([
                'username' => $request->username,
                'temp_password' => $tempPassword,
                'new_password' => null,
                'role' => $request->role,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Based on role, create corresponding record
            if ($request->role === 'Student') {
                $student = Student::create([
                    'studName' => $request->name,
                    'studEmail' => $request->email,
                    'studentID' => $request->user_id,
                    'user_Id' => $user->user_Id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Send notification using direct email
                Notification::route('mail', $request->email)
                    ->notify(new UserRegistered($request->username, $tempPassword, 'Student'));

            } else { // Lecturer
                $lecturer = Lecturer::create([
                    'lecturerName' => $request->name,
                    'email' => $request->email,
                    'idlecturer' => $request->user_id,
                    'user_Id' => $user->user_Id,
                    'current_quota' => 0,
                    'assignedgroup_id' => 0,
                    'assigned_quota' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Send notification using direct email
                Notification::route('mail', $request->email)
                    ->notify(new UserRegistered($request->username, $tempPassword, 'Lecturer'));
            }

            DB::commit();

            // Redirect to a fresh registration form with a success message
            return redirect()->route('coordinator.register_user')
                ->with('success', 'User registered successfully! Login credentials have been sent to ' . $request->email);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    // Handle the login attempt
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        // Find the user by username
        $user = UserShs::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->withInput($request->except('password'));
        }

        // Check if new_password exists and matches
        if ($user->new_password && $user->new_password === $request->password) {
            $this->loginUser($user);
            return $this->redirectBasedOnRole($user);
        }

        // If no new_password or it didn't match, try temp_password
        if ($user->temp_password === $request->password) {
            $this->loginUser($user);
            return $this->redirectBasedOnRole($user);
        }

        // If neither password matched
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    private function loginUser($user)
    {
        Auth::guard('user_shs')->login($user);
    }

    private function redirectBasedOnRole($user)
    {
        switch($user->role) {
            case 'Student':
                $userData = Student::where('user_Id', $user->user_Id)->first();
                if ($userData) {
                    session([
                        'userName' => $userData->studName,
                        'userId' => $userData->student_Id,
                        'role' => 'Student'
                    ]);
                    return redirect()->route('student.mainpage');
                }
                break;

            case 'Lecturer':
                $userData = Lecturer::where('user_Id', $user->user_Id)->first();
                if ($userData) {
                    session([
                        'userName' => $userData->lecturerName,
                        'userId' => $userData->lecturerID,
                        'role' => 'Lecturer',
                        'lecturerID' => $userData->lecturerID
                    ]);
                    return redirect()->route('lecturer.mainpage');
                }
                break;

            case 'Coordinator':
                $userData = Coordinator::where('user_Id', $user->user_Id)->first();
                if ($userData) {
                    session([
                        'userName' => $userData->Name,
                        'userId' => $userData->CoordinatorID,
                        'role' => 'Coordinator',
                        'CoordinatorID' => $userData->CoordinatorID
                    ]);
                    return redirect()->route('coordinator.mainpage');
                }
                break;
        }

        Auth::guard('user_shs')->logout();
        return redirect()->route('login')->withErrors([
            'username' => 'Invalid user role.',
        ]);
    }
    //change password
    public function showChangePassword()
    {
        $role = session('role');
        return view('auth.change-password', compact('role'));
    }
    //update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        // Get the authenticated user
        $userId = session('userId');
        $role = session('role');

        // Find the user in user_shs table
        $user = UserShs::where('user_Id', function($query) use ($userId, $role) {
            if ($role === 'Student') {
                $query->select('user_Id')
                      ->from('student')
                      ->where('student_Id', $userId);
            } else {
                $query->select('user_Id')
                      ->from('lecturers')
                      ->where('lecturerID', $userId);
            }
        })->first();

        if (!$user) {
            return back()->withErrors(['error' => 'User not found.']);
        }

        // Check if current password matches
        if ($user->temp_password === $request->current_password ||
            $user->new_password === $request->current_password) {

            // Update the password
            $user->new_password = $request->new_password;
            $user->temp_password = null; // Clear temporary password
            $user->save();

            // Redirect based on role
            if ($role === 'Student') {
                return redirect()->route('student.mainpage')
                               ->with('success', 'Password changed successfully.');
            } else {
                return redirect()->route('lecturer.mainpage')
                               ->with('success', 'Password changed successfully.');
            }
        }

        return back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    public function logout()
    {
        Auth::guard('user_shs')->logout();
        session()->flush();
        return redirect('/');
    }
}
