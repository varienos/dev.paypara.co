<?php

namespace App\Models;

use CodeIgniter\Model;

class PayModel extends Model
{
    function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->api = new \App\Models\ApiModel();
        $this->error = new \App\Libraries\Error();
    }

    public function newIframe($token)
    {
        $tokenStatus     = $this->api->tokenStatus($token, 1);
        $tokenData       = $this->db->query("select * from token where token='" . $token . "'")->getRow();
        $apiKey          = $tokenData->apiKey;
        $site_id         = $tokenData->site_id;
        $transactionId   = $tokenData->transactionId;
        $amount          = $tokenData->amount;
        $userId          = $tokenData->userId;
        $userName        = $tokenData->userName;
        $userNick        = $tokenData->userNick;
        $callbackUrl     = $tokenData->callbackUrl;
        $gamerData       = $this->db->query("select deposit, isVip from site_gamer where `gamer_site_id`='" . $userId . "' and site_id='" . $site_id . "'")->getRow();
        $data            = $this->db->query("select * from site where status='on' and api_key='" . md5($apiKey) . "'")->getRow();
        $waitingRequest  = $this->db->query("select * from finance where `gamer_site_id`='" . $userId . "' and `site_id`='" . $data->id . "' and (`status`='beklemede' or `status`='işlemde')")->getRow();
        $transactionData = $this->db->query("select * from finance where `transaction_id`='" . $transactionId . "' and `site_id`='" . $data->id . "'")->getRow();

        $requiredFields = array($apiKey, $data->id, $userId, $userName, $userNick, $callbackUrl, $transactionId);
        if (count(array_filter($requiredFields)) !== count($requiredFields)) {
            $error = $this->error->string("missing_required_field", __CLASS__, __FUNCTION__);
        }

        if ($gamerData->deposit != "on") $error = $this->error->string("user_deposit_disable", __CLASS__, __FUNCTION__);
        if ($tokenData->status == 1) $error = $this->error->string("token_wait_response", __CLASS__, __FUNCTION__);
        if ($tokenData->status == 2) $error = $this->error->string("token_request_finalized", __CLASS__, __FUNCTION__);
        if ($tokenData->status == 3) $error = $this->error->string("token_time_out", __CLASS__, __FUNCTION__);
        if ($tokenData->token != $token) $error = $this->error->string("token_invalid", __CLASS__, __FUNCTION__);

        $limitData = $this->db->query("select limitDepositMin as minDeposit, limitDepositMax as maxDeposit from site where id='" . $tokenData->site_id . "'")->getRow();

        $dataResponse =
            [
                "error"                 => $error == null ? false : json_encode($error, JSON_NUMERIC_CHECK),
                "key"                   => $apiKey,
                "token"                 => $token,
                "tokenStatus"           => $tokenData->status, // 0: işleme hazır, 1: talep alındı, 2: talep sonuçlandırıldı, 3: zaman aşımı
                "transactionStatus"     => $transactionData->status,
                "pendingTransaction"    => $waitingRequest->transaction_id,
                "pending"               => $waitingRequest->transaction_id != "" ? true : false,
                "maintenance"           => (maintenanceStatus == "on" ? true : false),
                "crossSystem"           => crossStatus == "on" && getSettingSiteStatus($site_id, crossStatusSite),
                "virtualPOS"            => posStatus == "on" && getSettingSiteStatus($site_id, posStatusSite),
                "bankTransfer"          => bankStatus == "on" && getSettingSiteStatus($site_id, bankStatusSite),
                "clientName"            => $data->site_name,
                "transactionId"         => $transactionId,
                "amount"                => $amount,
                "userId"                => $userId,
                "userName"              => $userName,
                "userNick"              => $userNick,
                "callback"              => $callbackUrl,
                "depositPerm"           => $gamerData->deposit == "on" ? true : false,
                "minDeposit"            => $limitData->minDeposit,
                "maxDeposit"            => $limitData->maxDeposit,
            ];

        return $dataResponse;
    }

    public function getPaymentData($token)
    {
        // Check and update token status
        $tokenStatus = $this->api->tokenStatus($token, 1);

        // Get all token data
        $tokenData = $this->db->where('token', $token)->get('token')->row();
        $amount = $tokenData->amount;
        $userId = $tokenData->userId;
        $siteId = $tokenData->site_id;
        $userName = $tokenData->userName;
        $callbackUrl = $tokenData->callbackUrl;
        $transactionId = $tokenData->transactionId;

        // Get user deposit permission and VIP status from table
        $this->db->select('deposit, isVip');
        $this->db->where('gamer_site_id', $userId);
        $this->db->where('site_id', $siteId);
        $gamerData = $this->db->get('site_gamer')->row();

        // Find out if the user has any pending transactions
        $this->db->where('gamer_site_id', $userId);
        $this->db->where('site_id', $data->id);
        $this->db->where_in('status', array('beklemede', 'işlemde'));
        $waitingRequest = $this->db->get('finance')->row();

        // Get all the transaction data from table
        $this->db->where('transaction_id', $transactionId);
        $this->db->where('site_id', $data->id);
        $transactionData = $this->db->get('finance')->row();
    }

    public function isMaintenanceMode()
    {
        return maintenanceStatus == "on" ? true : false;
    }

    public function isCrossActive($firmId)
    {
        return crossStatus == "on" && getSettingSiteStatus($firmId, crossStatusSite);
    }

    public function isPosActive($firmId)
    {
        return posStatus == "on" && getSettingSiteStatus($firmId, posStatusSite);
    }

    public function isBankActive($firmId)
    {
        return bankStatus == "on" && getSettingSiteStatus($firmId, bankStatusSite);
    }
}
