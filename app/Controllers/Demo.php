<?php

namespace App\Controllers;

class Demo extends BaseController
{
    public function __construct()
    {
        $this->api = new \App\Models\ApiModel();
    }
    public function index()
    {
        return view('demo/index');
    }
    public function papara($token)
    {
        return view('demo/iframe', $this->api->newIframe($token));
    }
}