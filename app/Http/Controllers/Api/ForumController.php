<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    // LIHAT SEMUA POST (FEED)
    public function index()
    {
        // Ambil forum + data user urutkan terbaru
        $forums = Forum::with('user:id,name')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $forums
        ]);
    }

    // BUAT POSTINGAN BARU
    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'image' => 'nullable|string', 
        ]);

        $forum = Forum::create([
            'user_id' => $request->user()->id, 
            'deskripsi' => $request->deskripsi,
            'image' => $request->image,
            'likes_count' => 0,
            'comments_count' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Postingan Berhasil',
            'data' => $forum
        ]);
    }

    // LIHAT POSTINGAN SAYA (Tab "Post Saya")
    public function myPosts(Request $request)
    {
        $forums = Forum::where('user_id', $request->user()->id)
                        ->latest()
                        ->get();

        return response()->json([
            'success' => true,
            'data' => $forums
        ]);
    }
}