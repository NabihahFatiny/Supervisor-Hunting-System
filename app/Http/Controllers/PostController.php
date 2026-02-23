<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['lecturer', 'titles'])->get();
        $categories = Post::select('PostCategory')->distinct()->get();

        if (session('role') === 'Student') {
            return view('student.topics', compact('posts', 'categories'));
        } else {
            return view('lecturer.topics', compact('posts', 'categories'));
        }
    }
     // This method fetches a post and its titles based on the PostID
     public function show($postId)
     {
         // Fetch the post, its titles, and the associated lecturer by PostID
        $post = Post::with('titles', 'lecturer')->findOrFail($postId);
         // Pass the post and its titles to the view
         return view('posts.topic', compact('post'));
     }
     public function store(Request $request)
     {
        try {
            DB::beginTransaction();

            // Validate the request
            $request->validate([
                'PostTitle' => 'required|string|max:255',
                'PostDescription' => 'required|string',
                'PostCategory' => 'required|string',
                'title_name' => 'required|array',
                'title_name.*' => 'required|string|max:255',
                'title_description' => 'required|array',
                'title_description.*' => 'required|string',
                'title_quota' => 'required|array',
                'title_quota.*' => 'required|integer|min:1',
            ]);

            // Handle custom category
            $category = $request->PostCategory;
            if ($request->PostCategory === 'other' && $request->has('CustomPostCategory')) {
                $category = $request->CustomPostCategory;
            }

            // Create the post
            $post = Post::create([
                'PostTitle' => $request->PostTitle,
                'PostDescription' => $request->PostDescription,
                'PostCategory' => $category,
                'LecturerID' => session('userId'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create the titles
            foreach ($request->title_name as $key => $title) {
                Title::create([
                    'PostID' => $post->PostID,
                    'TitleName' => $title,
                    'TitleDescription' => $request->title_description[$key],
                    'Quota' => $request->title_quota[$key],
                    'current_quota' => 0,
                    'TitleStatus' => 'Available'
                ]);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post created successfully',
                    'redirect' => route('posts.topic')
                ]);
            }

            return redirect()->route('posts.topic')->with('success', 'Post created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Post creation error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating post: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error creating post: ' . $e->getMessage());
        }
    }
    public function filterPosts(Request $request)
    {
        try {
            $query = Post::with(['lecturer', 'titles']);

        // Apply category filter if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('PostCategory', $request->category);
        }

        // Apply search filter if provided
        if ($request->filled('query')) {
            $searchTerm = '%' . $request->input('query') . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('PostTitle', 'like', $searchTerm)
                  ->orWhere('PostDescription', 'like', $searchTerm)
                  ->orWhereHas('lecturer', function($q) use ($searchTerm) {
                      $q->where('lecturerName', 'like', $searchTerm);
                  });
            });
        }

        $posts = $query->get();

        // Transform the data to ensure consistent structure
        $posts = $posts->map(function ($post) {
            return [
                'PostID' => $post->PostID,
                'PostTitle' => $post->PostTitle,
                'PostDescription' => $post->PostDescription,
                'PostCategory' => $post->PostCategory,
                'created_at' => $post->created_at,
                'lecturer' => $post->lecturer,
                'titles' => $post->titles->map(function ($title) {
                    return [
                        'TitleID' => $title->TitleID,
                        'TitleName' => $title->TitleName,
                        'TitleDescription' => $title->TitleDescription,
                        'TitleStatus' => $title->TitleStatus,
                        'Quota' => $title->Quota,
                        'current_quota' => $title->current_quota
                    ];
                })
            ];
        });

        return response()->json($posts);

    } catch (Exception $e) {
        Log::error('Error in filterPosts: ' . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
        return response()->json(['error' => 'Error filtering posts'], 500);
    }
}

public function searchPosts(Request $request)
{
    $query = $request->input('query');

    $posts = Post::with(['lecturer', 'titles'])
            ->where('PostTitle', 'LIKE', "%$query%")
            ->orWhere('PostDescription', 'LIKE', "%$query%")
            ->orWhere('PostCategory', 'LIKE', "%$query%")
            ->orWhereHas('lecturer', function ($q) use ($query) {
                $q->where('lecturerName', 'LIKE', "%$query%");
            })
            ->get();

    return response()->json($posts);
}
        //public function edit($id)
       // {

       // $editPost= \App\Models\Post::find($id);
        //return view('edit');
        //}
        public function edit($id)
        {
            $post = Post::with('titles')->findOrFail($id);

            // Check if the post belongs to the current lecturer
            if ($post->LecturerID != session('lecturerID')) {
                return redirect()->route('posts.topic')
                                ->with('error', 'Unauthorized to edit this post.');
            }

            $predefinedCategories = ['Software Engineering', 'Network Security', 'Data Science'];
            $customCategories = Post::select('PostCategory')
                                   ->whereNotIn('PostCategory', $predefinedCategories)
                                   ->distinct()
                                   ->pluck('PostCategory')
                                   ->toArray();
                                   $post = Post::with(['titles', 'lecturer'])
                                   ->where('PostID', $id)
                                   ->firstOrFail();


            // Changed the view path to lecturer.edit
            return view('lecturer.edit', compact('post', 'predefinedCategories', 'customCategories'));
        }
        public function update(Request $request, $id)
        {
            $post = Post::findOrFail($id);

            try {
                DB::beginTransaction();

                // Update post details
                $post->update([
                    'PostTitle' => $request->PostTitle,
                    'PostDescription' => $request->PostDescription,
                    'PostCategory' => $request->PostCategory
                ]);

                // Update existing titles and add new ones
                if ($request->has('titles')) {
                    foreach ($request->titles as $titleData) {
                        if (isset($titleData['id'])) {
                            // Update existing title
                            Title::where('TitleID', $titleData['id'])
                                 ->where('PostID', $post->PostID)
                                 ->update([
                                     'TitleName' => $titleData['TitleName'],
                                     'TitleDescription' => $titleData['TitleDescription'],
                                     'Quota' => $titleData['Quota']
                                 ]);
                        } else {
                            // Create new title
                            Title::create([
                                'PostID' => $post->PostID,
                                'TitleName' => $titleData['TitleName'],
                                'TitleDescription' => $titleData['TitleDescription'],
                                'Quota' => $titleData['Quota'],
                                'current_quota' => 0,
                                'TitleStatus' => 'Available'
                            ]);
                        }
                    }
                }

                DB::commit();
                return redirect()->route('posts.topic')->with('success', 'Post updated successfully');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Post update error: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Failed to update post. Please try again.']);
            }
        }

public function destroy($id)
{
    try {
        DB::beginTransaction();

        // Find the post
        $post = Post::findOrFail($id);

        // Check if the logged-in lecturer owns this post
        if ($post->LecturerID != session('userId')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this post'
            ], 403);
        }

        // Delete associated titles first
        $post->titles()->delete();

        // Delete the post
        $post->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Post deletion error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Error deleting post: ' . $e->getMessage()
        ], 500);
    }
}

public function deleteTitle($id)
{
    try {
        Log::info('Attempting to delete title with ID: ' . $id);

        $title = Title::where('TitleID', $id)->first();

        if (!$title) {
            Log::warning('Title not found with ID: ' . $id);
            return response()->json(['success' => false, 'message' => 'Title not found']);
        }

        Log::info('Found title:', ['title' => $title->toArray()]);

        $title->delete();
        Log::info('Title deleted successfully');

        return response()->json(['success' => true, 'message' => 'Title deleted successfully']);
    } catch (\Exception $e) {
        Log::error('Title deletion error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error deleting title: ' . $e->getMessage()]);
    }
}

}
