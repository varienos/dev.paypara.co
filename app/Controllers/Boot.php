<?php

namespace App\Controllers;

class Boot extends BaseController
{
    public function index()
    {
        $this->response->setStatusCode(444, 'No Response');
    }
}
