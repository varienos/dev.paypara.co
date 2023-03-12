<?php

namespace App\Controllers;

class Api extends BaseController
{
    public function __construct()
    {
        helper('app');
        $this->api = new \App\Models\ApiModel();
    }
    public function ipCheckpoint()
    {
        $userIpAddress = getClientIpAddress();
        $allowedAddresses = array_map('trim', explode(',', ipWhitelist()));
        $isAllowed = array_search($userIpAddress, $allowedAddresses) === false && $userIpAddress != $_SERVER['SERVER_ADDR'];

        return $isAllowed ? $this->error->string("not_authorized", __CLASS__, __FUNCTION__) : null;
    }
    public function index()
    {
        $this->response->setStatusCode(444, 'No Response');
    }

    public function tokenStatus($token, $response = 0)
    {
        return $this->response->setJSON(is_array($this->ipCheckpoint())?$this->ipCheckpoint():json_encode($this->api->tokenStatus($token, $response), JSON_NUMERIC_CHECK));
    }

    public function newPayment()
    {
        $response = $this->api->newPayment($_POST);
        return $this->response->setJSON(json_encode($response, JSON_NUMERIC_CHECK));
       //return $this->response->setJSON(is_array($this->ipCheckpoint())?$this->ipCheckpoint():json_encode($response, JSON_NUMERIC_CHECK));
    }

    public function limit()
    {
         return $this->response->setJSON(is_array($this->ipCheckpoint())?$this->ipCheckpoint():$this->api->limit());
    }

    public function isActiveStatus($userId, $site_id)
    {
        return $this->response->setJSON(is_array($this->ipCheckpoint())?$this->ipCheckpoint():json_encode($this->api->isActiveStatus($userId, $site_id)));
    }

    public function approve($apiKey, $requestId)
    {
        return $this->response->setJSON(json_encode($this->api->approve($apiKey, $requestId), JSON_NUMERIC_CHECK));
        //return $this->response->setJSON(is_array($this->ipCheckpoint())?$this->ipCheckpoint():json_encode($this->api->approve($apiKey, $requestId), JSON_NUMERIC_CHECK));
    }

    public function deposit($method = "papara", $status = "beklemede")
    {
        return $this->response->setJSON(json_encode($this->api->deposit($method, $status), JSON_NUMERIC_CHECK));
        //return $this->response->setJSON(is_array($this->ipCheckpoint())?$this->ipCheckpoint():json_encode($this->api->deposit($method, $status), JSON_NUMERIC_CHECK));
    }

    public function withdraw()
    {
        return $this->response->setJSON(is_array($this->ipCheckpoint())?$this->ipCheckpoint():json_encode($this->api->withdraw(), JSON_NUMERIC_CHECK));
    }

    public function status()
    {
        return $this->response->setJSON(is_array($this->ipCheckpoint())?$this->ipCheckpoint():json_encode($this->api->status(), JSON_NUMERIC_CHECK));
    }
}