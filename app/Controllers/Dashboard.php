<?php
namespace App\Controllers;
class Dashboard extends BaseController
{
    public function __construct()
    {
		$this->DashboardModel 	= new \App\Models\DashboardModel();
	}
	public function index($id=null)
	{
		echo htmlMinify(view('app/dashboard'));
	}
}
