<?php
namespace App\Controllers;
class Transaction extends BaseController
{
	public $TransactionModel;
    public function __construct()
    {
		$this->TransactionModel = new \App\Models\TransactionModel();
        $this->ClientModel 	    = new \App\Models\ClientModel();
	}
	public function include($fileName)
	{
		echo htmlMinify(view('app/transaction/include/'.$fileName));
	}
    public function notificationSound($status)
	{
        $this->TransactionModel->notificationSound($status);
    }
    public function getNotificationSoundStatus()
	{
        return $this->response->setJSON(json_encode(["status"=>$this->TransactionModel->getNotificationSoundStatus()],JSON_NUMERIC_CHECK));
    }
    public function modal($request,$response,$id)
	{
        if($request=="deposit") $this->SecureModel->stateAuth(view_transaction_deposit);
        if($request=="withdraw") $this->SecureModel->stateAuth(view_transaction_withdraw);
        $update = $this->TransactionModel->detail($id);
        if($update->status=="beklemede")
        {
            $datetime1 	= new \DateTime($update->request_time_default);
            $datetime2 	= new \DateTime();
            $interval 	= $datetime1->diff($datetime2);
            $time 		= "<span class='timer1'>".$interval->format("%I:%S")."</span>";
        }else{
            $datetime1 	= new \DateTime($update->request_time_default);
            $datetime2 	= new \DateTime($update->response_time_default);
            $interval 	= $datetime1->diff($datetime2);
            $time		= "<span class='timer2'>".$interval->format("%I:%S")."</span>";
        }
		echo htmlMinify(view('app/transaction/modal/'.$request.'/'.$response,["update"=>$update,"time"=>$time]));
	}
	public function index($request)
	{
        if($request=="404") $this->SecureModel->stateAuth(view_transaction_deposit);
        if($request=="deposit") $this->SecureModel->stateAuth(view_transaction_deposit);
        if($request=="withdraw") $this->SecureModel->stateAuth(view_transaction_withdraw);
		$data["request"]    = $request;
        $data["siteSelect"]	= $this->ClientModel->clients();
		echo htmlMinify(view('app/transaction/index',$data));
	}
	public function update()
	{
        $finance = $this->db->query("select request from finance where id='".$this->request->getVar('id')."'")->getRow();
        if($finance->request=="deposit") $this->SecureModel->stateAuth(edit_transaction_deposit);
        if($finance->request=="withdraw") $this->SecureModel->stateAuth(edit_transaction_withdraw);
		$this->TransactionModel->dataUpdate($this->request->getVar());
	}
	public function datatable($request)
	{
        if($request=="deposit") $this->SecureModel->stateAuth(view_transaction_deposit);
        if($request=="withdraw") $this->SecureModel->stateAuth(view_transaction_withdraw);
        function process($id,$request,$status,$row,$status_id)
        {
            if($status=="beklemede")
            {
                $css            = '';
                $tagsApprove    = 'data-bs-toggle="modal" id="approved" data-bs-target="#ajaxModal" data-url="transaction/modal/'.$request.'/approve/'.$id.'"';
                $tagsReject     = 'data-bs-toggle="modal" id="reject" data-bs-target="#ajaxModal" data-url="transaction/modal/'.$request.'/reject/'.$id.'"';
            }else{
                $css            = 'style="opacity:0.2; cursor: not-allowed;"';
                $tagsApprove    = $css;
                $tagsReject     = $css;
            }
            return
            '<div class="text-center">
            <button class="btn btn-icon rounded-circle w-30px h-30px" '.$tagsApprove.'>
            <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
            <span class="svg-icon svg-icon-2hx svg-icon-success">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
                <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"></path>
              </svg>
            </span>
            <!--end::Svg Icon-->
          </button>
          <button class="btn btn-icon rounded-circle w-30px h-30px" '.$tagsReject.'>
                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                <span class="svg-icon svg-icon-2hx svg-icon-danger">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
                    <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"></rect>
                    <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"></rect>
                </svg>
                </span>
                <!--end::Svg Icon-->
            </button>
            <button class="btn btn-icon rounded-circle w-30px h-30px" data-bs-toggle="modal" id="inspect" data-row-id="'.$row->id."-".$status_id."-".$row->transaction_id.'" data-process-note="'.$row->processNotes.'" data-customer-note="'.$row->customerNotes.'" data-user-name="'.$row->user_name.'" data-customer-deposit="'.$row->deposit.'" data-customer-withdraw="'.$row->withdraw.'" data-customer-vip="'.$row->isVip.'"  data-account-name="'.$row->account_name.'" data-customer-id="'.$row->customer_id.'"data-customer-link="customer/detail/' . $row->customer_id . '/' . $row->site_id . '/' . $row->gamer_site_id . '" data-account-link="account/detail/'.$row->account_id.'/'.$row->account_type.'">
                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                <span class="svg-icon svg-icon-2hx svg-icon-primary">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
                    <rect x="11" y="11" width="2" height="2" rx="1" fill="currentColor"></rect>
                    <rect x="15" y="11" width="2" height="2" rx="1" fill="currentColor"></rect>
                    <rect x="7" y="11" width="2" height="2" rx="1" fill="currentColor"></rect>
                </svg>
                </span>
                <!--end::Svg Icon-->
            </button>
            </div>';
        }
		//************************************************************************************************************************************/
        //$this->db->query("insert into log_query set query=".$this->db->escape(json_encode($_POST["search"]["value"])));
		$data['dataTable']			=$this->TransactionModel->datatable($this->request->getVar('start'),$this->request->getVar('length'), $_POST, $request);
		$data['dataTableNum']		=count((array)$this->TransactionModel->datatable('','',$_POST,$request)->getResult());
		$data['length']				=intval($this->request->getVar('length'));
		$data['start']				=intval($this->request->getVar('start'));
		$data['draw']				=intval($this->request->getVar('draw'));
		$iTotalRecords  = $data['dataTableNum'];
		$iDisplayLength = $data['length'];
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  = $data['start'];
		$sEcho          = $data['draw'];
		$records        = array();
		$records["data"]= array();
		$end            = $iDisplayStart + $iDisplayLength;
		$end            = $end > $iTotalRecords ? $iTotalRecords : $end;
		$i=0;
		foreach($data['dataTable']->getResult() as $row)
		{
            if($row->status=="beklemede")
			{
				$status     = '<div class="text-center badge badge-lg py-2 fs-7 text-gray-800 badge-light-warning"> Pending </div>';
                $status_id  = 1;
			}
			if($row->status=="onaylandı")
			{
				$status     = '<div class="text-center badge py-2 badge-light-success fs-7 px-3">  Approved </div>';
                $status_id  = 2;

			}
            if($row->status=="reddedildi")
			{
				$status     = '<div class="text-center badge py-2 badge-light-danger fs-7 px-3">  Rejected </div>';
                $status_id  = 3;
			}
            if($row->status=="beklemede")
			{
				$datetime1 	= new \DateTime($row->request_time_default);
				$datetime2 	= new \DateTime();
				$interval 	= $datetime1->diff($datetime2);
				$timer 		= "<div class='text-center timer1'>".$interval->format("%I:%S")."</div>";
			}else{
				$datetime1 	= new \DateTime($row->request_time_default);
				$datetime2 	= new \DateTime($row->response_time_default);
				$interval 	= $datetime1->diff($datetime2);
				$timer 		= "<div class='text-center timer2'>".$interval->format("%I:%S")."</div>";
			}

            if($request=="deposit")
            {
                $records["data"][$i] = array
                (
                    "DT_RowId"  => $row->id."-".$status_id."-".$row->transaction_id,
                    '<div class="text-center">' . $row->request_time.($status_id==3?'<inspect class="d-none" data-user-name="'.$row->user_name.'" data-customer-note="'.$row->notes.'"></data>':null) . '</div>',
                    '<div class="text-center">' . $row->transaction_id . '</div>',
                    '<div class="text-center">' . $row->gamer_site_id . '</div>',
                    '<div class="text-center">' . $row->account_id . '</div>',
                    '<div class="text-center">' . $row->site_name . '</div>',
                    '<div class="text-center badge '.($row->method!='bank'?'badge-light-danger':'badge-light-dark').' py-2 fs-7 px-3">'.ucfirst(($row->method=='bank'?'Bank':$row->method)) . '</div>',
                    '<div class="text-center">' . $row->gamer_name . '</div>',
                    '<div class="text-center">' . number_format($row->price,2) . '₺</div>',
                    $status,
                    $timer,
                    process($row->id,$request,$row->status,$row,$status_id)
                );
            }
            if($request=="withdraw")
            {
                $records["data"][$i] = array
                (
                    "DT_RowId"  => $row->id."-".$status_id."-".$row->transaction_id,
                    '<div class="text-center">' . $row->request_time . '</div>',
                    '<div class="text-center">' . $row->transaction_id . '</div>',
                    '<div class="text-center">' . $row->gamer_site_id . '</div>',
                    '<div class="text-center">' . $row->site_name . '</div>',
                    '<div class="text-center">' . $row->gamer_name . '</div>',
                    '<div class="text-center">' . $row->account_id . '</div>',
                    '<div class="text-center">' . number_format($row->price,2) . '₺</div>',
                    $status,
                    $timer,
                    process($row->id,$request,$row->status,$row,$status_id)
                );
            }
		$i++;
		}
	  if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action")
	  {
		$records["customActionStatus"] 	= "OK"; // pass custom message(useful for getting status of group actions)
		$records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
	  }
	  $records["draw"]          	= $sEcho;
	  $records["recordsTotal"] 		= $iTotalRecords;
	  $records["recordsFiltered"] 	= $iTotalRecords;
	  echo json_encode($records);
	}

    public function customerTransactionTable($site_id,$gamer_site_id)
	{
		//************************************************************************************************************************************/
        //$this->db->query("insert into log_query set query=".$this->db->escape(json_encode($_POST["search"]["value"])));
		$data['dataTable']			=$this->TransactionModel->customerTransactionTable($this->request->getVar('start'),$this->request->getVar('length'), $_POST, $site_id, $gamer_site_id);
		$data['dataTableNum']		=count((array)$this->TransactionModel->customerTransactionTable('','',$_POST, $site_id, $gamer_site_id)->getResult());
		$data['length']				=intval($this->request->getVar('length'));
		$data['start']				=intval($this->request->getVar('start'));
		$data['draw']				=intval($this->request->getVar('draw'));
		$iTotalRecords  = $data['dataTableNum'];
		$iDisplayLength = $data['length'];
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  = $data['start'];
		$sEcho          = $data['draw'];
		$records        = array();
		$records["data"]= array();
		$end            = $iDisplayStart + $iDisplayLength;
		$end            = $end > $iTotalRecords ? $iTotalRecords : $end;
		$i=0;
		foreach($data['dataTable']->getResult() as $row)
		{
             if($row->status=="beklemede")
			{
				$status     = '<div class="text-center badge badge-lg py-2 fs-7 text-gray-800 badge-light-warning"> Pending </div>';
                $status_id  = 1;
			}
			if($row->status=="onaylandı")
			{
				$status     = '<div class="text-center badge py-2 badge-light-success fs-7 px-3">  Approved </div>';
                $status_id  = 2;

			}
            if($row->status=="reddedildi")
			{
				$status     = '<div class="text-center badge py-2 badge-light-danger fs-7 px-3">  Rejected </div>';
                $status_id  = 3;
			}

            $records["data"][$i] = array
            (
                "DT_RowId"  => $row->id,
                '<div class="text-center">' . $row->request_time . '</div>',
                '<div class="text-center">' . $row->transaction_id . '</div>',
                '<div class="text-center">' . $row->account_id . '</div>',
                '<div class="text-center badge '.($row->method!='bank'?'badge-light-danger':'badge-light-dark').' py-2 fs-7 px-3">'.ucfirst(($row->method=='bank'?'Bank':$row->method)).'</div>',
                '<div class="text-center">' . number_format($row->price,2) . '₺</div>',
                $status,
                '<button class="btn btn-sm btn-light btn-active-light-primary" data-bs-toggle="modal" id="inspect" data-bs-target="#inspect" data-url="transaction/modal/'.$row->request.'/inspect/'.$id.'">View</button>'
            );
		$i++;
		}
	  if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action")
	  {
		$records["customActionStatus"] 	= "OK"; // pass custom message(useful for getting status of group actions)
		$records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
	  }
	  $records["draw"]          	= $sEcho;
	  $records["recordsTotal"] 		= $iTotalRecords;
	  $records["recordsFiltered"] 	= $iTotalRecords;
	  echo json_encode($records);
	}
}