<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Supervisor Hunting</title>
<link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
<link rel="stylesheet" href="{{asset('css/topicMain.css')}}">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
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

  <div class="postContainer">
    <!-- Left Section: Filter and Post Wall -->
    <div class="left-section">


        <!-- Post Wall -->
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
                        @if(session('lecturerID') == $post->LecturerID)
                            <div class="post-actions">
                                <div class="dropdown">
                                    <button class="dropdown-trigger">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ url('/lecturer/topic/' . $post->PostID . '/edit') }}" class="dropdown-item edit-post" data-id="{{ $post->PostID }}">
                                            <i class="fas fa-edit"></i> Edit Post
                                        </a>
                                        <a href="{{ url('/lecturer/topic/' . $post->PostID) }}" class="dropdown-item delete-post" data-id="{{ $post->PostID }}">
                                            <i class="fas fa-trash"></i> Delete Post
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                                <h5>{{ $title->TitleName }}</h5>
                                                <p>{{ $title->TitleDescription }}</p>
                                                <div class="title-meta">
                                                    <span class="quota">
                                                        <i class="fas fa-users"></i>
                                                        Quota: {{ $title->current_quota }}/{{ $title->Quota }}
                                                    </span>
                                                    <span class="status {{ strtolower($title->TitleStatus) }}">
                                                        <i class="fas fa-circle"></i>
                                                        {{ $title->TitleStatus }}
                                                    </span>
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
            <h3><i class="fas fa-filter"></i> Filter Posts</h3>
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
                <input type="text" id="search-filter" placeholder="Search posts...">
            </div>
            <div class="add-post-btn-container">
                <button id="open-add-post-btn" class="add-post-button">
                    <i class="fas fa-plus"></i> Create New Post
                </button>
            </div>
        </div>
</div>


  <!-- Add Post Modal -->
  <div id="add-post-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add a New FYP Post</h3>
            <span class="close-btn">&times;</span>
        </div>
      <form id="add-post-form" method="POST" action="{{ route('posts.store') }}">
     {{csrf_field()}}

      <!-- General Post Information -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <input type="text" name="PostTitle" id="post-title" placeholder="Enter General Post Title" />
      <textarea name="PostDescription" id="post-description" placeholder="Enter General Post Description"></textarea>

<select name="PostCategory" id="category-select">
    @foreach($categories as $category)
      <option value="{{ $category->PostCategory }}">{{ $category->PostCategory }}</option>
    @endforeach
    <option value="other">Other</option>
</select>

<!-- Custom Category Input (Initially Hidden) -->
<div id="custom-category-section" style="display: none;">
    <label for="custom-post-category">Enter Custom Category:</label>
    <input type="text" name="CustomPostCategory" id="category-input" placeholder="Enter Custom Category">
</div>

      <!-- Dynamic FYP Titles Section -->
      <div id="fyp-titles-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h4>FYP Titles</h4>
            <button id="add-title-btn">Add Title</button>
        </div>

      </div>



      <!-- Submit Button -->
      <button  type="submit" id="submit-post-btn">Submit Post</button>
    </form>
    </div>
  </div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteConfirmModal" tabindex="-1" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Delete</h3>
            <span class="close-btn" data-dismiss="modal">&times;</span>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this post? All associated titles will also be deleted.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn-delete" id="confirmDelete">Delete</button>
        </div>
    </div>
</div>
<!-- Toast Notification -->
<div id="toast-notification" class="toast-notification">
    <div class="toast-content">
        <i class="fas fa-check-circle toast-icon"></i>
        <span class="toast-message"></span>
    </div>
</div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...

    // Update form submission handler
    document.getElementById('add-post-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        // Add CSRF token to formData if not already present
        if (!formData.has('_token')) {
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        }

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message
                showToast('Post created successfully', 'success');

                // Redirect after a short delay
                setTimeout(() => {
                    window.location.href = data.redirect || '/posts/topic';
                }, 1000);
            } else {
                showToast(data.message || 'Error creating post', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error creating post. Please try again.', 'error');
        })
        .finally(() => {
            // Close the modal regardless of success/failure
            closeAddModal();
        });
    });

    // Toast notification function if not already defined
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;

        // Style the toast
        Object.assign(toast.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '1rem',
            borderRadius: '4px',
            color: '#fff',
            zIndex: '9999',
            backgroundColor: type === 'success' ? '#28a745' : '#dc3545',
            boxShadow: '0 2px 5px rgba(0,0,0,0.2)',
            transition: 'opacity 0.3s ease-in-out'
        });

        document.body.appendChild(toast);

        // Remove the toast after 3 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
});

$(document).ready(function () {
  // Show the modal when "Add Post" button is clicked
  $('#open-add-post-btn').click(function () {
    $('#add-post-modal').fadeIn();
    $('#category-select').show();
    $('#category-input').hide();
    $('#category-toggle').val('select');
  });

  // Close the modal when the close button is clicked
  $('.close-btn').click(function () {
    $('#add-post-modal').fadeOut();
  });

  // Add new FYP title section dynamically
  let titleCount = 1;
  $('#add-title-btn').click(function () {
    titleCount++;
    const newTitleHTML = `
      <div class="fyp-title-item" id="title-${titleCount}">
        <input type="text" name="title_name[]" class="title-name" placeholder="Enter Title Name" required />
        <textarea name="title_description[]" class="title-description" placeholder="Enter Title Description" required></textarea>
        <input type="number" name="title_quota[]" class="title-quota" placeholder="Enter Quota" required />
        <button type="button" class="remove-title-btn">Remove</button>
      </div>
    `;
    $('#fyp-titles-section').append(newTitleHTML);
  });

  // Remove a title section
  $(document).on('click', '.remove-title-btn', function () {
    $(this).closest('.fyp-title-item').remove();
  });
// Handle category selection change
$('#category-select').on('change', function () {
        const selectedValue = $(this).val();
        if (selectedValue === 'other') {
            $('#custom-category-section').fadeIn();
            $('#category-input').fadeIn();
            $('category-input').prop('required', true); // Make custom category input required
        } else {
            $('#custom-category-section').fadeOut();
            $('#category-input').prop('required', false); // Remove required if predefined selected
            $('#category-input').val(''); // Clear custom category input
        }
    });

// Ensure custom category input is included in the form submission when selected
$('#add-post-form').submit(function (e) {
    const selectedCategory = $('#category-select').val();
    if (selectedCategory === 'other' && $('#category-input').val().trim() === '') {
        e.preventDefault();
        alert('Please enter a custom category.');
    }
});


});

$(document).ready(function () {
   // Handle category filter
$('#category-filter').on('change', function () {
    var selectedCategory = $(this).val();

    $.ajax({
        url: '{{ route('filter.posts') }}',
        method: 'GET',
        data: { category: selectedCategory },
        success: function (response) {
            console.log('Filter response:', response);
            $('#posts-container').empty();

            if (response.length === 0) {
                $('#posts-container').html('<p>No posts available for this category.</p>');
                return;
            }

            response.forEach(function (post) {
                const postHTML = generatePostHTML(post);
                $('#posts-container').append(postHTML);
            });

            // Rebind handlers after loading filtered results
            bindDeleteHandlers();
        },
        error: function(xhr, status, error) {
            console.error('Filter error:', error);
            console.log('Response:', xhr.responseText);
        }
    });
});

function generatePostHTML(post) {
    const isCurrentLecturerPost = post.LecturerID == '{{ session('lecturerID') }}';
    const postId = parseInt(post.PostID) || 0;

    return `
        <div class="post">
            <div class="post-header">
                <div class="lecturer-info">
                    <div class="lecturer-details">
                        <span class="lecturer-name">${post.lecturer ? post.lecturer.lecturerName : 'Lecturer not assigned'}</span>
                        <span class="date-posted">
                            <i class="far fa-clock"></i>
                            ${new Date(post.created_at).toLocaleDateString()}
                        </span>
                    </div>
                </div>
                ${isCurrentLecturerPost ? `
                    <div class="post-actions">
                        <div class="dropdown">
                            <button class="dropdown-trigger">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="/topic/${postId}/edit" class="dropdown-item edit-post" data-id="${postId}">
                                    <i class="fas fa-edit"></i> Edit Post
                                </a>
                                <a href="#" class="dropdown-item delete-post" data-id="${postId}">
                                    <i class="fas fa-trash"></i> Delete Post
                                </a>
                            </div>
                        </div>
                    </div>
                ` : ''}
            </div>
            <div class="post-content">
                <h2>${post.PostTitle}</h2>
                <p>${post.PostDescription}</p>
                <span class="category-tag">
                    <i class="fas fa-tag"></i> ${post.PostCategory}
                </span>

                <!-- FYP Titles Section -->
                ${post.titles && post.titles.length > 0 ? `
                    <div class="fyp-titles-list">
                        <h4>FYP Titles:</h4>
                        <div class="titles-container">
                            ${post.titles.map(title => `
                                <div class="title-item">
                                    <div class="title-header">
                                        <h5>${title.TitleName}</h5>
                                        <p>${title.TitleDescription}</p>
                                    </div>
                                    <div class="title-meta">
                                        <div class="quota">
                                            <i class="fas fa-users"></i>
                                            <span>Quota: ${title.current_quota}/${title.Quota}</span>
                                        </div>
                                        <div class="status ${title.TitleStatus.toLowerCase()}">
                                            <i class="fas fa-circle"></i>
                                            <span>${title.TitleStatus}</span>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
            </div>
        </div>
    `;
}
});




$('#search-filter').on('keyup', function () {
    var searchTerm = $(this).val().trim().toLowerCase();

    $.ajax({
        url: '{{ route('search.posts') }}',
        method: 'GET',
        data: { query: searchTerm },
        success: function (response) {
            $('#posts-container').empty();

            if (response.length === 0) {
                $('#posts-container').html('<p>No posts found.</p>');
                return;
            }

            response.forEach(function (post) {
                // Check if the post belongs to the current lecturer
                const isCurrentLecturerPost = post.LecturerID == '{{ session('lecturerID') }}';

                const postHTML = `
                    <div class="post">
                        <div class="post-header">
                            <div class="lecturer-info">
                                 <div class="lecturer-details">
                                    <span class="lecturer-name">${post.lecturer ? post.lecturer.lecturerName : 'Lecturer not assigned'}</span>
                                    <span class="date-posted">
                                        <i class="far fa-clock"></i>
                                        ${new Date(post.created_at).toLocaleDateString()}
                                    </span>
                                </div>
                            </div>
                            ${isCurrentLecturerPost ? `
                                <div class="post-actions">
                                    <div class="dropdown">
                                        <button class="dropdown-trigger">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                    <a href="/topic/${postId}/edit" class="dropdown-item edit-post" data-id="${postId}">
                                                <i class="fas fa-edit"></i> Edit Post
                                            </a>
                                            <a href="#" class="dropdown-item delete-post" data-id="${post.PostID}">
                                                <i class="fas fa-trash"></i> Delete Post
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                        <div class="post-content">
                            <h2>${post.PostTitle}</h2>
                            <p>${post.PostDescription}</p>
                            <span class="category-tag">
                                <i class="fas fa-tag"></i> ${post.PostCategory}
                            </span>
                        </div>
                    </div>
                `;
                $('#posts-container').append(postHTML);
            });
         // Rebind delete handlers after loading search results
         bindDeleteHandlers();
        }
    });
});

// Separate function to bind delete handlers
function bindDeleteHandlers() {
    $('.delete-post').off('click').on('click', function(e) {
        e.preventDefault();
        postIdToDelete = $(this).data('id');
        $('#deleteConfirmModal').fadeIn();
    });
}

// Initial binding of delete handlers
$(document).ready(function() {
    let postIdToDelete = null;

    // Initial binding
    bindDeleteHandlers();

    // Close modal when clicking the close button or cancel
    $('.close-btn, .btn-cancel').click(function() {
        $('#deleteConfirmModal').fadeOut();
    });
    function showToast(message) {
    const toast = $('#toast-notification');
    toast.find('.toast-message').text(message);
    toast.addClass('show');

    // Hide toast after 3 seconds
    setTimeout(() => {
        toast.removeClass('show');
    }, 3000);
}
    // Handle delete confirmation
    $('#confirmDelete').click(function() {
        if (postIdToDelete) {
            $.ajax({
                url: `/topic/${postIdToDelete}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Hide modal
                    $('#deleteConfirmModal').fadeOut();

                // Show toast notification instead of alert
                showToast('Post deleted successfully');

            // Refresh the current view based on active filter/search
            const currentCategory = $('#category-filter').val();
                const searchQuery = $('#search-filter').val().trim();

                if (searchQuery) {
                    performSearch(searchQuery);
                } else if (currentCategory && currentCategory !== 'all') {
                    performFilter(currentCategory);
                } else {
                    window.location.reload();
                }
                },
                error: function(error) {
                console.error('Delete error:', error);
                $('#deleteConfirmModal').fadeOut();

                // Show error toast
                if (error.status === 403) {
                    showToast('You are not authorized to delete this post');
                } else {
                    showToast('Error deleting post. Please try again');
                }
            }
            });
        }
    });
});

$(document).ready(function() {
    let postIdToDelete = null;

    function showToast(message) {
    const toast = $('#toast-notification');
    toast.find('.toast-message').text(message);
    toast.addClass('show');

    // Hide toast after 3 seconds
    setTimeout(() => {
        toast.removeClass('show');
    }, 3000);
}
    // Function to bind delete handlers
    function bindDeleteHandlers() {
        $('.delete-post').off('click').on('click', function(e) {
            e.preventDefault();
            postIdToDelete = $(this).data('id');
            $('#deleteConfirmModal').fadeIn();
        });
    }

    // Initial binding
    bindDeleteHandlers();

    // Close modal when clicking the close button or cancel
    $('.close-btn, .btn-cancel').click(function() {
        $('#deleteConfirmModal').fadeOut();
    });

    // Handle delete confirmation
    $('#confirmDelete').click(function() {
        if (postIdToDelete) {
            $.ajax({
                url: `/topic/${postIdToDelete}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#deleteConfirmModal').fadeOut();

                  // Show toast notification
                  showToast('Post deleted successfully');

                    // Refresh the current view based on active filter/search
                    const currentCategory = $('#category-filter').val();
                    const searchQuery = $('#search-filter').val().trim();

                    if (searchQuery) {
                        performSearch(searchQuery);
                    } else if (currentCategory && currentCategory !== 'all') {
                        performFilter(currentCategory);
                    } else {
                        window.location.reload();
                    }
                },
                error: function(error) {
                    console.error('Delete error:', error);
                    $('#deleteConfirmModal').fadeOut();

                    // Show error toast
                    if (error.status === 403) {
                        showToast('You are not authorized to delete this post');
                    } else {
                        showToast('Error deleting post. Please try again');
                    }
                }
            });
        }
    });
// Filter function
function performFilter(category) {
        $.ajax({
            url: '{{ route('filter.posts') }}',
            method: 'GET',
            data: { category: category },
            success: function(response) {
                $('#posts-container').empty();

                if (response.length === 0) {
                    $('#posts-container').html('<p>No posts available for this category.</p>');
                    return;
                }

                response.forEach(function(post) {
                    const postHTML = generatePostHTML(post);
                    $('#posts-container').append(postHTML);
                });

                // Rebind delete handlers after updating content
                bindDeleteHandlers();
            },
            error: function(xhr, status, error) {
                console.error('Filter error:', error);
            }
        });
    }

    // Search function
    function performSearch(query) {
        $.ajax({
            url: '{{ route('search.posts') }}',
            method: 'GET',
            data: { query: query },
            success: function(response) {
                $('#posts-container').empty();

                if (response.length === 0) {
                    $('#posts-container').html('<p>No posts found.</p>');
                    return;
                }

                response.forEach(function(post) {
                    const postHTML = generatePostHTML(post);
                    $('#posts-container').append(postHTML);
                });

                // Rebind delete handlers after updating content
                bindDeleteHandlers();
            },
            error: function(xhr, status, error) {
                console.error('Search error:', error);
            }
        });
    }

    // Category filter handler
    $('#category-filter').on('change', function() {
        const category = $(this).val();
        performFilter(category);
    });

    // Search handler
    $('#search-filter').on('keyup', function() {
        const query = $(this).val().trim();
        performSearch(query);
    });
});

// Update the generatePostHTML function
function generatePostHTML(post) {
    const isCurrentLecturerPost = post.LecturerID == '{{ session('lecturerID') }}';
    const postId = parseInt(post.PostID) || 0;

    return `
        <div class="post">
            <div class="post-header">
                <div class="lecturer-info">
                    <div class="lecturer-details">
                        <span class="lecturer-name">${post.lecturer ? post.lecturer.lecturerName : 'Lecturer not assigned'}</span>
                        <span class="date-posted">
                            <i class="far fa-clock"></i>
                            ${new Date(post.created_at).toLocaleDateString()}
                        </span>
                    </div>
                </div>
                ${isCurrentLecturerPost ? `
                    <div class="post-actions">
                        <div class="dropdown">
                            <button class="dropdown-trigger">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="/topic/${postId}/edit" class="dropdown-item edit-post" data-id="${postId}">
                                    <i class="fas fa-edit"></i> Edit Post
                                </a>
                                <a href="#" class="dropdown-item delete-post" data-id="${postId}">
                                    <i class="fas fa-trash"></i> Delete Post
                                </a>
                            </div>
                        </div>
                    </div>
                ` : ''}
            </div>
            <div class="post-content">
                <h2>${post.PostTitle}</h2>
                <p>${post.PostDescription}</p>
                <span class="category-tag">
                    <i class="fas fa-tag"></i> ${post.PostCategory}
                </span>

                <!-- FYP Titles Section -->
                ${post.titles && post.titles.length > 0 ? `
                    <div class="fyp-titles-list">
                        <h4>FYP Titles:</h4>
                        <div class="titles-container">
                            ${post.titles.map(title => `
                                <div class="title-item">
                                    <div class="title-header">
                                        <h5>${title.TitleName}</h5>
                                        <p>${title.TitleDescription}</p>
                                    </div>
                                    <div class="title-meta">
                                        <div class="quota">
                                            <i class="fas fa-users"></i>
                                            <span>Quota: ${title.current_quota}/${title.Quota}</span>
                                        </div>
                                        <div class="status ${title.TitleStatus.toLowerCase()}">
                                            <i class="fas fa-circle"></i>
                                            <span>${title.TitleStatus}</span>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
            </div>
        </div>
    `;
}
  </script>

<!-- Add this CSS for the toast notifications -->
<style>
.toast {
    animation: slideIn 0.3s ease-in-out;
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

.toast-success {
    background-color: #28a745;
}

.toast-error {
    background-color: #dc3545;
}
</style>

</body>
</html>
