<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\usershs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BulkRegistrationController extends Controller
{

    public function showDashboard()
    {
        return view('coordinator.bulk-registration');
    }

    /**
    /**
     * Handle the upload of CSV files for bulk registration.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            Log::info('Processing CSV file: ' . $file->getClientOriginalName());

            $userCount = $this->processCsv($file);

            DB::commit();

            if ($userCount > 0) {
                return back()->with('success', "$userCount users uploaded successfully.");
            } else {
                return back()->with('error', "No users were uploaded. Please check your CSV file format.");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk registration error: ' . $e->getMessage());
            return back()->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    /**
     * Process the CSV file and create users.
     */
    private function processCsv($file)
    {
        // Read CSV file
        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($data);

        Log::info('CSV Headers:', $header);

        // Convert headers to lowercase for case-insensitive matching
        $header = array_map('strtolower', $header);

        // Find column indices
        $nameIndex = array_search('name', $header);
        $emailIndex = array_search('email', $header);
        $roleIndex = array_search('role', $header);

        if ($nameIndex === false || $emailIndex === false) {
            throw new \Exception('Required columns "name" and "email" not found in CSV');
        }

        $userCount = 0;

        foreach ($data as $row) {
            try {
                if (empty($row[$nameIndex]) || empty($row[$emailIndex])) {
                    Log::warning('Skipping row due to missing required fields:', $row);
                    continue;
                }

                Log::info('Processing row:', [
                    'name' => $row[$nameIndex],
                    'email' => $row[$emailIndex],
                    'role' => $roleIndex !== false ? $row[$roleIndex] : 'student'
                ]);

                // Create user
                usershs::create([
                    'studName' => $row[$nameIndex],
                    'studEmail' => $row[$emailIndex],
                    'role' => $roleIndex !== false ? $row[$roleIndex] : 'student'
                ]);

                $userCount++;
            } catch (\Exception $e) {
                Log::error('Error processing row: ' . json_encode($row) . ' Error: ' . $e->getMessage());
            }
        }

        Log::info('CSV processing completed. Users created: ' . $userCount);
        return $userCount;
    }
}

