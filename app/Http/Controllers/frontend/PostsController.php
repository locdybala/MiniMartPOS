<?php

namespace App\Http\Controllers\frontend;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return view('frontend.posts.index', compact('posts'));
    }
}
