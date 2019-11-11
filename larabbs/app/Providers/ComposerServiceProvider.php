<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
	public function boot()
	{
		View::composer('sidebar.active_user', 'App\Http\ViewComposers\ActiveUsers');
		View::composer('sidebar.links', 'App\Http\ViewComposers\Links');
	}

	public function register()
	{
		//
	}
}