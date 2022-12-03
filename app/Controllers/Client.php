<?php
namespace App\Controllers;
class Client extends BaseController
{
	public $ClientModel;
    public function __construct()
    {
		$this->ClientModel 	    = new \App\Models\ClientModel();
	}
	public function json()
	{
        $data = $this->db->query("select * from site where isDelete='0' order by site_name asc")->getResult();
        foreach($data as $row)
        {
            if($row->site_name!=""):
                $obj[] = ["id"=>$row->id,"name"=>$row->site_name];
            endif;
        }
        return $this->response->setJSON($obj,JSON_NUMERIC_CHECK);
	}
    public function detail($id)
	{
        $this->SecureModel->stateAuth(view_firm);
        $data = $this->db->query("select * from site where id='".$id."' and isDelete='0'")->getRow();
        return $this->response->setJSON(["id"=>$data->id,"site_name"=>$data->site_name,"api_key_pin"=>$data->api_key_pin,"status"=>$data->status]);
	}
    public function remove($id)
	{
		$this->SecureModel->stateAuth(delete_firm);
		$this->ClientModel->dataRemove($id);
	}
    public function save()
	{
		if($this->request->getVar('id')==0)
		{
			$this->SecureModel->stateAuth(add_firm);
		}else{
			$this->SecureModel->stateAuth(edit_firm);
		}

		$this->ClientModel->dataSave($_POST);
	}
    public function switch($id,$col,$status)
	{
        $this->SecureModel->stateAuth(edit_firm);
		$this->db->query("update site set ".$col."='".$status."' where id='".$id."'");
		$this->db->query("insert into logSys set
		`method`	='client/switch',
		`user_id`	='".$this->session->get('primeId')."',
		`data_id`	='".$id."',
		`dataNew`	=".$this->db->escape($status." - ".$col).",
		`timestamp` =NOW(),
		`ip` 		='".getClientIpAddress()."'
		");
	}
    public function datatable()
	{
        $this->SecureModel->stateAuth(view_firm);
		$data['dataTable']			=$this->ClientModel->datatable($this->request->getVar('start'),$this->request->getVar('length'), $_POST);
		$data['dataTableNum']		=count((array)$this->ClientModel->datatable('','',$_POST)->getResult());
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
            $records["data"][$i] = array
            (
                "DT_RowId"  => $row->id,
                $row->id,
                $row->site_name,
                $row->api_key_pin."-****-****-****-************",
                '<div class="form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid"><input type="checkbox" role="switch" '.(edit_firm!==true?"disabled":null).' id="flexSwitchCheckChecked" data-set="switch" data-id="'.$row->id.'" name="status" class="form-check-input h-20px w-45px" '.$status.'></div>',
                '<button type="button" class="btn btn-sm btn-light btn-active-light-primary" data-bs-toggle="modal" data-bs-target="#clientModalForm" '.(edit_firm!==true?"auth=\"false\"":null).' data-id="'.$row->id.'">Düzenle</button> <button type="button" data-set="remove" data-id="'.$row->id.'" '.(delete_firm!==true?"auth=\"false\"":null).' class="btn btn-sm btn-light btn-active-light-danger text-danger">Sil</button>'
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
