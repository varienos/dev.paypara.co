<?php

namespace App\Controllers;

class Dev extends BaseController
{
	public function __construct()
	{
		$this->twoFA = new \App\Libraries\TwoFA();
		$this->session = \Config\Services::session();
		$this->DevModel = new \App\Models\DevModel();
		$this->console = new \App\Libraries\Console();
	}

	public function index()
	{
		if ($this->session->get('root')) return view('dev/modal/index');
	}

	public function string()
	{
		if ($this->session->get('root')) return view('dev/modal/string');
	}

	public function console()
	{
		if ($_GET['action'] == 'clientsCheckSecurityHash') {

			$this->DevModel->clientsCheckSecurityHash();
		} else {
			return $this->console->cmd($this->request->getVar("cmd"));
		}
	}

	public function errorHandler($language)
	{
		$this->DevModel->errorHandler($language, $this->request->getVar());
		echo 'console errors send to developer.';
	}

	public function clientsCheckSecurityHash()
	{
		$this->DevModel->clientsCheckSecurityHash();
	}

	public function clientsCheckHash()
	{
		//if(root==1) $this->DevModel->clientsCheckHash();
	}

	public function phpInfo()
	{
		if ($this->session->get('root')) echo \phpinfo();
	}

	public function twoFA($verifyCode = "")
	{
		if ($this->session->get('2faSecret') == "") {
			$this->session->set('2faSecret', $this->twoFA->createSecret(), 3600);

			return redirect()->to('dev/twoFA');
		} else {
			$secret = $this->session->get('2faSecret');

			echo '2FA SECRET:<br />' . $secret . '<br /><br />';
			echo '3. PARTY QR:<br /><img src="' . $this->twoFA->getQRCodeImageAsDataUri($secret) . '" /><br /><br />';

			if ($verifyCode != "") {
				echo 'verifyCode (' . $verifyCode . '):<br />';
				echo $this->twoFA->verifyCode($secret, $verifyCode);
			}
		}
	}
}