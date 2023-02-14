<?php

namespace App\Controllers;

class Reports extends BaseController
{
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->ReportsModel = new \App\Models\ReportsModel();
	}

	public function index()
	{
		$data["allFirms"] = $this->ReportsModel->allFirms();
		$data["userFirms"] = $this->ReportsModel->userFirms();

		echo htmlMinify(view('app/reports/index', $data));
	}
}