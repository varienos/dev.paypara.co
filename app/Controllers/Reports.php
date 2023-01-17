<?php

namespace App\Controllers;

class Reports extends BaseController
{
	public function __construct()
	{
	}
	public function index()
	{
		echo view('app/reports/index');
	}
}