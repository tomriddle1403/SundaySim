<?php  

namespace SundaySim\Presenters;

use Lewis\Presenter\AbstractPresenter;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
	
class PagePresenter extends AbstractPresenter
{
	public function __construct($object)
	{
		
		$this->environment = Environment::createCommonMarkEnvironment();
		$this->parser = new DocParser($this->environment);
		$this->htmlRenderer = new HtmlRenderer($this->environment);

		parent::__construct($object);
	}

	public function contentHtml()
	{
		if(!$this->content) return null;

		$markdown = $this->content;
		$document = $this->parser->parse($markdown);

		return $this->htmlRenderer->renderBlock($document);
		
	}

	public function uriWildcard()
	{
		return $this->uri.'*';
	}

	public function prettyUri()
	{
	
		return '/'.ltrim($this->uri, '/');
	}

	public function linkToPaddedTitle($link)
	{
		$padding = str_repeat('&nbsp;', $this->depth * 4);

		return $padding.link_to($link, $this->title);
	}

	public function paddedTitle()
	{
		return str_repeat('&nbsp;', $this->depth * 4).$this->title;
	}
}