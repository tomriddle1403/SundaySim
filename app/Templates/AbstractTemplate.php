<?php 

namespace Sundaysim\Templates;

use Illuminate\View\View;

abstract class AbstractTemplate
{
	protected $view;

	abstract oublic function prepare(View $view, array $parameters);

	public function getView()
	{
		return $this->view;
	}

}