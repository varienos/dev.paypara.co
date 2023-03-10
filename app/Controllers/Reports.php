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

	/**
	 * The default function that will be called when accessing the reports controller.
	 * It will retrieve various data from the ReportsModel and pass them to the view to be displayed.
	 */
	public function index()
	{
		// Check if the logged-in user has root access to display all firms' data
		if($this->session->get('root')) {
			// If yes, retrieve all firms
			$data["userFirms"] = $this->ReportsModel->getAllFirms();
		} else {
			// Otherwise, retrieve only the firms the user has access to
			$data["userFirms"] = $this->ReportsModel->getUserFirms();
		}

		// Retrieve the data for the highlight sections
		$data["highlights"] = $this->ReportsModel->getHighlightsData();

		// Retrieve the data for the main chart and the pie chart
		$data["mainChart"] = $this->ReportsModel->getMonthlyTransactionSum();
		$data["pieChart"] = $this->ReportsModel->getDepositDistribution();

		// Display the view with the retrieved data, with HTML minification
		echo htmlMinify(view('app/reports/index', $data));
	}

	/**
	 * This function retrieves highlight data for the specified firm, year, and month
	 *
	 * @return string The JSON-encoded highlight data
	 */
	public function getHighlights()
	{
		// Retrieve values from POST request
		$firm = $_POST["firm"];
		$year = $_POST["year"];
		$month = $_POST["month"];

		// Retrieve the data for the highlight sections
		$data["highlights"] = $this->ReportsModel->getHighlightsData($month, $year, $firm);

		// Retrieve the data for the main chart and the pie chart
		$data["mainChart"] = $this->ReportsModel->getMonthlyTransactionSum($month, $year, $firm);
		$data["pieChart"] = $this->ReportsModel->getDepositDistribution($month, $year, $firm);

		// Encode data as JSON and return
		return json_encode($data);
	}

	/**
	 * Formats a number to a currency string or plain number.
	 *
	 * @param float $number The number to format.
	 * @param bool $currency Whether to format as currency or not. Default: true.
	 *
	 * @return string The formatted number.
	 */
	public function formatNumber($number, $curreny = true)
	{
		if ($curreny) return $number == 0 ? "-" : "₺" . number_format($number, 2);

		return $number == 0 ? "-" : $number;
	}

	/**
	 * Get transactions data for given year, month, and firm to be used in the data table
	 *
	 * @param int|null $year - The year to retrieve transaction data for
	 * @param int|null $month - The month to retrieve transaction data for
	 * @param int|null $firm - The firm to retrieve transaction data for
	 *
	 * @return void
	 */
	public function getTransactions($year = null, $month = null, $firm = null)
	{
		// Retrieve values from POST request
		$firm = $_POST["firm"];
		$year = $_POST["year"];
		$month = $_POST["month"];

		// Get parameters from DataTables request
		$data['draw'] = intval($this->request->getVar('draw'));
		$data['start'] = intval($this->request->getVar('start'));
		$data['length'] = intval($this->request->getVar('length'));

		// Get transaction data
		$data['dataTable'] = $this->ReportsModel->getTransactions($year, $month, $firm);
		$data['dataTableNum'] = count((array)$data['dataTable']);

		// Set up variables for DataTables response
		$iTotalRecords = $data['dataTableNum'];
		$iDisplayLength = $data['length'];
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart = $data['start'];
		$sEcho = $data['draw'];

		// Initialize the records array
		$records = array();
		$records["data"] = array();

		// Check if data is empty
		$recordsTotal = 0;
		foreach ($data['dataTable'] as $row)
			foreach ($row as $key => $value)
				if ($key != 'request_time' && ($recordsTotal += (float) $value) >= 1) break 2;

		// Return if data is empty
		if ($recordsTotal == 0) return json_encode($records);

		// Set the end variable to the appropriate value
		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		// Loop through each row of data and add it to the records array
		$i = 0;
		foreach ($data['dataTable'] as $row) {
				$records["data"][$i] = array(
						'DT_RowId' => $row->id,
						'<div class="text-center fw-semibold text-gray-700">' . $row->request_time . '</div>',
				);

				// Add some additional columns if the user has root privileges
				if ($this->session->get('root')) {
						$records["data"][$i][] = '<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->crossTotal) . '</div>';
						$records["data"][$i][] = '<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->bankTotal) . '</div>';
						$records["data"][$i][] = '<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->posTotal) . '</div>';
						$records["data"][$i][] = '<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->paparaTotal) . '</div>';
						$records["data"][$i][] = '<div class="text-center fw-semibold text-gray-700">' . $this->formatNumber($row->matchingTotal) . '</div>';
				}

				// Add the remaining columns
				$records["data"][$i][] = '<div class="text-center fw-bold text-gray-800">' . $this->formatNumber($row->depositTxn, false) . '</div>';
				$records["data"][$i][] = '<div class="text-center fw-bold text-gray-800">' . $this->formatNumber($row->depositTotal) . '</div>';
				$records["data"][$i][] = '<div class="text-center fw-bold text-gray-800">' . $this->formatNumber($row->withdrawTxn, false) . '</div>';
				$records["data"][$i][] = '<div class="text-center fw-bold text-gray-800">' . $this->formatNumber($row->withdrawTotal) . '</div>';

				$i++;
		}

		// This code checks if a custom action type 'group_action' is requested via the POST method
		// If the custom action type is 'group_action', it sets the customActionStatus and customActionMessage keys of the $records array to indicate a successful completion of the group action
		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			$records["customActionStatus"] = "OK";
			$records["customActionMessage"] = "Group action successfully has been completed. Well done!";
		}

		// Sets the 'draw', 'recordsTotal', and 'recordsFiltered' keys of the $records array
		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		// Encodes the $records array as a JSON object and outputs it to the browser
		echo json_encode($records);
	}

	/**
	 * This function retrieves statistical data from the ReportsModel and formats it for display in a DataTable.
	 *
	 * @param int|null $year The year for which to retrieve statistics (optional).
	 * @param int|null $month The month for which to retrieve statistics (optional).
	 * @param string|null $firm The firm for which to retrieve statistics (optional).
	 *
	 * @return void
   */
	public function getStatistics($year = null, $month = null, $firm = null)
	{
		// Retrieve optional parameters from POST data.
		$firm = $_POST["firm"];
		$year = $_POST["year"];
		$month = $_POST["month"];

		// Retrieve DataTable parameters from GET data.
		$data['draw'] = intval($this->request->getVar('draw'));
		$data['start'] = intval($this->request->getVar('start'));
		$data['length'] = intval($this->request->getVar('length'));

		// Retrieve the statistical data and count the number of rows.
		$data['dataTableNum'] = count((array)$this->ReportsModel->getStatistics($year, $month, $firm)->getResult());
		$data['dataTable'] = $this->ReportsModel->getStatistics($year, $month, $firm);

		// Set up variables for DataTable formatting.
		$iTotalRecords = $data['dataTableNum'];
		$iDisplayLength = $data['length'];
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart = $data['start'];
		$sEcho = $data['draw'];
		$records = array();
		$records["data"] = array();
		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		// Format the statistical data for DataTable display.
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

		// Add custom action status if requested.
		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			$records["customActionStatus"] = "OK";
			$records["customActionMessage"] = "Group action successfully has been completed. Well done!";
		}

		// Add DataTable formatting data to the output array
		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		// Encode data as JSON and return
		echo json_encode($records);
	}
}