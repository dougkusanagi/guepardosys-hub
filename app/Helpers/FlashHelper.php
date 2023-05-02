<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('flash')) {
	function flash(string $key, array $alert_config)
	{
		$current_alerts = Session::get($key);

		if ($current_alerts) {
			array_push($current_alerts, $alert_config);
		} else {
			$current_alerts[] = $alert_config;
		}

		Session::forget($key);
		Session::now($key, $current_alerts);
	}
}
