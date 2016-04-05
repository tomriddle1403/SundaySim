<?php

namespace Sundaysim\Templates;

use Carbon\Carbon;
use SundaySim\Post;
use Illuminate\View\View;
use SundaySim\Templates\AbstractTemplate;

class BlogTemplate extends AbstractTemplate
{
	protected $view = 'blog';

	protected $posts;

	public function __construct(Post $posts)
	{
		$this->posts = $posts;
	}


	public function prepare(View $view, array $parameters)
	{
		$posts = $this->posts->with('author')
							 ->where('published_at', '<', Carbon::now())
							 ->orderBy('published_at', 'desc')
							 ->paginate();

		$view->with('posts', $posts);
	}
}