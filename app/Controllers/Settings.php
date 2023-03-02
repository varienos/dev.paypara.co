<?php

namespace App\Controllers;

class Settings extends BaseController
{
	public function index()
	{
		if (view_firm !== true) $this->SecureModel->stateAuth(view_settings);

		$data['clientSelect'] = $this->settings->clientSelect();
		$data["settings"] = $this->db->query("select * from settings")->getResult();

		return htmlMinify(view('app/settings/settings', $data));
	}

	public function update()
	{
		$this->SecureModel->stateAuth(edit_settings);
		return $this->settings->dataUpdate($this->request->getVar());
	}

	public function api($method)
	{
		$this->SecureModel->stateAuth(edit_settings);
		return $this->settings->$method($this->request->getVar());
	}
}