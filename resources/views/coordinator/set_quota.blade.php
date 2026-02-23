<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Set Quota - Supervisor Hunting</title>
    <link rel="stylesheet" href="{{ asset('css/styleMain.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <img src="{{ asset('img/fk.png') }}" alt="FK Logo" class="logo-image">
                <a href="{{ route('coordinator.mainpage') }}" class="logo-text">Supervisor Hunting</a>
            </div>

            <div class="nav-links">
                <a href="{{ route('coordinator.mainpage') }}" class="nav-item {{ request()->routeIs('coordinator.mainpage') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('coordinator.register_user') }}" class="nav-item {{ request()->routeIs('coordinator.register_user') ? 'active' : '' }}">
                    <i class="fas fa-user-plus"></i>
                    <span>Register User</span>
                </a>
                <a href="{{ route('coordinator.bulk-registrationForm') }}" class="nav-item {{ request()->routeIs('coordinator.bulk-registrationForm') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Bulk Register User</span>
                </a>
                <a href="{{ route('coordinator.timeframe') }}" class="nav-item {{ request()->routeIs('coordinator.timeframe') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Timeframe & Quota</span>
                </a>
                <a href="/SHS" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-xl font-semibold">Lecturer Quotas</h3>
                    <div>
                        <span class="text-sm text-gray-500 me-3">Maximum quota per lecturer: 5 students</span>
                        <button onclick="confirmGenerateReport()" class="btn btn-secondary">
                            <i class="fas fa-file-alt me-2"></i> Generate Report
                        </button>
                    </div>
                </div>

                <form id="quotaForm" method="POST" action="{{ route('coordinator.save_quota') }}"
                    onsubmit="return validateQuotas()">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Lecturer Name</th>
                                <th>Assigned Quota</th>
                                <th>New Quota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lecturers as $lecturer)
                                <tr>
                                    <td>{{ $lecturer->lecturerName }}</td>
                                    <td>{{ $lecturer->assigned_quota ?? 0 }}</td>
                                    <td>
                                        <input type="number"
                                            name="quotas[{{ $lecturer->lecturerID }}]"
                                            class="form-control quota-input"
                                            value="{{ $lecturer->quota?->assigned_quota ?? 0 }}"
                                            min="0"
                                            max="5"
                                            onchange="validateInput(this)"
                                            oninput="this.value = this.value > 5 ? 5 : Math.abs(this.value)">
                                        <span class="text-danger" style="display: none;">
                                            Maximum quota is 5 students
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            Save Quota
                        </button>
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Hidden form for report generation -->
    <form id="reportForm" action="{{ route('coordinator.quota_report') }}" method="GET" target="_blank"
        style="display: none;"></form>

    <script>
        function validateInput(input) {
            const errorSpan = input.nextElementSibling;
            if (input.value > 5) {
                input.value = 5;
                errorSpan.style.display = 'block';
                setTimeout(() => {
                    errorSpan.style.display = 'none';
                }, 3000);
            }
        }

        function validateQuotas() {
            let isValid = true;
            const inputs = document.querySelectorAll('.quota-input');

            inputs.forEach(input => {
                const value = parseInt(input.value);
                if (value > 5) {
                    isValid = false;
                    input.nextElementSibling.style.display = 'block';
                }
            });

            return isValid;
        }

        // Handle form submission
        document.getElementById('quotaForm').addEventListener('submit', function(e) {
            if (!validateQuotas()) {
                e.preventDefault();
                return false;
            }

            if (!confirm('Are you sure you want to save these quotas?')) {
                e.preventDefault();
                return false;
            }
        });

        function confirmGenerateReport() {
            if (confirm('Are you sure you want to generate the report?')) {
                document.getElementById('reportForm').submit();
            }
        }
    </script>

    <style>
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: #4a90e2;
            border-color: #4a90e2;
            color: white;
        }

        .btn-primary:hover {
            background-color: #357abd;
            border-color: #357abd;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            width: 100px;
            padding: 0.5rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .table {
            width: 100%;
            margin-bottom: 1.5rem;
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #2e3033;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
        }

        .table th,
        .table td {
            padding: 1rem;
            border: 1px solid #c3c3c3;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .quota-error {
            color: #a62935;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .bg-white {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .d-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .text-xl {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
        }

        .text-gray-500 {
            color: #6b7280;
        }
        .text-danger {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .me-3 {
            margin-right: 1rem;
        }
    </style>
</body>
</html>
