<?php  

namespace SundaySim\Presenters;

use Lewis\Presenter\AbstractPresenter;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;

class PostPresenter extends AbstractPresenter
{
	public function __construct($object)
	{
		
		$this->environment = Environment::createCommonMarkEnvironment();
		$this->parser = new DocParser($this->environment);
		$this->htmlRenderer = new HtmlRenderer($this->environment);


		parent::__construct($object);
	}

	public function excerptHtml()
	{
		if(!$this->excerpt) return null;

		$markdown = $this->excerpt;
		$document = $this->parser->parse($markdown);

		return $this->htmlRenderer->renderBlock($document);
		
	}

	public function bodytHtml()
	{
		if(!$this->body) return null;

		$markdown = $this->body;
		$document = $this->parser->parse($markdown);

		return $this->htmlRenderer->renderBlock($document);
	}


	public function publishedDate()
	{
		if ($this->published_at)
		{
			return $this->published_at->toFormattedDateString();
		}

		return 'Not Published';
	}

	public function publishedHighlight()
	{
		if ($this->published_at && $this->published_at->isFuture() )
		{
			return 'info';
		} elseif (! $this->published_at) {
			return 'warning';
		}
	}
}