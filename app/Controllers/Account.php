<?php
namespace App\Controllers;
class Account extends BaseController
{
    public function __construct()
    {
		$this->AccountModel 	= new \App\Models\AccountModel();
        $this->ClientModel 	    = new \App\Models\ClientModel();
	}
	public function delete($id)
	{
		$this->AccountModel->deleteAccount($id);
	}
    public function removeMatch($id)
	{
		$this->db->query("update site_gamer_match set isDelete=1, delete_time=NOW() where id='".$id."'");
	}
	public function include($fileName)
	{
		echo (htmlMinify(view('app/account/include/'.$fileName)));
	}
	public function status($id,$status,$type=0)
	{
		$this->db->query("update account set status='".$status."' where ".( $type!=0 ? "  dataType='".$type."' " : null ).($id>0 && $type!=0 ? " and " : null ).( $id>0 ? " id='".$id."'" : null ));
		$this->db->query("insert into logSys set
		`method`	='status()',
		`user_id`	='".$this->session->get('primeId')."',
		`data_id`	='".$id."',
		`dataNew`	=".$this->db->escape($status).",
		`timestamp` =NOW(),
		`ip` 		='".getClientIpAddress()."'
		");
	}
	public function index($type=1)
	{
        if($type==1||$type==2) $this->SecureModel->stateAuth(view_papara_account);
        if($type==3) $this->SecureModel->stateAuth(view_bank_account);
        $data["type"]= $type;
		echo (htmlMinify(view('app/account/index',$data)));
	}
    public function listMatchQuery($account_id)
    {
        return $this->db->query("
        select *,
        site_gamer_match.id as id,
        @account_id     :=  account_id,
        @lastProcess    := (select DATE_FORMAT(update_time,'%d.%m.%y %H:%i:%s') from finance where account_id=@account_id order by update_time desc limit 1 ) as lastProcess
        from site_gamer_match
        inner join site_gamer on site_gamer.gamer_site_id=site_gamer_match.gamer_site_id
        inner join site on site.id=site_gamer.site_id
        where site_gamer_match.account_id='".$account_id."' and site_gamer_match.isDelete=0")->getResult();
    }
    public function listMatch($account_id)
    {
        $listMatch= $this->listMatchQuery($account_id);
     if(count((array)$listMatch)>0)
     {
            foreach($listMatch as $row)
            {
            echo '<tr>
                <td>
                    <a class="text-gray-800 fs-5 fw-bold">'.$row->gamer_site_id.'</a>
                </td>
                <td><a class="text-gray-800 fs-5 fw-bold">'.$row->gamer_name.'</a><div class="fw-semibold fs-7">'.$row->gamer_nick.'</div></td>
                <td>'.$row->site_name.'</td>
                <td>'.(getCustomerTotalProcessWithAccount($row->gamer_site_id,$account_id)=="0" ? "none" : getCustomerTotalProcessWithAccount($row->gamer_site_id,$account_id)." tx").' </td>
                <td>₺'.number_format(getCustomerTotalDepositWithAccount($row->gamer_site_id,$account_id),2).'</td>
                <td>'.($row->lastProcess=="" ? "none" : $row->lastProcess).'</td>
                <td class="text-end"><button class="btn btn-sm btn-light-danger" onClick="$.varien.account.detail.removeMatch('.$row->id.')">Remove</button>
                </td></tr>';
            }
        }else{
            echo '<tr>
            <td class="dataTables_empty text-center" colspan="7">
            No records
        </td>
                </tr>';
         }
    }
    public function match($account_id)
	{
        $gamer_site_id  = $_POST["customer_id"];
        $isDelete       = $this->db->query("select * from site_gamer_match where gamer_site_id='".$gamer_site_id."' and account_id='".$account_id."'")->getResult();
        if(count((array)$isDelete)>0)
		{
            $this->db->query("update site_gamer_match set isDelete=0 where gamer_site_id='".$gamer_site_id."' and account_id='".$account_id."'");
        }else{
            $this->db->query("insert into site_gamer_match set gamer_site_id='".$gamer_site_id."', account_id='".$account_id."', match_time=NOW(), user_id='".primeId."'");
        }
	}
    public function accountTotalMatch($account_id)
	{
        header("Content-type: application/json");
        echo json_encode(array("total"=>$this->paypara->accountTotalMatch($account_id)));
	}
    public function customerQuery()
	{
        $postData=["filter_name"=>$_POST["s"]];
		$search = $this->db->query("select *,site_gamer.id as id from site_gamer
		inner join site on site.id=site_gamer.site_id
		where site_gamer.id<>0 and (gamer_nick LIKE '%".$postData["filter_name"]."%' or gamer_name LIKE '%".$postData["filter_name"]."%') order by site_gamer.id desc limit 5")->getResult();
		if(count((array)$search)>0)
		{
			foreach ($search as $row)
			{
                $match = $this->db->query("select * from site_gamer_match where gamer_site_id='".$row->gamer_site_id."' and account_id='".$_POST["account_id"]."' and isDelete=0")->getResult();
				if(count((array)$match)==0) echo '<li onClick="$.varien.account.detail.match('.$row->gamer_site_id.')"><i style="color:#bbb" class="fa fa-user fs-6 me-1"></i> '.$row->gamer_nick.' '.$row->site_name.'</li>';
			}
		}else{
			echo '<li>No Customer Found...</li>';
		}
	}
    public function form($type,$id=0)
	{
		if($id==0)
		{
			if($type==1||$type==2) $this->SecureModel->stateAuth(add_papara_account);
			if($type==3) $this->SecureModel->stateAuth(add_bank_account);
		}else{
			if($type==1||$type==2) $this->SecureModel->stateAuth(edit_paparak_account);
			if($type==3) $this->SecureModel->stateAuth(add_bank_account);
		}
		$data["id"]						= $id;
        $data["type"]					= $type;
		$data["siteSelect"]				= $this->ClientModel->clients();
		if($id>0) $data['update']       = $this->db->query("select * from account where id='".$id."'")->getRow();
		echo (htmlMinify(view('app/account/form',$data)));
	}
    public function detail($id=0,$type)
	{
        if($type==1||$type==2) $this->SecureModel->stateAuth(edit_papara_account);
        if($type==3) $this->SecureModel->stateAuth(edit_bank_account);
		$data["id"]						= $id;
		$data["siteSelect"]				= $this->ClientModel->clients();
        $data["listMatch"]			    = $this->listMatchQuery($id);
		$data['update']= $this->db->query("
        select
        *,
        DATE_FORMAT(createTime,'%d.%m.%y %H:%i:%s') as 'createTime',
        @id :=  id,
        @totalCustomer  := (select COUNT(id) as totalCustomer from finance where request='deposit' and `status`='onaylandı' and account_id=@id) as totalCustomer,
        @totalProcess   := (select COUNT(id) as totalProcess from finance where request='deposit' and `status`='onaylandı' and account_id=@id) as totalProcess,
        @totalDeposit   := (select SUM(price) as totalDeposit from finance where request='deposit' and `status`='onaylandı' and account_id=@id) as totalDeposit,
        @totalMatch     := (select COUNT(id) as totalMatch from site_gamer_match where isDelete=0 and account_id=@id) as totalMatch,
        @lastProcess    := (select DATE_FORMAT(update_time,'%d.%m.%y %H:%i:%s') from finance where account_id=@id order by update_time desc limit 1 ) as lastProcess,
        @firstProcess   := (select DATE_FORMAT(update_time,'%d.%m.%y %H:%i:%s') from finance where account_id=@id order by update_time asc limit 1 ) as firstProcess
        from account
        where account.id='".$id."'")->getRow();
		echo (htmlMinify(view('app/account/detail',$data)));
	}
	public function save()
	{
		$this->AccountModel->saveData($this->request->getVar());
	}
	public function datatable($dataType)
	{
    if($dataType==1||$dataType==2) $this->SecureModel->stateAuth(view_papara_account);
    if($dataType==3) $this->SecureModel->stateAuth(view_bank_account);
		$data['dataTable']			=$this->AccountModel->datatable($this->request->getVar('start'),$this->request->getVar('length'), $_POST, $dataType);
		$data['dataTableNum']		=count((array)$this->AccountModel->datatable('','',$_POST,$dataType)->getResult());
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
			$status = $row->status=="on" ? "checked" : null;
            if($row->dataType==2)
            {
                $records["data"][$i] = array
                (
                    "DT_RowId"  => $row->id,
                    '<div class="text-center">' . $row->id . '</div>',
										'<div class="text-start">' . $row->account_name . '</div>',
                    '<div class="text-center">' . $row->account_number . '</div>',
                    '<div class="badge badge-square badge-secondary '.($row->totalMatch>=$row->match_limit ? 'badge-danger' : null).' fs-7">'.$row->totalMatch.'</div>',
                    ( $row->totalProcess==0 ? '<div class="text-center">none</div>' : '<div class="text-center">' . $row->totalProcess . "</div>" ),
                    ( $row->lastProcess=="" ? '<div class="text-center">none</div>' : '<div class="text-center">' . $row->lastProcess . "</div>" ),
                    '<div class="flex-center form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid"><input type="checkbox" role="switch" '.(edit_papara_account!==true?"disabled":null).' id="flexSwitchCheckChecked" data-set="index" data-id="'.$row->id.'" name="status" class="form-check-input h-20px w-45px" '.$status.'></div>',
                    '<button onclick="location.href= \'account/detail/'.$row->id.'/'.$row->dataType.'\'" '.(edit_papara_account!==true?"auth=\"false\"":null).' class="btn btn-sm btn-light btn-active-light-primary">Details</button> <button delete-url="account/delete/'.$row->id.'" '.(delete_papara_account!==true?"auth=\"false\"":null).' data-set="delete" class="btn btn-sm btn-light btn-active-light-danger text-danger">Delete</button>'
                );
            }elseif($row->dataType==1){
                $records["data"][$i] = array
                (
                    "DT_RowId"  => $row->id,
                    '<div class="text-center">' . $row->id . '</div>',
                    '<div class="text-start">' . $row->account_name . '</div>',
                    '<div class="text-center">' . $row->account_number . '</div>',
                    ( $row->totalProcess==0 ? '<div class="text-center">none</div>' : '<div class="text-center">' . $row->totalProcess . "</div>" ),
                    ( $row->lastProcess=="" ? '<div class="text-center">none</div>' : '<div class="text-center">' . $row->lastProcess . "</div>" ),
                    '<div class="flex-center form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid"><input type="checkbox" role="switch" id="flexSwitchCheckChecked" '.(edit_papara_account!==true?"disabled":null).' data-set="index" data-id="'.$row->id.'" name="status" class="form-check-input h-20px w-45px" '.$status.'></div>',
                    '<button onclick="location.href= \'account/detail/'.$row->id.'/'.$row->dataType.'\'" '.(edit_papara_account!==true?"auth=\"false\"":null).' class="btn btn-sm btn-light btn-active-light-primary">Details</button> <button delete-url="account/delete/'.$row->id.'" data-set="delete" '.(delete_papara_account!==true?"auth=\"false\"":null).' class="btn btn-sm btn-light btn-active-light-danger text-danger">Delete</button>'
                );
            }elseif($row->dataType==3){
                $records["data"][$i] = array
                (
                    "DT_RowId"  => $row->id,
                    '<div class="text-center">' . $row->id . '</div>',
                    '<div class="text-start">' . $row->account_name . '</div>',
										bankName($row->bank_id),
                    '<div class="text-center">' . $row->account_number . '</div>',
                    ( $row->totalProcess==0 ? '<div class="text-center">none</div>' : '<div class="text-center">' . $row->totalProcess . "</div>" ),
                    ( $row->lastProcess=="" ? '<div class="text-center">none</div>' : '<div class="text-center">' . $row->lastProcess . "</div>" ),
                    '<div class="flex-center form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid"><input type="checkbox" role="switch" id="flexSwitchCheckChecked" '.(edit_bank_account!==true?"disabled":null).' data-set="index" data-id="'.$row->id.'" name="status" class="form-check-input h-20px w-45px" '.$status.'></div>',
                    '<button onclick="location.href= \'account/detail/'.$row->id.'/'.$row->dataType.'\'" '.(edit_bank_account!==true?"auth=\"false\"":null).' class="btn btn-sm btn-light btn-active-light-primary">Details</button> <button delete-url="account/delete/'.$row->id.'" '.(delete_bank_account!==true?"auth=\"false\"":null).' data-set="delete" class="btn btn-sm btn-light btn-active-light-danger text-danger">Delete</button>'
                );
            }
		$i++;
		}
	  if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action")
	  {
		$records["customActionStatus"] 	= "OK";
		$records["customActionMessage"] = "Group action successfully has been completed. Well done!";
	  }
	  $records["draw"]          	= $sEcho;
	  $records["recordsTotal"] 		= $iTotalRecords;
	  $records["recordsFiltered"] 	= $iTotalRecords;
	  echo json_encode($records);
	}
    public function listDisableMatch($account_id)
	{
         $postData = $_POST;
         $orderCol = $postData["order"][0]["column"];
         $orderDir = $postData["order"][0]["dir"];
         if($orderDir=="")$orderDir ="desc"; else $orderDir=$orderDir;
         if($orderCol=="")$orderCol ="site_gamer_match.id";
         if($orderCol==0) $orderCol ="site_gamer_match.id";
         if(!empty($this->request->getVar('length'))) $limit  = "limit ".$this->request->getVar('start').", ".$this->request->getVar('length');
        $listMatch= $this->db->query("
        select *,
        @account_id     :=  site_gamer_match.account_id,
        @lastProcess    := (select DATE_FORMAT(update_time,'%d.%m.%y %H:%i:%s') from finance where account_id=@account_id order by update_time desc limit 1 ) as lastProcess
        from site_gamer_match
        inner join site_gamer on site_gamer.gamer_site_id=site_gamer_match.gamer_site_id
        inner join site on site.id=site_gamer.site_id
        where site_gamer_match.account_id='".$account_id."' and site_gamer_match.isDelete=1 order by ".$orderCol." ".$orderDir." ".$limit)->getResult();
		$data['dataTable']			= $listMatch;
		$data['dataTableNum']		=count((array)$listMatch);
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
		foreach($data['dataTable'] as $row)
		{
            $records["data"][$i] = array
            (
                "DT_RowId"  => $row->id,
                '<a>'.$row->gamer_site_id.'</a>',
                '<a class="text-gray-800 fs-5 fw-bold">'.$row->gamer_name.'</a><div class="fw-semibold fs-7">'.$row->gamer_nick.'</div>',
                $row->site_name,
                (getCustomerTotalProcessWithAccount($row->gamer_site_id,$account_id)=="0" ? "none" : getCustomerTotalProcessWithAccount($row->gamer_site_id,$account_id)." tx"),
                '₺'.number_format(getCustomerTotalDepositWithAccount($row->gamer_site_id,$account_id),2),
                ($row->lastProcess=="" ? "none" : $row->lastProcess)
            );
		$i++;
		}
	  if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action")
	  {
		$records["customActionStatus"] 	= "OK";
		$records["customActionMessage"] = "Group action successfully has been completed. Well done!";
	  }
	  $records["draw"]          	= $sEcho;
	  $records["recordsTotal"] 		= $iTotalRecords;
	  $records["recordsFiltered"] 	= $iTotalRecords;
	  echo json_encode($records);
	}
    public function transaction($account_id)
	{
		$data['dataTable']			=$this->AccountModel->transaction($this->request->getVar('start'),$this->request->getVar('length'), $_POST, $account_id);
		$data['dataTableNum']		=count((array)$this->AccountModel->transaction('','',$_POST, $account_id)->getResult());
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
				$status = '<div class="badge badge-lg fs-7 text-gray-800 badge-light-warning"> Pending </div>';
			}
			if($row->status=="işlemde")
			{
				$status = '<div class=""> Processing </div>';
			}
			if($row->status=="onaylandı")
			{
				$status = '<div class="badge badge-light-success fs-7 px-3">  Approved </div>';
			}
            if($row->status=="reddedildi")
			{
				$status = '<div class="badge badge-light-danger fs-7 px-3">  Rejected </div>';
			}
            $records["data"][$i] = array
                (
                    "DT_RowId"  => $row->id,
                    $row->update_time,
                    $row->transaction_id,
                    $row->gamer_site_id,
                    $row->site_name,
                    $row->gamer_name,
                    number_format($row->price,2),
                    $status
                );
		$i++;
		}
	  if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action")
	  {
		$records["customActionStatus"] 	= "OK";
		$records["customActionMessage"] = "Group action successfully has been completed. Well done!";
	  }
	  $records["draw"]          	= $sEcho;
	  $records["recordsTotal"] 		= $iTotalRecords;
	  $records["recordsFiltered"] 	= $iTotalRecords;
	  echo json_encode($records);
	}
}
