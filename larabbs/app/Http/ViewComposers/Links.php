<?php 

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\Models\Link;

class Links
{
	protected $link;

	public function __construct(Link $link)
	{
		$this->link = $link;
	}

	public function compose(View $view)
	{
		 // 资源链接
		$view->with('links', $this->link->getAllCached());
	}
}