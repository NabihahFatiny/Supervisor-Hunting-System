<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-weight: bold;
            margin: 10px 0;
        }
        .approved {
            background-color: #d4edda;
            color: #155724;
        }
        .rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .remarks {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>FYP Application Update</h2>
    </div>

    <div class="content">
        <p>Dear {{ $application->studName }},</p>

        <p>Your FYP application has been <span class="status {{ strtolower($status) }}">{{ $status }}</span></p>

        <h3>Application Details:</h3>
        <ul>
            <li><strong>Project Title:</strong> {{ $application->TitleName }}</li>
            <li><strong>Submission Date:</strong> {{ date('d M Y', strtotime($application->created_at)) }}</li>
        </ul>

        @if($remarks)
        <div class="remarks">
            <h4>Supervisor's Remarks:</h4>
            <p>{{ $remarks }}</p>
        </div>
        @endif

        @if($status === 'Approved')
        <p>Congratulations! Your FYP application has been approved. You can now proceed with your project under the supervision of your assigned lecturer.</p>
        <p>Next steps:</p>
        <ol>
            <li>Schedule an initial meeting with your supervisor</li>
            <li>Begin working on your project timeline</li>
            <li>Start preparing your project documentation</li>
        </ol>
        @else
        <p>We encourage you to review the remarks provided and consider submitting a new application taking into account the feedback received.</p>
        @endif
    </div>

    <div class="footer">
        <p>This is an automated message from the FYP Management System.</p>
        <p>If you have any questions, please contact your faculty administrator.</p>
    </div>
</body>
</html>
