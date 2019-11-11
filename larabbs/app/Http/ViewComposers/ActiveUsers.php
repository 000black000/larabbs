<?php 

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\Models\User;

class ActiveUsers
{
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function compose(View $view)
	{
		// 活跃用户列表
		$view->with('active_users', $this->user->getActiveUsers());
	}
}