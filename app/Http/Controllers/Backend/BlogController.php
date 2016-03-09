<?php

namespace SundaySim\Http\Controllers\Backend;

use Illuminate\Http\Request;

use SundaySim\Http\Requests;
use SundaySim\Http\Controllers\Controller;

use SundaySim\Post;

class BlogController extends Controller
{
    protected $posts;

    public function __construct(Post $posts)
    {
    	$this->posts = $posts;
    }

    public function index()
    {
       // \DB::enableQueryLog();

    	$posts = $this->posts->with('author')->orderBy('published_at','desc')->paginate(10);

    	return view('backend.blog.index', compact('posts'));

       // dd(\DB::getQueryLog());
    }

    public function create(Post $post)
    {
        return view('backend.blog.form', compact('post'));
    }
}
