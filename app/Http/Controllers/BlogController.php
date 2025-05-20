<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('blogs.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blog::select("uuid", "title", "slug", "status_publish", "date_publish", "time_publish")->get();
            return DataTables::of($blogs)
                ->addIndexColumn()
                ->make(true);
        }
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role != 'karyawan') {
            return redirect()->route('blog.index')
                ->with('error', 'Anda tidak memiliki akses untuk membuat Blog.');
        }
        $categoryBlog = CategoryBlog::all();
        return view('blogs.create', compact('categoryBlog'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        if (auth()->user()->role != 'karyawan') {
            return redirect()->route('blog.index')
                ->with('error', 'Anda tidak memiliki akses untuk membuat Blog.');
        }
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('blog_images', 'public');
        }

        // Create a new blog
        Blog::create([
            'title' => $request->title,
            'category_blog_id' => $request->category_blog_id,
            'description' => $request->description,
            'content' => $request->content,
            'date_publish' => $request->date_publish,
            'time_publish' => $request->time_publish,
            'status_publish' => 'draft',
            'image_url' => $imagePath, // Save image path
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('blog.index')->with('success', 'Blog created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $categoryBlog = CategoryBlog::all();
        $blog = Blog::where('uuid', $uuid)->firstOrFail();
        return view('blogs.show', compact('blog', 'categoryBlog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        // Find blog by UUID
        $blog = Blog::where('uuid', $uuid)->firstOrFail();
        $categoryBlog = CategoryBlog::all();
        return view('blogs.edit', compact('blog', 'categoryBlog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $uuid)
    {
        // Find blog by UUID
        $blog = Blog::where('uuid', $uuid)->firstOrFail();

        // Handle image upload
        $imagePath = $blog->image_url; // Retain the old image if no new image is uploaded
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('blog_images', 'public');
        }

        // Update blog
        $blog->update([
            'title' => $request->title,
            'category_blog_id' => $request->category_blog_id,
            'description' => $request->description,
            'content' => $request->content,
            'status_publish' => 'draft',
            'image_url' => $imagePath, // Update image path
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('blog.index')->with('success', 'Blog updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        // Mengecek apakah pengguna sudah login
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'You must be logged in to perform this action.'], 403);
        }

        try {
            DB::beginTransaction();

            $blog = Blog::where('uuid', $uuid)->firstOrFail();
            $blog->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Blog deleted successfully.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Blog not found.'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the blog.'
            ], 500);
        }
    }



    public function publishBlog(string $uuid)
    {
        if (auth()->user()->role != 'superadmin') {
            return redirect()->route('blog.show', $uuid)
                ->with('error', 'Anda tidak memiliki akses untuk mempublish Blog ini.');
        }

        // Temukan blog berdasarkan UUID
        $blog = Blog::where('uuid', $uuid)->firstOrFail();

        // Cek apakah status blog saat ini 'draft' atau 'deleted'
        if (!in_array($blog->status_publish, ['draft', 'deleted'])) {
            return redirect()->route('blog.show', $uuid)->with('error', 'Blog harus berstatus draft atau deleted sebelum dipublish.');
        }

        // Set tanggal dan waktu saat ini
        $currentDate = now()->toDateString(); // Menggunakan tanggal hari ini
        $currentTime = now()->toTimeString(); // Menggunakan waktu saat ini

        // Update status dan waktu publish
        $blog->update([
            'status_publish' => 'published',
            'date_publish' => $currentDate, // Menggunakan tanggal saat ini
            'time_publish' => $currentTime, // Menggunakan waktu saat ini
        ]);

        // Kembalikan response dengan pesan sukses
        return redirect()->route('blog.show', $uuid)->with('success', 'Blog berhasil dipublish.');
    }


    public function deleteBlog(Request $request, string $uuid)
    {
        if (auth()->user()->role != 'superadmin') {
            return redirect()->route('blog.show', $uuid)
                ->with('error', 'Anda tidak memiliki akses untuk menghapus Blog ini.');
        }

        // Temukan blog berdasarkan UUID
        $blog = Blog::where('uuid', $uuid)->firstOrFail();

        // Cek apakah status blog saat ini 'draft' atau 'published'
        if (!in_array($blog->status_publish, ['draft', 'published'])) {
            return redirect()->route('blog.show', $uuid)->with('error', 'Blog harus berstatus draft atau published sebelum dihapus.');
        }
        // Update status dan waktu publish
        $blog->update([
            'status_publish' => 'deleted',
            'date_publish' => null, // Menghapus tanggal publish
            'time_publish' => null, // Menghapus waktu publish
        ]);

        // Kembalikan response dengan pesan sukses
        return redirect()->route('blog.show', $uuid)->with('success', 'Blog berhasil dihapus.');
    }

    public function draftBlog(Request $request, string $uuid)
    {
        if (auth()->user()->role != 'superadmin') {
            return redirect()->route('blog.show', $uuid)
                ->with('error', 'Anda tidak memiliki akses untuk draft Blog ini.');
        }

        // Temukan blog berdasarkan UUID
        $blog = Blog::where('uuid', $uuid)->firstOrFail();

        // Cek apakah status blog saat ini 'published' atau 'deleted'
        if (in_array($blog->status_publish, ['published', 'deleted'])) {

            // Update status dan waktu publish
            $blog->update([
                'status_publish' => 'draft',
                'date_publish' => null, // Menghapus tanggal publish
                'time_publish' => null, // Menghapus waktu publish
            ]);

            // Kembalikan response dengan pesan sukses
            return redirect()->route('blog.show', $uuid)->with('success', 'Blog berhasil diubah menjadi draft.');
        } else {
            return redirect()->route('blog.show', $uuid)->with('error', 'Blog harus berstatus published atau deleted sebelum menjadi draft.');
        }
    }
}
