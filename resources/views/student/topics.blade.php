<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Browse Topics - Supervisor Hunting</title>
<link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
<link rel="stylesheet" href="{{asset('css/topicMain.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <img src="{{ asset('img/fk.png') }}" alt="FK Logo" class="logo-image">
                <a href="{{ route('student.mainpage') }}" class="logo-text">Supervisor Hunting</a>
            </div>

            <div class="nav-links">
                <a href="{{ route('student.mainpage') }}" class="nav-item {{ request()->routeIs('student.mainpage') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('student.topics') }}" class="nav-item {{ request()->routeIs('student.topics') ? 'active' : '' }}">
                    <i class="fas fa-search"></i>
                    <span>Browse Topics</span>
                </a>
                <a href="{{ route('student.applications') }}" class="nav-item {{ request()->routeIs('student.applications') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>My Applications</span>
                </a>
                <a href="{{ route('student.profile') }}" class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="/SHS" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>

  <div class="postContainer">
        <!-- Left Section: Post Wall -->
    <div class="left-section">
        <div class="post-wall">
            <div id="posts-container">
                @foreach($posts as $post)
                <div class="post">
                    <div class="post-header">
                        <div class="lecturer-info">
                            <div class="lecturer-details">
                                <span class="lecturer-name">{{ $post->lecturer ? $post->lecturer->lecturerName : 'Lecturer not assigned' }}</span>
                                <span class="date-posted">
                                    <i class="far fa-clock"></i>
                                    {{ $post->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="post-content">
                        <h3>{{ $post->PostTitle }}</h3>
                        <p>{{ $post->PostDescription }}</p>
                        <span class="category-tag">
                            <i class="fas fa-tag"></i> {{ $post->PostCategory }}
                        </span>

                        <!-- FYP Titles Section -->
                        @if($post->titles && count($post->titles) > 0)
                            <div class="fyp-titles-list">
                                <h4>Available FYP Titles:</h4>
                                <div class="titles-container">
                                    @foreach($post->titles as $title)
                                            <div class="fyp-title-item">
                                                <div class="title-header">
                                                <h5>{{ $title->TitleName }}</h5>

                                                    @if($title->TitleStatus === 'Available' && $title->current_quota < $title->Quota)
                                                        <a href="{{ route('student.apply', ['titleId' => $title->TitleID]) }}" class="btn-apply">
                                                            <i class="fas fa-paper-plane"></i> Apply Now
                                                        </a>
                                                    @endif
                                                </div>
                                                <p>{{ $title->TitleDescription }}</p>
                                                <div class="title-meta">
                                                    <span class="quota">
                                                        <i class="fas fa-users"></i>
                                                        Quota: {{ $title->current_quota }}/{{ $title->Quota }}
                                                    </span>
                                                    <div class="post-status">
                                                        <span class="status-badge {{ strtolower($title->TitleStatus) }}">{{ $title->TitleStatus }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

        <!-- Right Section: Filter -->
        <div class="filter-section">
            <h3><i class="fas fa-filter"></i> Filter Topics</h3>
            <div class="filter-group">
                <label for="category">
                    <i class="fas fa-tag"></i> Category:
                </label>
                <select id="category-filter">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->PostCategory }}">{{ $category->PostCategory }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="search">
                    <i class="fas fa-search"></i> Search:
                </label>
                <input type="text" id="search-filter" placeholder="Search topics...">
            </div>
        </div>
</div>

    <!-- Add Modal Form -->
    <div id="applyModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
                <h2>Submit Application</h2>
                <span class="close">&times;</span>
        </div>
            <form id="applicationForm" action="{{ route('student.submit-application') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_id" value="{{ session('userId') }}">
                <input type="hidden" name="lecturer_id" id="modal-lecturer-id">
                <input type="hidden" name="custom_title" id="modal-title-name">
                <input type="hidden" name="title_id" id="modal-title-id">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Selected Title:</label>
                        <p id="modal-title-display" class="selected-title"></p>
</div>
                    <div class="form-group">
                        <label>Supervisor:</label>
                        <p id="modal-lecturer-display" class="selected-lecturer"></p>
        </div>
                    <div class="form-group">
                        <label for="file">Upload Proposal Document (PDF/Word)</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx" required>
                        <small class="text-muted">Upload your proposal document (max 20MB)</small>
    </div>
  </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Submit Application</button>
        </div>
            </form>
        </div>
    </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
$(document).ready(function () {
function generatePostHTML(post) {
            let html = `
        <div class="post">
            <div class="post-header">
                <div class="lecturer-info">
                    <div class="lecturer-details">
                        <span class="lecturer-name">${post.lecturer ? post.lecturer.lecturerName : 'Lecturer not assigned'}</span>
                        <span class="date-posted">
                            <i class="far fa-clock"></i>
                                    ${new Date(post.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}
                        </span>
                    </div>
                </div>
            </div>
            <div class="post-content">
                        <h3>${post.PostTitle}</h3>
                <p>${post.PostDescription}</p>
                <span class="category-tag">
                    <i class="fas fa-tag"></i> ${post.PostCategory}
                        </span>`;

            if (post.titles && post.titles.length > 0) {
                html += `
                    <div class="fyp-titles-list">
                        <h4>Available FYP Titles:</h4>
                        <div class="titles-container">`;

                post.titles.forEach(title => {
                    html += `
                        <div class="fyp-title-item">
                                    <div class="title-header">
                                        <h5>${title.TitleName}</h5>

                                ${title.TitleStatus === 'Available' && title.current_quota < title.Quota ?
                                    `<a href="{{ url('/student/apply/') }}/${title.TitleID}" class="btn-apply">
                                        <i class="fas fa-paper-plane"></i> Apply Now
                                    </a>` : ''}
                                    </div>
                                       <p>${title.}</p>
                                    <div class="title-meta">
                                <span class="quota">
                                            <i class="fas fa-users"></i>
                                    Quota: ${title.current_quota}/${title.Quota}
                                </span>
                                <div class="post-status">
                                    <span class="status-badge ${title.TitleStatus.toLowerCase()}">${title.TitleStatus}</span>
                                </div>
                            </div>
                        </div>`;
                });

                html += `
                        </div>
                    </div>`;
            }

            html += `
                    </div>
                </div>`;

            return html;
        }

        // Handle category filter
        $('#category-filter').on('change', function () {
            var selectedCategory = $(this).val();
            filterAndSearchPosts(selectedCategory, $('#search-filter').val());
        });

        // Handle search
        $('#search-filter').on('keyup', function () {
            var searchTerm = $(this).val().trim();
            if (searchTerm.length >= 2 || searchTerm.length === 0) {  // Only search if 2+ characters or empty
                filterAndSearchPosts($('#category-filter').val(), searchTerm);
            }
        });

        function filterAndSearchPosts(category, searchTerm) {
    $.ajax({
                url: '{{ route('filter.posts') }}',
        method: 'GET',
                data: {
                    category: category,
                    query: searchTerm
                },
        success: function (response) {
            $('#posts-container').empty();

            if (response.length === 0) {
                        $('#posts-container').html('<p class="no-results">No topics found matching your criteria.</p>');
                return;
            }

            response.forEach(function (post) {
                        const postHTML = generatePostHTML(post);
                $('#posts-container').append(postHTML);
            });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#posts-container').html('<p class="error-message">Error loading topics. Please try again.</p>');
            }
            });
        }

        function openApplyModal(titleId, titleName, lecturerId, lecturerName) {
            document.getElementById('modal-title-id').value = titleId;
            document.getElementById('modal-title-name').value = titleName;
            document.getElementById('modal-lecturer-id').value = lecturerId;
            document.getElementById('modal-title-display').textContent = titleName;
            document.getElementById('modal-lecturer-display').textContent = lecturerName;
            document.getElementById('applyModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('applyModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('applyModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    });
    </script>

    <style>
        /* Add these styles in your existing style block */
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge.available {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-badge.pending {
            background-color: #fef9c3;
            color: #854d0e;
        }

        .status-badge.unavailable {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-badge.closed {
            background-color: #f3f4f6;
            color: #1f2937;
        }

        /* Update the button styles */
        .btn-apply {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            border: none;
            font-size: 0.675rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            white-space: nowrap;
        }

        .btn-apply:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);
        }

        .btn-apply:active {
            transform: translateY(0);
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.2);
        }

        .btn-apply i {
            font-size: 0.575rem;
        }

        .post-actions {
            margin: 0.5rem 0;
        }

        /* Update title meta styles */
        .title-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .title-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .title-header h5 {
            margin: 0;
            flex: 1;
        }

        .fyp-title-item {
            padding: 1rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 0;
            width: 90%;
            max-width: 600px;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 1.5rem;
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 1rem 1rem 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.25rem;
            color: #1f2937;
        }

        .close {
            color: #666;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
            border-radius: 0 0 1rem 1rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .selected-title, .selected-lecturer {
            font-size: 1rem;
            color: #4b5563;
            padding: 0.5rem;
            background: #f3f4f6;
            border-radius: 0.5rem;
            margin: 0.5rem 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #4b5563;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }
    </style>
</body>
</html>
