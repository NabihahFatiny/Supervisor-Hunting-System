<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BulkRegistrationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\TimeFrameController;
use App\Http\Controllers\LecturerScheduleController;
use App\Models\Lecturer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\LecturerController;


// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Login routes
Route::get('/test', [AuthController::class, 'showone'])->name('test');
Route::get('/SHS', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/SHS', [AuthController::class, 'login'])->name('SHS.submit');

// Student routes
Route::middleware(['web', 'auth:user_shs'])->prefix('student')->group(function () {
    // Main pages
    Route::get('/mainpage', [StudentController::class, 'mainpage'])->name('student.mainpage');
    Route::get('/topics', [PostController::class, 'index'])->name('student.topics');
    Route::get('/applications', [ApplicationController::class, 'studentApplications'])->name('student.applications');
    Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
    //timeframe
     Route::get('/timeframe', [TimeFrameController::class, 'showTimeframeStudent'])->name('student.timeframe');

    // Application routes
    Route::get('/apply/{titleId}', [ApplicationController::class, 'showApplyForm'])->name('student.apply');
    Route::post('/apply/{titleId}', [ApplicationController::class, 'applyForTitle'])->name('student.apply.submit');
    Route::get('/submit-application', [ApplicationController::class, 'showSubmitForm'])->name('student.submit-application.form');
    Route::post('/submit-application', [ApplicationController::class, 'submitApplication'])->name('student.submit-application');
    //schedule routes
    Route::get('/schedule', [LecturerScheduleController::class, 'showSchedule'])->name('student.schedule');
    Route::get('/viewTimetable', [LecturerScheduleController::class, 'viewTimetable'])->name('student.viewTimetable');
    //appointment routes
    Route::get('/addAppointmentRequest', [AppointmentController::class, 'showBookingForm'])->name('student.addAppointment');
    Route::post('/addAppointmentRequest', [AppointmentController::class, 'bookAppointment'])->name('student.bookAppointment');
    //view appointment status
    Route::get('/viewStatus', [AppointmentController::class, 'viewStatus'])->name('student.viewStatus');
    // Change password
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('student.change-password.view');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('student.change-password.update');
});

// Lecturer routes
Route::middleware(['auth:user_shs'])->prefix('lecturer')->group(function () {
    // Main pages
    Route::get('/mainpage', [LecturerController::class, 'mainpage'])->name('lecturer.mainpage');

    Route::get('/timeframe', function () {
        return view('lecturer.view_timeframe');
    })->name('lecturer.timeframe');

    Route::get('/profile', function () {
        return view('lecturer.profile');
    })->name('lecturer.profile');

    // Topic management
    Route::get('/topics', [PostController::class, 'index'])->name('posts.topic');
    Route::post('/topics', [PostController::class, 'store'])->name('posts.store');

    // Post edit/delete
   // Route::get('/topic/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
   // Route::put('/topic/{id}', [PostController::class, 'update'])->name('posts.update');
   // Route::delete('/topic/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Applications
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::put('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    //schedule routes
    //view schedule option
    Route::get('/schedule', [LecturerScheduleController::class, 'showScheduleLecturer'])->name('lecturer.schedule');
    //upload schedule
    Route::get('/uploadSchedule', [LecturerScheduleController::class, 'showUploadSchedule'])->name('lecturer.uploadSchedule');
    //update schedule
    Route::post('/updateSchedule', [LecturerScheduleController::class, 'updateSchedule'])->name('lecturer.updateSchedule.submit');

    //upd appointment request
    Route::get('/updateRequest', [AppointmentController::class, 'showAppointmentRequests'])->name('lecturer.updateRequest');
    //accept/reject appointment request
    Route::post('/appointments/{id}/updateStatus', [AppointmentController::class, 'updateAppointmentStatus'])->name('lecturer.updateAppointmentStatus');

    // Post management routes with correct prefixing
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/topic', [PostController::class, 'index'])->name('posts.topic');
    Route::get('/topic/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/topic/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/topic/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::delete('/titles/{id}', [PostController::class, 'deleteTitle'])->name('titles.destroy');

    // Other lecturer routes...
});

//change password
// Student routes for change password
Route::middleware(['auth:user_shs'])->prefix('student')->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('student.change-password.view');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('student.change-password.update');
});

// Lecturer routes for change password
Route::middleware(['auth:user_shs'])->prefix('lecturer')->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('lecturer.change-password.view');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('lecturer.change-password.update');
});

// Logout routes
Route::post('/logout', function () {
    Auth::guard('user_shs')->logout();
    session()->flush();
    return redirect('/SHS');
})->name('logout');

// Other routes for post management
Route::get('/post/{postId}', [PostController::class, 'show'])->name('post.show');
Route::get('/filter-posts', [PostController::class, 'filterPosts'])->name('filter.posts');
Route::get('/search-posts', [PostController::class, 'searchPosts'])->name('search.posts');
Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');

//Route::put('/topic/{id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/topic/{id}', [PostController::class, 'destroy'])->name('topic.destroy');
Route::delete('/titles/{id}', [PostController::class, 'deleteTitle']);

Auth::routes(['verify'=> true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth:user_shs'])->prefix('coordinator')->group(function () {
    Route::get('/mainpage', [CoordinatorController::class, 'mainpage'])->name('coordinator.mainpage');
    Route::get('/manageusers', [CoordinatorController::class, 'manageusers'])->name('coordinator.register_user');
    Route::post('/register', [AuthController::class, 'register'])->name('coordinator.register.submit');

    //timeframe routes
    Route::get('/timeframe', [CoordinatorController::class, 'timeframe'])->name('coordinator.timeframe');
    Route::get('/setTimeframe', [CoordinatorController::class, 'setTimeframe'])->name('coordinator.setTimeframe');
    //quota routes
    Route::get('/setQuota', [CoordinatorController::class, 'setQuota'])->name('coordinator.setQuota');
    Route::post('/save-quota', [CoordinatorController::class, 'saveQuota'])->name('coordinator.save_quota');
    Route::get('/quota-report', [CoordinatorController::class, 'generateQuotaReport'])->name('coordinator.quota_report');
    Route::post('/save-timeframe', [CoordinatorController::class, 'saveTimeframe'])->name('coordinator.save_timeframe');


    Route::get('/bulk-registration', [BulkRegistrationController::class, 'showDashboard'])->name('coordinator.bulk-registrationForm');
    Route::post('/bulk-registration', [BulkRegistrationController::class, 'upload'])->name('coordinator.bulk-registration');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Add this temporary route for testing
Route::get('/test-email', function () {
    $data = [
        'name' => 'Test User',
        'email' => 'your-test-email@gmail.com'
    ];

    Mail::raw('Test email from Laravel SHS', function($message) use ($data) {
        $message->to($data['email']);
        $message->subject('Test Email');
    });

    return 'Test email sent!';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
