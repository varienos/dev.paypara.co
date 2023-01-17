<?php

namespace App\Controllers;

class Secure extends BaseController
{
    public function index()
    {
    }

    public function twoFa($stage = null, $code = null)
    {
        if ($code == null && $stage == null) {
            echo view('app/auth/2fa');
        } elseif ($stage == 'verify') {

            $this->twoFA     = new \App\Libraries\TwoFA();
            //$this->verify    = $this->twoFA->getCode($code);
            if ($this->twoFA->verifyCode((!empty($this->request->getVar('secret')) ? $this->request->getVar('secret') : $this->session->get('secret2fa')), $code)) {
                $this->session->set('verify2fa', true, $this->SecureModel->sessionTimeout());
                $this->response->setStatusCode(200, 'OK');
            } else {
                $this->response->setStatusCode(401, $this->twoFA->ensureCorrectTime());
            }
        } elseif ($stage == 'setup') {

            if ($this->SecureModel->setup2fa($this->request->getVar('secret'))) {
                $this->response->setStatusCode(200, 'OK');
            } else {
                $this->response->setStatusCode(401, 'Unauthorized');
            }
        } elseif ($stage == 'disable') {

            if ($this->SecureModel->disable2fa($this->request->getVar('user_id'))) {
                $this->response->setStatusCode(200, 'OK');
            } else {
                $this->response->setStatusCode(401, 'Unauthorized');
            }
        }
    }

    public function signout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('secure/login'));
    }
    public function authentication()
    {
        $process  = json_decode($this->SecureModel->auth());

        if ($process->status == true && $process->is2fa != 'on') {
            return redirect()->to(base_url('dashboard'));
        } elseif ($process->status == true && $process->is2fa == 'on') {

            return redirect()->to(base_url('secure/2fa'));
        } else {

            return redirect()->to(base_url('secure/login?s=noAuth'));
        }
    }
    public function login()
    {
        if ($this->SecureModel->security()) {
            return redirect()->to(base_url('dashboard'));
        }
        echo view('app/auth/login');
    }
}