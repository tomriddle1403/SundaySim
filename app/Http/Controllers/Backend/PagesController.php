<?php

namespace SundaySim\Http\Controllers\Backend;

use SundaySim\Page;
use Illuminate\Http\Request;

use SundaySim\Http\Requests;

use Baum\MoveNotPossibleException;

class PagesController extends Controller
{
	protected $pages;

	public function __construct(Page $page)
	{

		$this->pages = $page;
		//parent::__construct($this);
	}
    public function index()
    {
    	$pages = $this->pages->all();
    	return view('backend.pages.index', compact('pages'));
    }

    public function create(Page $page)
    {
         $templates = $this->getPageTemplates();

        $orderPages = $this->pages->all();

        return view('backend.pages.form', compact('page','templates', 'orderPages'));
    }

    public function store(Requests\StorePageRequest $request)
    {
        $page = $this->pages->create( $request->only('title', 'uri', 'name', 'content','template'));

        $this->updatePageOrder($page, $request);

        return redirect(route('backend.pages.index'))->with('status', 'Page has been created.');

    }

    public function edit($id)
    {

        $page = $this->pages->findOrFail($id);

        $templates = $this->getPageTemplates();

        $orderPages = $this->pages->all();

        return view('backend.pages.form', compact('page','templates', 'orderPages'));
    }

    public function update(Requests\UpdatePageRequest $request, $id)
    {
        $page = $this->pages->findOrFail($id);
      
        if ($response = $this->updatePageOrder($page, $request)){
            return $response;
        }

        $page->fill($request->only('title', 'uri', 'name', 'content','template'))->save();

        return redirect(route('backend.pages.edit', $page->id))->with('status', 'Page has been updated.');
    }

    public function confirm($id)
    {
        $page = $this->pages->findOrFail($id);

        return view('backend.pages.confirm', compact('page'));
    }

    public function destroy($id)
    {
        $page = $this->pages->findOrFail($id);

        foreach ($page->children as $child)
        {
            $child->makeRoot();
        }

        $page->delete();

        return redirect(route('backend.pages.index'))->with('status', 'Page has been delete.');
    }

    protected function getPageTemplates()
    {
        $templates = config('cms.templates');

        return ['' => ''] + array_combine(array_keys($templates), array_keys($templates));
    }

    protected function updatePageOrder(Page $page, Request $request)
    {
       
        if ($request->has('order', 'orderPage'))
        {
            try{
              
                $page->updateOrder($request->input('order'), $request->input('orderPage'));
            } catch(MoveNotPossibleException $e){
                return redirect(route('backend.pages.edit', $page->id))->withInput()->withErrors([
                    'error' => 'Cannot make a page a child of itself.'
                ]);
            }
        }
    }

}
