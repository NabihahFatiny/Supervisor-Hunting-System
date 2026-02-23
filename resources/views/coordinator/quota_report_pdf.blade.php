<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lecturer Quota Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            padding: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 100px;
            margin-bottom: 10px;
        }
        .title {
            color: #2d3748;
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .subtitle {
            color: #4a5568;
            font-size: 16px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #2e3033;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .negative-balance {
            color: #dc3545;
            font-weight: bold;
        }
        .positive-balance {
            color: #28a745;
            font-weight: bold;
        }
        .summary-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .summary-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #2d3748;
        }
        .summary-item {
            margin: 5px 0;
            font-size: 12px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/fk.png') }}" alt="FK Logo" class="logo">
        <div class="title">Lecturer Quota Report</div>
        <div class="subtitle">Faculty of Computing</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30%;">Lecturer Name</th>
                <th style="width: 15%;">Maximum Quota</th>
                <th style="width: 15%;">Assigned Quota</th>
                <th style="width: 20%;">Current Students</th>
                <th style="width: 20%;">Balance Quota</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lecturers as $lecturer)
            @php
                $balance = ($lecturer->assigned_quota ?? 0) - ($lecturer->current_students ?? 0);
                $balanceClass = $balance < 0 ? 'negative-balance' : 'positive-balance';
            @endphp
            <tr>
                <td>{{ $lecturer->lecturerName }}</td>
                <td>5</td>
                <td>{{ $lecturer->assigned_quota ?? 0 }}</td>
                <td>{{ $lecturer->current_students ?? 0 }}</td>
                <td class="{{ $balanceClass }}">{{ $balance }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <div class="summary-title">Summary Statistics</div>
        <div class="summary-item">
            <strong>Total Lecturers:</strong> {{ $lecturers->count() }}
        </div>
        <div class="summary-item">
            <strong>Total Assigned Quota:</strong> {{ $lecturers->sum('assigned_quota') }}
        </div>
        <div class="summary-item">
            <strong>Total Current Students:</strong> {{ $lecturers->sum('current_students') }}
        </div>
        <div class="summary-item">
            <strong>Total Balance Quota:</strong>
            {{ $lecturers->sum('assigned_quota') - $lecturers->sum('current_students') }}
        </div>
    </div>

    <div class="footer">
        <p>Generated on: {{ $generatedDate }}</p>
        <p>Supervisor Hunting System - Faculty of Computing</p>
    </div>
</body>
</html>
