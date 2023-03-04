<?php

namespace App\Controllers;

class Reports extends BaseController
{
	public $session;
	public $ReportsModel;

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
		$data["highlights"] = $this->ReportsModel->getHighlightsData();
		$data["mainChart"] = array(
			"deposit" => $this->ReportsModel->getMonthlyTransactionSum('deposit'),
			"withdraw" => $this->ReportsModel->getMonthlyTransactionSum('withdraw'),
		);

		echo htmlMinify(view('app/reports/index', $data));
	}

	public function formatNumber($number)
	{
		return $number == 0 ? "-" : "₺" . number_format($number, 2);
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

	public function getTransactions($year = null, $month = null, $firm = null)
	{
		$firm = $_POST["firm"];
		$year = $_POST["year"];
		$month = $_POST["month"];

		$data['draw'] = intval($this->request->getVar('draw'));
		$data['start'] = intval($this->request->getVar('start'));
		$data['length'] = intval($this->request->getVar('length'));
		$data['dataTableNum'] = count((array)$this->ReportsModel->getTransactions($year, $month, $firm)->getResult());
		$data['dataTable'] = $this->ReportsModel->getTransactions($year, $month, $firm);
		$iTotalRecords = $data['dataTableNum'];
		$iDisplayLength = $data['length'];
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart = $data['start'];
		$sEcho = $data['draw'];
		$records = array();
		$records["data"] = array();
		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$i = 0;
		foreach ($data['dataTable']->getResult() as $row) {
				$records["data"][$i] = array(
					'DT_RowId'  => $row->id,
					'<div class="text-center fw-semibold text-gray-700">' . $row->request_time . '</div>',
					'<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->crossTotal) . '</div>',
					'<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->bankTotal) . '</div>',
					'<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->posTotal) . '</div>',
					'<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->paparaTotal) . '</div>',
					'<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->matchingTotal) . '</div>',
					'<div class="text-center fw-bold text-gray-800">' . $this->formatNumber($row->depositTotal) . '</div>',
					'<div class="text-center fw-bold text-gray-800">' . $this->formatNumber($row->withdrawTotal) . '</div>'
				);

			$i++;
		}

		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			$records["customActionStatus"] = "OK";
			$records["customActionMessage"] = "Group action successfully has been completed. Well done!";
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function getStatistics($year = null, $month = null, $firm = null)
	{
		$firm = $_POST["firm"];
		$year = $_POST["year"];
		$month = $_POST["month"];

		$data['draw'] = intval($this->request->getVar('draw'));
		$data['start'] = intval($this->request->getVar('start'));
		$data['length'] = intval($this->request->getVar('length'));

		$data['dataTableNum'] = count((array)$this->ReportsModel->getStatistics($year, $month, $firm)->getResult());
		$data['dataTable'] = $this->ReportsModel->getStatistics($year, $month, $firm);

		$iTotalRecords = $data['dataTableNum'];
		$iDisplayLength = $data['length'];
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart = $data['start'];
		$sEcho = $data['draw'];
		$records = array();
		$records["data"] = array();
		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$i = 0;
		foreach ($data['dataTable']->getResult() as $row) {
				$records["data"][$i] = array(
					'DT_RowId'  => $row->id,
					'<div class="text-center text-gray-800">' . $row->userId . '</div>',
					'<div class="text-center text-gray-800">' . $row->userNick . '</div>',
					'<div class="text-center text-gray-800">' . $row->userName . '</div>',
					'<div class="text-center text-gray-800">' . $row->count . '</div>',
					'<div class="text-center text-gray-800">' . $row->total . '</div>',
				);

			$i++;
		}

		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			$records["customActionStatus"] = "OK";
			$records["customActionMessage"] = "Group action successfully has been completed. Well done!";
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}
}