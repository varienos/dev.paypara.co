<?php

namespace App\Controllers;

class User extends BaseController
{
	public function __construct()
	{
		$this->UserModel 	    = new \App\Models\UserModel();
		$this->ClientModel 	    = new \App\Models\ClientModel();
		$this->secure 	        = new \App\Models\SecureModel();
	}
	public function save()
	{
		$this->SecureModel->stateAuth(add_user);
		$this->UserModel->saveData($this->request->getVar());
	}
	public function saveRole()
	{
		if ($this->request->getVar('id') == 0) {
			$this->SecureModel->stateAuth(add_role);
		} else {
			$this->SecureModel->stateAuth(edit_role);
		}
		$this->UserModel->saveRole($this->request->getVar());
	}
	public function removeRole($id)
	{
		$this->SecureModel->stateAuth(delete_role);
		$this->db->query("delete from user_role where id=" . $id);
	}
	public function remove($id)
	{
		$this->SecureModel->stateAuth(delete_user);
		$this->db->query("update user set isDelete='1' where hash_id='" . $id . "'");
	}
	public function update($id)
	{
		if ($id == 0) {
			$this->SecureModel->stateAuth(add_user);
		} else {
			if (hashId != $id) $this->SecureModel->stateAuth(edit_user);
		}
		$this->UserModel->updateData($id, $this->request->getVar());
	}
	public function switch($id, $col, $status)
	{
		$this->db->query("update user set " . $col . "='" . $status . "' where hash_id='" . $id . "'");
		$this->db->query("insert into logSys set
		`method`	='user/switch',
		`user_id`	='" . $this->session->get('primeId') . "',
		`data_id`	='" . $id . "',
		`dataNew`	=" . $this->db->escape($status . " - " . $col) . ",
		`timestamp` =NOW(),
		`ip` 		='" . getClientIpAddress() . "'
		");
	}
	public function index()
	{
		$this->SecureModel->stateAuth(view_user);
		echo htmlMinify(view('app/user/index'));
	}
	public function check()
	{
		echo count((array)$this->UserModel->check($this->request->getVar("param"), $this->request->getVar("value"), $this->request->getVar("current")));
	}
	public function roles()
	{
		echo view('app/user/roles');
	}
	public function detail($id)
	{
		if ($id != hashId) $this->SecureModel->stateAuth(view_user);
		$data["user"] = $this->UserModel->detail($id)->getRow();
		$data["siteSelect"] = $this->ClientModel->clients();
		echo view('app/user/detail', $data);
	}
	public function activity()
	{
		$this->UserModel->activity();
	}
	public function modal()
	{
		$this->SecureModel->stateAuth(add_user);
		$data["siteSelect"] = $this->ClientModel->clients();
		echo view('app/user/modal/user', $data);
	}
	public function role($id)
	{
		if ($id == 0) {
			$this->SecureModel->stateAuth(add_role);
		} else {
			$this->SecureModel->stateAuth(edit_role);
		}
		$data["role"] = $id > 0 ? $this->UserModel->role($id)->getRow() : null;
		echo view('app/user/modal/role', $data);
	}
	public function twoFa()
	{
		// https://github.com/RobThree/TwoFactorAuth/blob/master/demo/demo.php
		$this->twoFA    	= new \App\Libraries\TwoFA();
		$data['secret'] 	= $this->twoFA->createSecret();
		$data['qr'] 		= $this->twoFA->getQRCodeImageAsDataUri($data['secret']);
		$data['manuel'] 	= chunk_split($data['secret'], 4, ' ');
		echo view('app/user/modal/2fa', $data);
	}
	public function include($fileName)
	{
		echo view('app/user/include/' . $fileName);
	}
	public function datatable()
	{
		$this->SecureModel->stateAuth(view_user);
		$data['dataTable']			= $this->UserModel->datatable($this->request->getVar('start'), $this->request->getVar('length'), $_POST);
		$data['dataTableNum']		= count((array)$this->UserModel->datatable('', '', $_POST)->getResult());
		$data['length']				= intval($this->request->getVar('length'));
		$data['start']				= intval($this->request->getVar('start'));
		$data['draw']				= intval($this->request->getVar('draw'));
		$iTotalRecords  = $data['dataTableNum'];
		$iDisplayLength = $data['length'];
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  = $data['start'];
		$sEcho          = $data['draw'];
		$records        = array();
		$records["data"] = array();
		$end            = $iDisplayStart + $iDisplayLength;
		$end            = $end > $iTotalRecords ? $iTotalRecords : $end;
		$i = 0;
		foreach ($data['dataTable']->getResult() as $row) {
			$records["data"][$i] = array(
				"DT_RowId"  => $row->hash_id,
				'<div class="symbol symbol-circle symbol-40px overflow-hidden me-3">
                <a href="#">
                  <div class="symbol-label fs-4 bg-light-danger text-danger">' . userNameShort($row->user_name) . '</div>
                </a>
              </div>
              <div class="d-flex flex-column">
                  <a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">' . $row->user_name . '</a>
                </div>',
				getRoleName($row->role_id),
				'<div class="badge badge-light fw-bold">' . ($row->user_last_login == "" ? "Giriş Yapmadı" : $row->user_last_login) . '</div>',
				($row->is2fa == "on" ? '<div class="badge badge-light-success fw-bold">Açık</div>' : '<div class="badge badge-light-danger fw-bold">Kapalı</div>'),
				$row->user_create_time,
				'<button onclick="location.href=\'user/detail/' . $row->hash_id . '\'" class="btn btn-sm btn-light btn-active-light-primary">Görüntüle</button> <button ' . (delete_user !== true ? "auth=\"false\"" : null) . ' data-set="remove" data-id="' . $row->hash_id . '" class="btn btn-sm btn-light-danger">Sil</button>'
			);
			$i++;
		}
		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			$records["customActionStatus"] 	= "OK"; // pass custom message(useful for getting status of group actions)
			$records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
		}
		$records["draw"]          	= $sEcho;
		$records["recordsTotal"] 		= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
	}
	public function sessiontable($userId)
	{
		$data['dataTable']			= $this->UserModel->sessiontable($this->request->getVar('start'), $this->request->getVar('length'), $_POST, $userId);
		$data['dataTableNum']		= count((array)$this->UserModel->sessiontable('', '', $_POST, $userId)->getResult());
		$data['length']				= intval($this->request->getVar('length'));
		$data['start']				= intval($this->request->getVar('start'));
		$data['draw']				= intval($this->request->getVar('draw'));
		$iTotalRecords  = $data['dataTableNum'];
		$iDisplayLength = $data['length'];
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  = $data['start'];
		$sEcho          = $data['draw'];
		$records        = array();
		$records["data"] = array();
		$end            = $iDisplayStart + $iDisplayLength;
		$end            = $end > $iTotalRecords ? $iTotalRecords : $end;
		$i = 0;
		foreach ($data['dataTable']->getResult() as $row) {
			@date_default_timezone_set('Europe/Istanbul');
			$start  = strtotime($row->lastActivitiy);
			$end    = strtotime(date('Y-m-d H:i:s'));
			$second = $end - $start;
			if ($second < $this->secure->sessionTimeout()) {
				$ses = "<span class='text-success'>Aktif oturum</span>";
			} else {
				$ses = "<span class='text-danger'>Süresi doldu</span>";
			}
			$v = explode(".", $row->browserVersion);
			$records["data"][$i] = array(
				"DT_RowId"  => $row->id,
				$row->country . "/" . $row->city,
				$row->browser . " <div style='font-size:10px'>" . $v[0] . " - " . $row->platform . "</div>",
				$row->ip,
				$row->lastActivitiyFix,
				$ses
			);
			$i++;
		}
		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			$records["customActionStatus"] 	= "OK"; // pass custom message(useful for getting status of group actions)
			$records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
		}
		$records["draw"]          	= $sEcho;
		$records["recordsTotal"] 		= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
	}
	public function datatableRole()
	{
		$this->SecureModel->stateAuth(view_role);
		$data['dataTable']			= $this->UserModel->datatableRole($this->request->getVar('start'), $this->request->getVar('length'), $_POST);
		$data['dataTableNum']		= count((array)$this->UserModel->datatableRole('', '', $_POST)->getResult());
		$data['length']				= intval($this->request->getVar('length'));
		$data['start']				= intval($this->request->getVar('start'));
		$data['draw']				= intval($this->request->getVar('draw'));
		$iTotalRecords  = $data['dataTableNum'];
		$iDisplayLength = $data['length'];
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  = $data['start'];
		$sEcho          = $data['draw'];
		$records        = array();
		$records["data"] = array();
		$end            = $iDisplayStart + $iDisplayLength;
		$end            = $end > $iTotalRecords ? $iTotalRecords : $end;
		$i = 0;
		foreach ($data['dataTable']->getResult() as $row) {
			$records["data"][$i] = array(
				"DT_RowId"  => $row->id,
				$row->name,
				($row->totalUser > 0 ? $row->totalUser . " kişi" : "- yok -"),
				'<button type="button" class="btn btn-sm btn-light btn-active-light-primary me-3" id="formAjax" data-bs-toggle="modal" data-bs-target="#ajaxModal" data-url="user/role/' . $row->id . '">Düzenle</a><button data-set="remove" data-id="' . $row->id . '" class="btn btn-sm btn-light btn-active-light-danger text-danger">Sil</button>'
			);
			$i++;
		}
		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			$records["customActionStatus"] 	= "OK"; // pass custom message(useful for getting status of group actions)
			$records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
		}
		$records["draw"]          	= $sEcho;
		$records["recordsTotal"] 		= $iTotalRecords;
		$records["recordsFiltered"] 	= $iTotalRecords;
		echo json_encode($records);
	}
}
