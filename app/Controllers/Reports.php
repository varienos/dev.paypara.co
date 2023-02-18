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

	public function datatableTransactions($year = null, $month = null, $firm = null)
	{

		$data['draw'] 		= intval($this->request->getVar('draw'));
		$data['start'] 		= intval($this->request->getVar('start'));
		$data['length'] 	= intval($this->request->getVar('length'));
		$data['dataTableNum'] = count((array)$this->ReportsModel->datatableTransactions('', '', $_POST, $year, $month, $firm)->getResult());
		$data['dataTable'] 	= $this->ReportsModel->datatableTransactions($this->request->getVar('start'), $this->request->getVar('length'), $_POST, $year, $month, $firm);
		$iTotalRecords 	 	= $data['dataTableNum'];
		$iDisplayLength  	= $data['length'];
		$iDisplayLength  	= $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart 	 	= $data['start'];
		$sEcho 				= $data['draw'];
		$records 			= array();
		$records["data"] 	= array();
		$end 				= $iDisplayStart + $iDisplayLength;
		$end 				= $end > $iTotalRecords ? $iTotalRecords : $end;
		$i 				= 0;
		$crossTotal 	= 0;
		$bankTotal 		= 0;
		$posTotal 		= 0;
		$paparaTotal 	= 0;
		$matchingTotal 	= 0;
		$depositTotal 	= 0;
		$withdrawTotal 	= 0;
		foreach ($data['dataTable']->getResult() as $row) 
		{

				$crossTotal 	+= $row->crossTotal;
				$bankTotal 		+= $row->bankTotal;
				$posTotal 		+= $row->posTotal;
				$paparaTotal 	+= $row->paparaTotal;
				$matchingTotal 	+= $row->matchingTotal;
				$depositTotal 	+= $row->depositTotal;
				$withdrawTotal 	+= $row->withdrawTotal;

	

				$records["data"][$i] = array
				(
					'DT_RowId'  => $row->id,
					'<div class="fw-semibold text-gray-700">' . $row->request_time . '</div>',
					'<div class="fw-semibold text-gray-700">₺' . number_format($row->crossTotal,2) . '</div>',
					'<div class="fw-semibold text-gray-700">₺' . number_format($row->bankTotal,2) . '</div>',
					'<div class="fw-semibold text-gray-700">₺' . number_format($row->posTotal,2) . '</div>',
					'<div class="fw-semibold text-gray-700">₺' . number_format($row->paparaTotal,2) . '</div>',
					'<div class="fw-semibold text-gray-700">₺' . number_format($row->matchingTotal,2) . '</div>',
					'<div class="fw-bold text-gray-800">₺' . number_format($row->depositTotal,2) . '</div>',
					'<div class="fw-bold text-gray-800">₺' . number_format($row->withdrawTotal,2) . '</div>'
				);
			
			$i++;
		}
		$records["data"][$i] = array
		(
			'DT_RowId' => 999999999999999,
			'<div class="text-end">Sum:</th>',
			'<div class="text-center">₺' . number_format($crossTotal,2) . '</div>',
			'<div class="text-center">₺' . number_format($crossTotal,2) . '</div>',
			'<div class="text-center">₺' . number_format($posTotal,2) . '</div>',
			'<div class="text-center">₺' . number_format($paparaTotal,2) . '</div>',
			'<div class="text-center">₺' . number_format($matchingTotal,2) . '</div>',
			'<div class="text-center">₺' . number_format($depositTotal,2) . '</div>',
			'<div class="text-center">₺' . number_format($withdrawTotal,2) . '</div>'
		);


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