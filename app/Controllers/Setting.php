<?php

namespace App\Controllers;

class Setting extends BaseController
{
	public function index()
	{
		if (view_firm !== true) $this->SecureModel->stateAuth(view_setting);

		$data["setting"]        = $this->db->query("select * from setting")->getResult();
		$data['clientSelect']   = $this->setting->clientSelect();
		return htmlMinify(view('app/setting', $data));
	}
	public function update()
	{
		$this->SecureModel->stateAuth(edit_setting);
		return $this->setting->dataUpdate($this->request->getVar());
	}
}