<?php

namespace App\Controllers;

class Boot extends BaseController
{
    public function index()
    {
        if ($this->SecureModel->security()) 
        {
            return redirect()->to(base_url('dashboard'));
        }
        $this->response->setStatusCode(444, 'No Response'); 
    }
}
