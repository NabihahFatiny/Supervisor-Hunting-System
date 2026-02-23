<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit Post</title>
  <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
  <link rel="stylesheet" href="{{asset('css/edit.css')}}">

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



<div class="container">
    <div class="edit-post-container">
        <div class="edit-header">
            <h2>Edit Post</h2>
            <a href="{{ route('posts.topic') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Posts
            </a>
        </div>
        <form action="{{ route('posts.update', $post->PostID) }}" method="POST" id="edit-post-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="PostTitle">Post Title</label>
                <input type="text" class="form-control" id="PostTitle" name="PostTitle"
                       value="{{ $post->PostTitle }}" required>
            </div>

            <div class="form-group">
                <label for="PostDescription">Post Description</label>
                <textarea class="form-control" id="PostDescription" name="PostDescription"
                          rows="4" required>{{ $post->PostDescription }}</textarea>
            </div>

            <div class="form-group">
                <label for="PostCategory">Category</label>
                <select class="form-control" id="PostCategory" name="PostCategory_select" required>
                    @php
                        $predefinedCategories = ['Software Engineering', 'Network Security', 'Data Science'];
                        $allCategories = \App\Models\Post::select('PostCategory')
                            ->distinct()
                            ->pluck('PostCategory')
                            ->toArray();
                        $customCategories = array_diff($allCategories, $predefinedCategories);
                    @endphp

                    <!-- Predefined categories -->
                    @foreach($predefinedCategories as $category)
                        <option value="{{ $category }}" {{ $post->PostCategory == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach

                    <!-- Custom categories that already exist -->
                    @foreach($customCategories as $category)
                        <option value="{{ $category }}" {{ $post->PostCategory == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach

                    <!-- Other option for new custom categories -->
                    <option value="other" {{ !in_array($post->PostCategory, array_merge($predefinedCategories, $customCategories)) ? 'selected' : '' }}>
                        Other
                    </option>
                </select>

                <!-- Custom category input -->
                <div id="custom-category-input" class="mt-2" style="display: none;">
                    <input type="text"
                           class="form-control"
                           id="CustomCategory"
                           name="CustomCategory"
                           placeholder="Enter custom category"
                           value="{{ !in_array($post->PostCategory, array_merge($predefinedCategories, $customCategories)) ? $post->PostCategory : '' }}">
                </div>
            </div>

            <div id="fyp-titles-section">
                <div class="section-header">
                    <h4>FYP Titles</h4>
                    <button type="button" id="add-title-btn" class="btn-add-title">
                        <i class="fas fa-plus"></i> Add Title
                    </button>
                </div>

                <div id="titles-container">
                    @foreach($post->titles as $index => $title)
                        <div class="fyp-title-item">
                            <input type="hidden" name="titles[{{ $index }}][id]" value="{{ $title->TitleID }}">

                            <div class="form-group">
                                <label>Title Name</label>
                                <input type="text" class="form-control"
                                       name="titles[{{ $loop->index }}][TitleName]"
                                       value="{{ $title->TitleName }}" required>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control"
                                        name="titles[{{ $loop->index }}][TitleDescription]"
                                        rows="3" required>{{ $title->TitleDescription }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Quota</label>
                                <input type="number" class="form-control"
                                       name="titles[{{ $loop->index }}][Quota]"
                                       value="{{ $title->Quota }}" required min="1">
                            </div>

                            <button type="button" class="btn-remove-title" data-title-id="{{ $title->TitleID }}">
                                <i class="fas fa-trash"></i> Remove Title
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('posts.topic') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Make sure you have Bootstrap JS included -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titlesContainer = document.getElementById('titles-container');
    const addTitleBtn = document.getElementById('add-title-btn');
    const deleteTitleModal = new bootstrap.Modal(document.getElementById('deleteTitleModal'));
    let titleToDelete = null;
    let titleIndex = {{ count($post->titles) }};

    const categorySelect = document.getElementById('PostCategory');
    const customCategoryInput = document.getElementById('custom-category-input');
    const customCategoryField = document.getElementById('CustomCategory');

    // Show/hide custom category input based on selection
    categorySelect.addEventListener('change', function() {
        if (this.value === 'other') {
            customCategoryInput.style.display = 'block';
            customCategoryField.setAttribute('required', 'required');
        } else {
            customCategoryInput.style.display = 'none';
            customCategoryField.removeAttribute('required');
            customCategoryField.value = '';
        }
    });

    // If 'other' is selected on page load, show the custom input
    if (categorySelect.value === 'other') {
        customCategoryInput.style.display = 'block';
        customCategoryField.setAttribute('required', 'required');
    }

    // Add new title functionality
    addTitleBtn.addEventListener('click', function() {
        const newTitleHTML = `
            <div class="fyp-title-item">
                <div class="form-group">
                    <label>Title Name</label>
                    <input type="text" class="form-control"
                           name="titles[${titleIndex}][TitleName]"
                           required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control"
                            name="titles[${titleIndex}][TitleDescription]"
                            rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label>Quota</label>
                    <input type="number" class="form-control"
                           name="titles[${titleIndex}][Quota]"
                           value="1" required min="1">
                </div>

                <button type="button" class="btn-remove-title">
                    <i class="fas fa-trash"></i> Remove Title
                </button>
            </div>
        `;

        titlesContainer.insertAdjacentHTML('beforeend', newTitleHTML);
        titleIndex++;
    });

    // Handle form submission
    const editForm = document.getElementById('edit-post-form');
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Handle category selection
        let categoryValue;
        if (categorySelect.value === 'other') {
            const customValue = customCategoryField.value.trim();
            if (!customValue) {
                alert('Please enter a custom category');
                return;
            }
            categoryValue = customValue;
        } else {
            categoryValue = categorySelect.value;
        }

        // Create hidden input for category
        let hiddenCategory = editForm.querySelector('input[name="PostCategory"]');
        if (!hiddenCategory) {
            hiddenCategory = document.createElement('input');
            hiddenCategory.type = 'hidden';
            hiddenCategory.name = 'PostCategory';
            editForm.appendChild(hiddenCategory);
        }
        hiddenCategory.value = categoryValue;

        // Submit the form
        editForm.submit();
    });

    // Handle remove title button click for dynamically added titles
    titlesContainer.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-title')) {
            const titleItem = e.target.closest('.fyp-title-item');
            const titleId = e.target.closest('.btn-remove-title').dataset.titleId;

            if (titleId) {
                // Existing title - show modal
                titleToDelete = {
                    element: titleItem,
                    id: titleId
                };
                deleteTitleModal.show();
            } else {
                // New title - remove immediately
                titleItem.remove();
            }
        }
    });

    // Handle confirm delete for existing titles
    document.getElementById('confirmDeleteTitle').addEventListener('click', async function() {
        if (titleToDelete && titleToDelete.id) {
            try {
                const response = await fetch(`/lecturer/titles/${titleToDelete.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                });

                const data = await response.json();

                if (data.success) {
                    titleToDelete.element.remove();
                    deleteTitleModal.hide();
                    showNotification('Title deleted successfully', 'success');
                } else {
                    showNotification(data.message || 'Failed to delete title', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error deleting title', 'danger');
            } finally {
                titleToDelete = null;
            }
        }
    });

    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = `alert alert-${type}`;
        notification.style.display = 'block';

        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }
});
</script>


    <!-- Update your modal HTML to ensure it matches -->
    <div class="modal fade" id="deleteTitleModal" tabindex="-1" aria-labelledby="deleteTitleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="deleteTitleModalLabel">Confirm Delete Title</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this title?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteTitle">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div id="notification" class="alert" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1060;"></div>

</body>
</html>
