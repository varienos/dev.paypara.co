<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiModel extends Model
{
    protected $table        = "finance";
    protected $site_id      = "";
    protected $minDeposit   = "";
    protected $maxDeposit   = "";
    protected $minWithdraw  = "";
    protected $maxWithdraw  = "";

    function __construct()
    {
        $this->session  = \Config\Services::session();
        $this->db       = \Config\Database::connect();
        $this->settings = new \App\Models\SettingsModel();
        $this->paypara  = new \App\Libraries\Paypara();
        $this->error    = new \App\Libraries\Error();
        $this->request  = \Config\Services::request();
        $this->agent    = $this->request->getUserAgent();
    }

    public function log($site_id, $response, $method)
    {
        $this->db->query("insert into log_api_event set
            `method`        = '" . $method . "',
            `headers`       =  " . $this->db->escape(json_encode(getallheaders(), JSON_UNESCAPED_UNICODE)) . ",
            `request`       =  " . $this->db->escape(json_encode(["POST"=>$_POST,"GET"=>$_GET], JSON_UNESCAPED_UNICODE)) . ",
            `response`      =  " . $this->db->escape(json_encode($response, JSON_UNESCAPED_UNICODE)) . ",
            `site_id`       = '" . $site_id . "',
            `city`          = '" . $this->request->getHeaderLine('Cf-Ipcity') . "',
            `country`       = '" . $this->request->getHeaderLine('Cf-Ipcountry') . "',
            `latitude`      = '" . $this->request->getHeaderLine('Cf-Iplatitude') . "',
            `longitude`     = '" . $this->request->getHeaderLine('Cf-Iplongitude') . "',
            `ip`            = '" . getClientIpAddress() . "',
            `browser`       = '" . $this->agent->getBrowser() . "',
            `agentString`   = '" . $this->agent->getAgentString() . "',
            `platform`      = '" . $this->agent->getPlatform() . "',
            `isMobil`       = '" . $this->agent->getMobile() . "',
            `browserVersion`= '" . $this->agent->getVersion() . "',
            `timestamp`     = NOW()
        ");
    }

    public function newIframe($token)
    {
        $tokenStatus     = $this->tokenStatus($token, 1);
        $tokenData       = $this->db->query("select * from token where token='" . $token . "'")->getRow();
        $apiKey          = $tokenData->apiKey;
        $site_id         = $tokenData->site_id;
        $transactionId   = $tokenData->transactionId;
        $amount          = $tokenData->amount;
        $userId          = $tokenData->userId;
        $userName        = $tokenData->userName;
        $userNick        = $tokenData->userNick;
        $callbackUrl     = $tokenData->callbackUrl;
        $gamerData       = $this->db->query("select deposit,isVip from site_gamer where `gamer_site_id`='" . $userId . "' and site_id='" . $site_id . "'")->getRow();
        $data            = $this->db->query("select * from site where status='on' and api_key='" . md5($apiKey) . "'")->getRow();
        $waitingRequest  = $this->db->query("select * from finance where `gamer_site_id`='" . $userId . "' and `site_id`='" . $data->id . "' and (`status`='beklemede' or `status`='işlemde')")->getRow();
        $transactionData = $this->db->query("select * from finance where `transaction_id`='" . $transactionId . "' and `site_id`='" . $data->id . "'")->getRow();

        if ($apiKey == "") $error = $this->error->string("apikey_required", __CLASS__, __FUNCTION__);
        if ($data->id == "") $error = $this->error->string("apikey_required", __CLASS__, __FUNCTION__);
        if ($gamerData->deposit != "on") $error = $this->error->string("user_deposit_disable", __CLASS__, __FUNCTION__);
        if ($userId == "") $error = $this->error->string("user_id_required", __CLASS__, __FUNCTION__);
        if ($userName == "") $error = $this->error->string("username_required", __CLASS__, __FUNCTION__);
        if ($userNick == "") $error = $this->error->string("usernick_required", __CLASS__, __FUNCTION__);
        if ($callbackUrl == "") $error = $this->error->string("callback_url_required", __CLASS__, __FUNCTION__);
        if ($transactionId == "") $error = $this->error->string("transaction_id_required", __CLASS__, __FUNCTION__);
        if ($tokenData->token == $token && $tokenData->status == 1) $error = $this->error->string("token_wait_response", __CLASS__, __FUNCTION__);
        if ($tokenData->token == $token && $tokenData->status == 2) $error = $this->error->string("token_request_finalized", __CLASS__, __FUNCTION__);
        if ($tokenData->token == $token && $tokenData->status == 3) $error = $this->error->string("token_time_out", __CLASS__, __FUNCTION__);
        if ($tokenData->token != $token) $error = $this->error->string("token_invalid", __CLASS__, __FUNCTION__);

        $limitData = $this->db->query("select limitDepositMin as minDeposit, limitDepositMax as maxDeposit from site where id='" . $tokenData->site_id . "'")->getRow();

        $dataResponse =
            [
                "error"                 =>  json_encode($error, JSON_NUMERIC_CHECK),
                "errorArray"            =>  $error,
                "key"                   =>  $apiKey,
                "token"                 =>  $token,
                "tokenStatus"           =>  $tokenData->status, // 0: işleme hazır / kullanılabilir 1: talep alındı / kullanılamaz 2: talep sonuçlandırıldı / kullanılamaz / 3: zaman aşımı / kullanılamaz
                "tokenStatusDetail"     =>  $tokenStatus,
                "transactionStatus"     =>  $transactionData->status,
                "pendingTransaction"    =>  $waitingRequest->transaction_id,
                "pending"               => ($waitingRequest->transaction_id != "" ? "true" : "false"),
                "maintenance"           => (maintenanceStatus == "on" ? "true" : "false"),
                "crossSystem"           => (crossStatus == "on" && getSettingSiteStatus($site_id, crossStatusSite) == true ? "true" : "false"),
                "virtualPOS"            => (posStatus == "on" && getSettingSiteStatus($site_id, posStatusSite) == true ? "true" : "false"),
                "bankTransfer"          => (bankStatus == "on" && getSettingSiteStatus($site_id, bankStatusSite) == true ? "true" : "false"),
                "clientName"            =>  $data->site_name,
                "transactionId"         =>  $transactionId,
                "amount"                =>  $amount,
                "userId"                =>  $userId,
                "userName"              =>  $userName,
                "userNick"              =>  $userNick,
                "callback"              =>  $callbackUrl,
                "minDeposit"            =>  $limitData->minDeposit,
                "maxDeposit"            =>  $limitData->maxDeposit,
            ];

        $this->log($site_id, $dataResponse, __FUNCTION__);
        return $dataResponse;
    }

    public function tokenStatus($token, $response = 0)
    {
        // 0: işleme hazır / kullanılabilir 1: talep alındı / kullanılamaz 2: talep sonuçlandırıldı / kullanılamaz / 3: zaman aşımı / kullanılamaz
        $tokenData = $this->db->query("select * from token where `token`='" . $token . "'")->getRow();
        @date_default_timezone_set('Europe/Istanbul');
        $start  = strtotime($tokenData->generateTime);
        $end    = strtotime(date('Y-m-d H:i:s'));
        $second = $end - $start;

        if ($second > tokenTimeout) {
            $this->db->query("update token set status='3', timeoutTime=NOW() where `token`='" . $token . "'");
            $tokenData = $this->db->query("select * from token where `token`='" . $token . "'")->getRow();
        }

        $dataSet = ["status" => $tokenData->status, "generateTime" => $tokenData->generateTime, "timeOutValue" => tokenTimeout, "secondLeft" => $second];
        if ($response == 0) {
            return $dataSet;
        } else {
            return $dataSet;
        }
    }

    //IFRAME LİNKİ OLUŞTURUYOR
    public function newPayment($postData)
    {
        if ($this->auth($_POST["apiKey"]) !== true) {
            return $this->auth($_POST["apiKey"]);
            die();
        }

        $apiKey         = trim($postData['apiKey']);
        $transactionId  = $postData['transactionId'];
        $amount         = $postData['amount'];
        $userId         = $postData['userId'];
        $userName       = $postData['userName'];
        $userNick       = $postData['userNick'];
        $callback       = $postData['callback'];

        $transaction = $this->db->query("select * from finance where `transaction_id`='" . $transactionId . "' and status='pre-request' and site_id='" . $this->getSiteId($apiKey) . "'")->getRow();

        // DAHA ÖNCE OLUŞTURULMUŞ TOKEN VE FINANCE VAR İSE SİL
        if ($transaction->token != "") {
            $this->db->query("delete from token where `token`='" . $transaction->token . "'");
            $this->db->query("delete from finance where `transaction_id`='" . $transactionId . "'");
        }

        $dateNow = date('Y-m-d H:i:s');
        $gamerCheck = $this->db->query("select gamer_site_id from site_gamer where `gamer_site_id`='" . $userId . "' and site_id='" . $this->getSiteId($apiKey) . "'");

        if (count((array)$gamerCheck->getResult()) == 0) {
            $this->db->query("insert into site_gamer set
                registerTime    = '" . $dateNow . "',
                updateTime      = '" . $dateNow . "',
                status          = 'on',
                `gamer_site_id` = '" . $userId . "',
                gamer_nick      = '" . $userNick . "',
                gamer_name      = '" . $userName . "',
                site_id         = '" . $this->getSiteId($apiKey) . "',
                withdraw        = 'on',
                deposit         = 'on'
            ");
        }

        $gamerData = $this->db->query("select deposit,isVip from site_gamer where `gamer_site_id`='" . $userId . "' and site_id='" . $this->getSiteId($apiKey) . "'")->getRow();
        $data = $this->db->query("select * from site where status='on' and api_key='" . md5($apiKey) . "'")->getRow();

        if ($apiKey == "")                  $error = $this->error->string("apikey_required", __CLASS__, __FUNCTION__);
        if ($data->id == "")                $error = $this->error->string("apikey_not_valid", __CLASS__, __FUNCTION__);
        if ($gamerData->deposit != "on")    $error = $this->error->string("user_deposit_disable", __CLASS__, __FUNCTION__);
        if ($userId == "")                  $error = $this->error->string("user_id_required", __CLASS__, __FUNCTION__);
        if ($userName == "")                $error = $this->error->string("username_required", __CLASS__, __FUNCTION__);
        if ($userNick == "")                $error = $this->error->string("usernick_required", __CLASS__, __FUNCTION__);
        if ($callback == "")                $error = $this->error->string("callback_url_required", __CLASS__, __FUNCTION__);
        if ($transactionId == "")           $error = $this->error->string("transaction_id_required", __CLASS__, __FUNCTION__);

        if (\is_array($error)) {
            $this->log($this->getSiteId($apiKey), $error, __FUNCTION__);
            return $error;
            die();
        }

        $token = md5($apiKey . microtime()) . md5($apiKey . microtime());
        $this->db->query("
            insert into token set
            apiKey           = '" . $apiKey . "',
            token            = '" . $token . "',
            transactionId    = '" . $transactionId . "',
            amount           = '" . $amount . "',
            userId           = '" . $userId . "',
            userName         = '" . $userName . "',
            userNick         = '" . $userNick . "',
            callbackUrl      = '" . $callback . "',
            site_id          = '" . $this->getSiteId($apiKey) . "',
            generateTime     = '" . $dateNow . "'"
        );

        $link = 'https://pay.paypara.co/papara/';

        if (HOSTNAME == 'api.dev.paypara.co')        $link = 'https://pay.dev.paypara.co/papara/';
        if (HOSTNAME == 'api.dev.paypara.dev')       $link = 'https://pay.dev.paypara.dev/papara/';
        if (HOSTNAME == 'api.dev.paypara.localhost') $link = 'https://pay.dev.paypara.localhost/papara/';
        if ($_SERVER['HTTP_REFERER'] == 'https://demo.paypara.co/') $link = 'https://demo.paypara.co/papara/';

        $this->log($this->getSiteId($apiKey), ["status" => true, "link" => $link . $token], __FUNCTION__);
        return ["status" => true, "link" => $link . $token];
    }

    public function auth($key = "")
    {
        if ($key == "") {
            $this->log($this->getSiteId($key), $this->error->string("apikey_required", __CLASS__, __FUNCTION__), __FUNCTION__);
            return $this->error->string("apikey_required", __CLASS__, __FUNCTION__);
            die();
        }

        $data = $this->db->query("select * from site where status='on' and api_key='" . md5($key) . "'")->getRow();

        if ($data->id == "") {
            $this->log($this->getSiteId($key), $this->error->string("apikey_not_valid", __CLASS__, __FUNCTION__), __FUNCTION__);
            return $this->error->string("apikey_not_valid", __CLASS__, __FUNCTION__);
            die();
        } else {
            $this->site_id = $data->id;

            // SITE LIMITS
            $this->minDeposit  = $data->limitDepositMin < 0 ? $data->limitDepositMin : minDeposit;
            $this->maxDeposit  = $data->limitDepositMax > 0 ? $data->limitDepositMax : maxDeposit;
            $this->minWithdraw = $data->limitWithdrawMin < 0 ? $data->limitWithdrawMin : minWithdraw;
            $this->maxWithdraw = $data->limitWithdrawMax > 0 ? $data->limitWithdrawMax : maxWithdraw;

            // GLOBAL LIMITS
            $this->minDeposit   = $this->minDeposit > minDeposit ? minDeposit : $this->minDeposit;
            $this->maxDeposit   = $this->maxDeposit > maxDeposit ? maxDeposit : $this->maxDeposit;
            $this->minWithdraw  = $this->minWithdraw > minWithdraw ? minWithdraw : $this->minWithdraw;
            $this->maxWithdraw  = $this->maxWithdraw > maxWithdraw ? maxWithdraw : $this->maxWithdraw;

            return true;
        }
    }

    public function limit()
    {
        if ($this->auth($_POST["apiKey"]) !== true) {
            return $this->auth($_POST["apiKey"]);
            die();
        }

        $siteData = $this->db->query("select * from site where status='on' and api_key='" . md5($_POST["apiKey"]) . "'")->getRow();

        $obj["papara"] = array(
            "deposit" => array(
                "limitMin"        => floatval(number_format($this->minDeposit, 2, '.', '')),
                "limitMax"        => floatval(number_format($this->maxDeposit, 2, '.', '')),
            ),
            "withdraw" => array(
                "limitMin"        => floatval(number_format($this->minWithdraw, 2, '.', '')),
                "limitMax"        => floatval(number_format($this->maxWithdraw, 2, '.', ''))
            )
        );

        $this->log($this->getSiteId($_POST["apiKey"]), $obj, __FUNCTION__);
        return $obj;
    }

    public function getSiteId($apiKey)
    {
        $data = $this->db->query("select id,api_key from site where api_key='" . md5(trim($apiKey)) . "'")->getRow();
        return $data->id;
    }

    public function getAccountPrepare($key, $price, $userId, $transaction_id, $method)
    {
        $obj = $this->error->string("account_not_found", __CLASS__, __FUNCTION__);
        if ($this->paypara->setNumber($price) < $this->paypara->setNumber($this->minDeposit)) {
            return $obj = $this->error->string("min_deposit_limit_error", __CLASS__, __FUNCTION__);
        }

        if ($this->paypara->setNumber($price) > $this->paypara->setNumber($this->maxDeposit)) {
            return $obj = $this->error->string("max_deposit_limit_error", __CLASS__, __FUNCTION__);
        }

        if ($method == "bank") {
            if (bankStatus != "on") {
                return $this->error->string("bank_method_disabled", __CLASS__, __FUNCTION__);
            }
            if ($this->paypara->setNumber($price) < $this->paypara->setNumber(bankMinDeposit)) {
                return $this->error->string("min_deposit_limit_bank_error", __CLASS__, __FUNCTION__);
            }
            if ($this->paypara->setNumber($price) > $this->paypara->setNumber(bankMaxDeposit)) {
                return $this->error->string("max_deposit_limit_bank_error", __CLASS__, __FUNCTION__);
            }
        }

        $obj = $this->getAccount($price, $userId, $this->getSiteId($key), $transaction_id, $method);
        return $obj;
    }

    public function getAccount($amount, $userId, $site_id, $transaction_id, $method)
    {
        $getAccountId = $this->paypara->getAccount($amount, $userId, $site_id, $transaction_id, $method);

        if ($getAccountId > 0) {
            $obj["status"] = true;
            $obj["message"] = "success";
            $obj["transactionId"] = $transaction_id;
            $this->db->query("update account set sendTime=NOW() where id='" . $getAccountId . "'");
            $data = $this->paypara->getAccountData($getAccountId);

            $obj["account"] = array(
                "account_id"     =>  $data->id,
                "account_name"   =>  $data->account_name,
                "account_number" =>  $data->account_number
            );

            $obj["account_type"] = $data->dataType;

            if ($data->dataType == 3) $obj["bank_name"] = \bankName($data->bank_id);
        } else {
            $obj["status"]  = false;
            $obj["message"] = "fail";
            $obj["error"]   = $getAccountId . " account not found!";
        }

        return $obj;
    }

    public function isActiveStatus($userId, $site_id)
    {
        $isActiveStatus = $this->db->query("select * from finance where `gamer_site_id`='" . $userId . "' and `site_id`='" . $site_id . "' and (`status`='beklemede' or `status`='işlemde')")->getRow();
        if ($isActiveStatus->id > 0) return  $this->error->string("transaction_unfinished", __CLASS__, __FUNCTION__);
    }

    public function approve($apiKey, $requestId)
    {
        $dataCheck = $this->db->query("select * from finance where `request_id`= '" . $requestId . "' and `site_id`= '" . $this->getSiteId($apiKey) . "'")->getRow();

        if ($dataCheck->id == "") {
            $this->log($this->getSiteId($apiKey), $this->error->string("request_id_not_found", __CLASS__, __FUNCTION__), __FUNCTION__);
            return  $this->error->string("request_id_not_found", __CLASS__, __FUNCTION__);
        }

        $this->db->query("update finance set status='beklemede', `request_time`= NOW(), `update_time`= NOW() where `request_id`= '" . $requestId . "' and `site_id`= '" . $this->getSiteId($apiKey) . "'");
        $this->db->query("update token set `status`= 1 where `token`= '" . $dataCheck->token . "'");
        $this->log($this->getSiteId($apiKey), ["status" => true], __FUNCTION__);

        return ["status" => true];
    }

    public function deposit($method = "papara", $status = "beklemede")
    {
        if ($this->auth($_POST["apiKey"]) !== true) {
            return $this->auth($_POST["apiKey"]);
            die();
        }

        $key            = $_POST['apiKey'];
        $action         = $_POST['action'];
        $userId         = $_POST['userId'];
        $token          = $_POST['token'];
        $userName       = $_POST['userName'];
        $userNick       = $_POST['userNick'];
        $price          = $_POST['amount'];
        $transaction_id = $_POST['transactionId'];
        $callBackUrl    = $_POST['callback'];

        // IFRAME REQUEST
        if ($status == "pre-request" && $action == "reload") {
            $transaction = $this->db->query("select * from finance where `transaction_id`='" . $transaction_id . "' and status='pre-request' and site_id='" . $this->getSiteId($key) . "'")->getRow();
            if ($transaction->token != "") {
                $this->db->query("delete from finance where `transaction_id`='" . $transaction_id . "' and `site_id`='" . $this->site_id . "'");
                $this->db->query("update token set status='0', generateTime=NOW() where `token`='" . $transaction->token . "'");
            }
        }

        $tokenData = $this->db->query("select * from token where `token`='" . $token . "'")->getRow();
        $transactionCheck = $this->db->query("select * from finance where `transaction_id`='" . $transaction_id . "' and `site_id`='" . $this->site_id . "' and `token`='" . $token . "'")->getRow();
        $isActiveStatus = $this->db->query("select * from finance where `gamer_site_id`='" . $userId . "' and `site_id`='" . $this->site_id . "' and (`status`='beklemede' or `status`='işlemde')")->getRow();

        if ($status != "pre-request" && $transactionCheck->id != "")    $error = $this->error->string("transaction_id_exists", __CLASS__, __FUNCTION__);;
        if ($status == "pre-request" && $token == "")                   $error = $this->error->string("token_required", __CLASS__, __FUNCTION__);
        if ($status == "pre-request" && $tokenData->token == "")        $error = $this->error->string("token_invalid", __CLASS__, __FUNCTION__);
        if ($isActiveStatus->id > 0)    $error = $this->error->string("transaction_unfinished", __CLASS__, __FUNCTION__);
        if ($userId == "")              $error = $this->error->string("user_id_required", __CLASS__, __FUNCTION__);
        if ($userName == "")            $error = $this->error->string("username_required", __CLASS__, __FUNCTION__);
        if ($userNick == "")            $error = $this->error->string("usernick_required", __CLASS__, __FUNCTION__);
        if ($callBackUrl == "")         $error = $this->error->string("callback_url_required", __CLASS__, __FUNCTION__);
        if ($transaction_id == "")      $error = $this->error->string("transaction_id_required", __CLASS__, __FUNCTION__);
        if ($price == "")               $error = $this->error->string("amount_required", __CLASS__, __FUNCTION__);

        if (\is_array($error)) {
            $this->log($this->getSiteId($key), $error, __FUNCTION__);
            return $error;
            die();
        }

        $request_id     = md5(microtime() . $transaction_id);
        $gamerCheck     = $this->db->query("select gamer_site_id from site_gamer where `gamer_site_id`='" . $userId . "' and site_id='" . $this->getSiteId($_POST["apiKey"]) . "'");

        if (count((array)$gamerCheck->getResult()) == 0) {
            $this->db->query("insert into site_gamer set
                registerTime    =NOW(),
                updateTime      =NOW(),
                status          ='on',
                `gamer_site_id` ='" . $userId . "',
                gamer_nick      ='" . $userNick . "',
                gamer_name      ='" . $userName . "',
                site_id         ='" . $this->getSiteId($_POST["apiKey"]) . "',
                withdraw        ='on',
                deposit         ='on'
            ");
        }

        $gamerData =  $this->db->query("select deposit,isVip from site_gamer where `gamer_site_id`='" . $userId . "' and site_id='" . $this->getSiteId($_POST["apiKey"]) . "'")->getRow();

        if ($gamerData->deposit != "on") {
            $this->paypara->setLog("setRequestDeposit", mb_strtoupper($userNick, "UTF-8") . " - YATIRIM PASİF OLDUĞU İÇİN YATIRIM HESABI DÖNDÜRÜLMEDİ.", $userId, $this->getSiteId($_POST["apiKey"]), $price, $gamerData->isVip, "", $transaction_id);

            $this->log($this->getSiteId($key), $this->error->string("user_deposit_disabled", __CLASS__, __FUNCTION__), __FUNCTION__);
            return $this->error->string("user_deposit_disabled", __CLASS__, __FUNCTION__);
        }

        $obj = $this->getAccountPrepare($_POST["apiKey"], $price, $userId, $transaction_id, $method);

        switch ($obj["account_type"]) {
            case 1: $method = "papara"; break;
            case 2: $method = "match"; break;
            case 3: $method = "bank"; break;
        }

        $obj["method"] = $method;
        $obj["type"] = $status == "pre-request" ? "pre-request" : "request";

        if ($obj["status"] == true) {
            $this->db->query("insert into finance set
                `gamer_site_id`     = '" . $userId . "',
                `token`             = '" . $token . "',
                `user_name`         = '" . $userName . "',
                `user_nick`         = '" . $userNick . "',
                `transaction_id`    = '" . $transaction_id . "',
                `site_id`           = '" . $this->getSiteId($_POST["apiKey"]) . "',
                `account_id`        = '" . $obj["account"]["account_id"] . "',
                `account_type`      = '" . $obj["account_type"] . "',
                `price`             = '" . $price . "',
                `request`           = 'deposit',
                `method`            = '" . $method . "',
                `status`            = '" . $status . "',
                `callBackUrl`       = '" . $callBackUrl . "',
                `request_id`        = '" . $request_id . "',
                `pre_time`          = NOW(),
                `request_time`      = NOW(),
                `update_time`       = NOW()
			");
            $obj["requestId"]         = $request_id;
        }

        $this->db->query("insert into log_api set
            `method`        = 'setRequestDeposit',
            `dataPost`      = " . $this->db->escape(json_encode($_POST, JSON_UNESCAPED_UNICODE)) . ",
            `dataResponse`  = " . $this->db->escape(json_encode($obj, JSON_UNESCAPED_UNICODE)) . ",
            `dataHeader`    = " . $this->db->escape(json_encode(getallheaders(), JSON_UNESCAPED_UNICODE)) . ",
            `apiKey`        = '" . $key . "',
            `siteId`        = '" . $this->site_id . "',
            `requestTime`   = NOW()
        ");

        unset($obj["account_type"]);
        $this->log($this->getSiteId($key), $obj, __FUNCTION__);

        return $obj;
    }

    public function withdraw()
    {
        if ($this->auth($_POST["apiKey"]) !== true) {
            return $this->auth($_POST["apiKey"]);
            die();
        }

        $key            = $_POST['apiKey'];
        $userId         = $_POST['userId'];
        $userName       = $_POST['userName'];
        $userNick       = $_POST['userNick'];
        $price          = $_POST['amount'];
        $transaction_id = $_POST['transactionId'];
        $account_number = $_POST['account_number'];
        $callBackUrl    = $_POST['callback'];

        if ($this->paypara->setNumber($price) < $this->paypara->setNumber($this->minWithdraw)) {
            $this->log($this->getSiteId($key), $this->error->string("min_withdraw_limit_error", __CLASS__, __FUNCTION__), __FUNCTION__);
            return $this->error->string("min_withdraw_limit_error", __CLASS__, __FUNCTION__);
        }

        if ($this->paypara->setNumber($price) > $this->paypara->setNumber($this->maxDeposit)) {
            $this->log($this->getSiteId($key), $this->error->string("max_withdraw_limit_error", __CLASS__, __FUNCTION__), __FUNCTION__);
            return $this->error->string("max_withdraw_limit_error", __CLASS__, __FUNCTION__);
        }

        $transactionCheck = $this->db->query("select * from finance where `transaction_id`='" . $transaction_id . "' and `site_id`='" . $this->getSiteId($key) . "'")->getRow();
        $isActiveStatus = $this->db->query("select * from finance where `gamer_site_id`='" . $userId . "' and `site_id`='" . $this->getSiteId($key) . "' and (`status`='beklemede' or `status`='işlemde')")->getRow();

        if ($transactionCheck->id != "") $error = $this->error->string("transaction_id_exists", __CLASS__, __FUNCTION__);
        if ($isActiveStatus->id > 0)     $error = $this->error->string("transaction_unfinished", __CLASS__, __FUNCTION__);
        if ($userId == "")               $error = $this->error->string("user_id_required", __CLASS__, __FUNCTION__);
        if ($userName == "")             $error = $this->error->string("username_required", __CLASS__, __FUNCTION__);
        if ($userNick == "")             $error = $this->error->string("usernick_required", __CLASS__, __FUNCTION__);
        if ($callBackUrl == "")          $error = $this->error->string("callback_url_required", __CLASS__, __FUNCTION__);
        if ($transaction_id == "")       $error = $this->error->string("transaction_id_required", __CLASS__, __FUNCTION__);
        if ($price == "")                $error = $this->error->string("amount_required", __CLASS__, __FUNCTION__);
        if ($account_number == "")       $error = $this->error->string("account_number_required", __CLASS__, __FUNCTION__);

        if (\is_array($error)) {
            $this->log($this->getSiteId($key), $error, __FUNCTION__);
            return $error;
            die();
        }

        $request_id     = md5(microtime() . $userName . $price . $key);
        $gamerCheck     = $this->db->query("select gamer_site_id from site_gamer where `gamer_site_id`='" . $userId . "' and site_id='" . $this->getSiteId($_POST["apiKey"]) . "'");

        if (count((array)$gamerCheck->getResult()) == 0) {
            $this->db->query("insert into site_gamer set
                registerTime        =NOW(),
                updateTime			=NOW(),
                status				='on',
                `gamer_site_id` 	='" . $userId . "',
                gamer_nick			='" . $userNick . "',
                gamer_name			='" . $userName . "',
                site_id				='" . $this->getSiteId($_POST["apiKey"]) . "',
                withdraw		    ='on',
                deposit		        ='on'
            ");
            // $this->error->dbException($this->db->error())!=true ? die() : null;
        }

        $gamerData =  $this->db->query("select withdraw,isVip from site_gamer where `gamer_site_id`='" . $userId . "' and site_id='" . $this->getSiteId($_POST["apiKey"]) . "'")->getRow();

        if ($gamerData->withdraw != "on") {
            $this->paypara->setLog("withdraw", mb_strtoupper($userNick, "UTF-8") . " - YATIRIM PASİF OLDUĞU İÇİN YATIRIM HESABI DÖNDÜRÜLMEDİ.", $userId, $this->getSiteId($_POST["apiKey"]), $price, $gamerData->isVip, "", $transaction_id);
            $this->log($this->getSiteId($key), $this->error->string("user_withdraw_disabled", __CLASS__, __FUNCTION__), __FUNCTION__);
            return $this->error->string("user_withdraw_disabled", __CLASS__, __FUNCTION__);
        }

        $this->db->query("insert into finance set
            `gamer_site_id` 		= '" . $userId . "',
            `user_name` 			= '" . $userName . "',
            `user_nick` 			= '" . $userNick . "',
            `transaction_id` 		= '" . $transaction_id . "',
            `site_id` 				= '" . $this->getSiteId($key) . "',
            `price` 				= '" . $price . "',
            `request` 				= 'withdraw',
            `status` 				= 'beklemede',
            `callBackUrl` 			= '" . $callBackUrl . "',
            `request_id`			= '" . $request_id . "',
            `request_time` 			= NOW(),
            `update_time` 			= NOW()
		");

        $this->db->query("insert into finance_user_account set
            `finance_id` 			= '" . $this->db->insertID() . "',
            `account_number`        = '" . $account_number . "'
		");

        $obj = array("status" => true, "message" => "success", "transactionId" => $transaction_id, "requestId" => $request_id);
        $this->log($this->getSiteId($key), $obj, __FUNCTION__);

        return $obj;
    }

    public function status()
    {
        if ($this->auth($_POST["apiKey"]) !== true) {
            return $this->auth($_POST["apiKey"]);
            die();
        }

        $key            = $_POST['apiKey'];
        $transaction_id = $_POST['transactionId'];
        $request_id     = $_POST['requestId'];

        if (empty($transaction_id) && empty($request_id)) {
            return $this->error->string("transaction_id_or_request_id_required", __CLASS__, __FUNCTION__);
        }

        $request = $this->db->query("select * from finance where transaction_id='" . $transaction_id . "' or request_id='" . $request_id . "'")->getRow();

        if($request == null) {
            return $this->error->string("no_transaction_found", __CLASS__, __FUNCTION__);
        }

        $status = $request->status == "onaylandı" ? "success" : "rejected";
        $status = $request->status == "beklemede" ? "processing" : $status;

        if ($request->price_old > 0) {
            $obj = array("status" => true, "transaction" => $status, "message" => $request->notes, "requestAmount" => $request->price_old, "processedAmount" => $request->price, "processTime" => $request->update_time);
        } else {
            $obj = array("status" => true, "transaction" => $status, "message" => $request->notes, "processTime" => $request->update_time);
        }

        $this->log($this->getSiteId($key), $obj, __FUNCTION__);
        return $obj;
    }
}