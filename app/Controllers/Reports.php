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
		$data["userFirms"] = $this->ReportsModel->getUserFirms();
		$data["summaryData"] = $this->ReportsModel->getSummaryData();
		$data["monthlyDeposit"] = $this->ReportsModel->getMonthlyTransactionSum();
		$data["monthlyWithdraw"] = $this->ReportsModel->getMonthlyTransactionSum('withdraw');

		echo htmlMinify(view('app/reports/index', $data));
	}
}