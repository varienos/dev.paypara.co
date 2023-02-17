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

		$data["summary"] = $this->ReportsModel->getSummaryData();
		$data["mainChart"] = array(
			"deposit" => $this->ReportsModel->getMonthlyTransactionSum('deposit'),
			"withdraw" => $this->ReportsModel->getMonthlyTransactionSum('withdraw'),
		);
		$data["highlights"] = $this->ReportsModel->getHighlightsData();

		echo htmlMinify(view('app/reports/index', $data));
	}

	public function data()
	{
		$firm = $_POST["firm"];
		$year = $_POST["year"];
		$month = $_POST["month"];

		$data["summary"] = $this->ReportsModel->getSummaryData($month, $year, $firm);
		$data["mainChart"] = array(
			"deposit" => $this->ReportsModel->getMonthlyTransactionSum('deposit', $month, $year, $firm),
			"withdraw" => $this->ReportsModel->getMonthlyTransactionSum('withdraw', $month, $year, $firm),
		);

		return json_encode($data);
	}
}