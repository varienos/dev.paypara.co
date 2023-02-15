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
		if($this->session->get('root')) {
			$data["userFirms"] = $this->ReportsModel->getAllFirms();
		} else {
			$data["userFirms"] = $this->ReportsModel->getUserFirms();
		}

		$data["summaryData"] = $this->ReportsModel->getSummaryData();
		$data["monthlyDeposit"] = $this->ReportsModel->getMonthlyTransactionSum();
		$data["monthlyWithdraw"] = $this->ReportsModel->getMonthlyTransactionSum('withdraw');

		echo htmlMinify(view('app/reports/index', $data));
	}

	public function data()
	{
		return "not implemented yet";
	}
}