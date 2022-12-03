<?php
namespace App\Controllers;
class Pay extends BaseController
{
    public function __construct()
    {
        $this->api = new \App\Models\ApiModel();
	}
    public function papara($token)
    {
        return htmlMinify(view('pay/iframe',$this->api->newIframe($token)));
    }
}
