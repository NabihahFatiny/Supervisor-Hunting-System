<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="{{asset('css/application.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .application-details {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 2rem;
        }

        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .details-header h1 {
            font-size: 1.8rem;
            color: #1f2937;
            margin: 0;
        }

        .details-section {
            margin-bottom: 2rem;
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .details-section h2 {
            font-size: 1.2rem;
            color: #4b5563;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .detail-item {
            margin-bottom: 1rem;
            background: white;
            padding: 1rem;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .detail-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .detail-value {
            font-size: 1rem;
            color: #1f2937;
            font-weight: 500;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
            text-align: center;
            min-width: 100px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-badge.pending {
            background-color: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
        }

        .status-badge.approved {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .status-badge.rejected {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-approve {
            background-color: #059669;
            color: white;
        }

        .btn-approve:hover {
            background-color: #047857;
            transform: translateY(-1px);
        }

        .btn-reject {
            background-color: #dc2626;
            color: white;
        }

        .btn-reject:hover {
            background-color: #b91c1c;
            transform: translateY(-1px);
        }

        .btn-back {
            padding: 0.5rem 1rem;
            color: #4b5563;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background-color: #e5e7eb;
            transform: translateY(-1px);
        }

        .document-link {
            color: #2563eb;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: #eff6ff;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .document-link:hover {
            background: #dbeafe;
            text-decoration: none;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }

        .modal-body {
            margin-bottom: 1.5rem;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .remarks-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            resize: vertical;
            min-height: 100px;
        }

        .success-message {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 1rem 1.5rem;
            background: #059669;
            color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
        }

        .success-message.show {
            display: block;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <img src="{{ asset('img/fk.png') }}" alt="FK Logo" class="logo-image">
                <a href="{{ route('lecturer.mainpage') }}" class="logo-text">Supervisor Hunting</a>
            </div>

            <div class="nav-links">
                <a href="{{ route('lecturer.mainpage') }}" class="nav-item {{ request()->routeIs('lecturer.mainpage') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('posts.topic') }}" class="nav-item {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Topics</span>
                </a>
                <a href="{{ route('applications.index') }}" class="nav-item {{ request()->routeIs('applications.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Applications</span>
                </a>
                <a href="{{ route('lecturer.timeframe') }}" class="nav-item {{ request()->routeIs('lecturer.timeframe') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Timeframe</span>
                </a>
                <a href="{{ route('lecturer.schedule') }}" class="nav-item {{ request()->routeIs('lecturer.schedule') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Schedule</span>
                </a>
                <a href="{{ route('lecturer.change-password.view') }}" class="nav-item {{ request()->routeIs('lecturer.change-password.view') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Setting</span>
                </a>
                <a href="/SHS" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="application-details">
            <button onclick="window.location.href='{{ route('applications.index') }}'" class="btn btn-back" style="margin-bottom: 1rem;">
                <i class="fas fa-arrow-left"></i> Back
            </button>

            <div class="details-header">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <h1>Application Details</h1>
                    <span class="status-badge {{ strtolower($application->status) }}">
                        {{ $application->status }}
                    </span>
                </div>

                @if($application->status === 'Pending')
                <div class="action-buttons" style="display: flex; gap: 0.5rem;">
                    <button type="button" class="btn btn-approve" onclick="showApproveModal()">
                        <i class="fas fa-check"></i> Approve
                    </button>
                    <button type="button" class="btn btn-reject" onclick="showRejectModal()">
                        <i class="fas fa-times"></i> Reject
                    </button>
                </div>
                @endif
            </div>

            <div class="details-section">
                <h2>Student Information</h2>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Name</div>
                        <div class="detail-value">{{ $application->studName }}</div>
                    </div><div class="detail-item">
                        <div class="detail-label">Program</div>
                        <div class="detail-value">{{ $application->program }}</div>
                    </div>
                </div>
            </div>

            <div class="details-section">
                <h2>Project Details</h2>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Title</div>
                        <div class="detail-value">{{ $application->TitleName }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Applied Date</div>
                        <div class="detail-value">{{ date('d M Y', strtotime($application->created_at)) }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Description</div>
                        <div class="detail-value">{{ $application->TitleDescription }}</div>
                    </div>
                </div>
            </div>

            <div class="details-section">
                <h2>Documents</h2>
                <div class="detail-item">
                    <div class="detail-label">Proposal Document</div>
                    <div class="detail-value">
                        <a href="{{ asset('storage/' . $application->file_path) }}" class="document-link" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                            View Document
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Approval</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this application?</p>
                <div class="form-group">
                    <label for="approveRemarks">Optional Remarks:</label>
                    <textarea id="approveRemarks" class="remarks-textarea" placeholder="Add any remarks for the student..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-back" onclick="hideApproveModal()">Cancel</button>
                <button type="button" class="btn btn-approve" onclick="confirmApprove()">Approve</button>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Rejection</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject this application?</p>
                <div class="form-group">
                    <label for="rejectRemarks">Remarks:</label>
                    <textarea id="rejectRemarks" class="remarks-textarea" placeholder="Please provide reasons for rejection..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-back" onclick="hideRejectModal()">Cancel</button>
                <button type="button" class="btn btn-reject" onclick="confirmReject()">Reject</button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="success-message"></div>

    <script>
        function showApproveModal() {
            document.getElementById('approveModal').classList.add('show');
        }

        function hideApproveModal() {
            document.getElementById('approveModal').classList.remove('show');
        }

        function showRejectModal() {
            document.getElementById('rejectModal').classList.add('show');
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.remove('show');
        }

        function showSuccessMessage(message) {
            const successMessage = document.getElementById('successMessage');
            successMessage.textContent = message;
            successMessage.classList.add('show');
            setTimeout(() => {
                successMessage.classList.remove('show');
            }, 3000);
        }

        function confirmApprove() {
            const remarks = document.getElementById('approveRemarks').value;
            fetch('{{ route('applications.updateStatus', $application->application_id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: 'Approved',
                    remarks: remarks,
                    _method: 'PUT'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hideApproveModal();
                    showSuccessMessage('Proposal approved successfully');
                    setTimeout(() => {
                        window.location.href = '{{ route('applications.index') }}';
                    }, 2000);
                } else {
                    alert(data.message || 'Error updating status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating status');
            });
        }

        function confirmReject() {
            const remarks = document.getElementById('rejectRemarks').value;
            if (!remarks.trim()) {
                alert('Please provide remarks for the rejection');
                return;
            }

            fetch('{{ route('applications.updateStatus', $application->application_id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: 'Rejected',
                    remarks: remarks,
                    _method: 'PUT'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hideRejectModal();
                    showSuccessMessage('Proposal rejected successfully');
                    setTimeout(() => {
                        window.location.href = '{{ route('applications.index') }}';
                    }, 2000);
                } else {
                    alert(data.message || 'Error updating status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating status');
            });
        }
    </script>
</body>
</html>
