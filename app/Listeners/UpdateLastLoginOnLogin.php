<?php 

namespace SundaySim\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;


class UpdateLastLoginOnLogin
{
	public function __construct()
	{
		
	}

	public function handle($login)
	{
		$user = $login->user;
		$user->last_login_at = Carbon::now();

		$user->save();
	}
}