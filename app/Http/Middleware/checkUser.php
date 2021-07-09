<?php

namespace App\Http\Middleware;

use Session;
use App\Models\User;
use Closure;

class checkUser {
	/**
	 * @param $request
	 * @param Closure $next
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
    public function handle($request, Closure $next) {
        if (!session('token')) return redirect('/auth');

		$users = User::where([
			['remember_token', session('token')],
			['enable', '1'],
		])->limit(1)->get();
		if (!$users) return redirect('/auth');

		return $next($request);
    }
}
