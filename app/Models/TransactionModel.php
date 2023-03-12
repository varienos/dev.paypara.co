<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    function __construct()
    {
        $this->session  = \Config\Services::session();
        $this->db       = \Config\Database::connect();
        $this->settings = new \App\Models\SettingsModel();
        $this->paypara  = new \App\Libraries\Paypara();
        $this->error    = new \App\Libraries\Error();
    }

    public function detail($id)
    {
        $x = $this->db->query("
            select
            CASE
                WHEN account.dataType = 1 THEN 'papara'
                WHEN account.dataType = 2 THEN 'eşleşme'
                WHEN account.dataType = 3 THEN 'banka'
            END as accountType,
            finance.id as id,
            finance.price,
            finance.status,
            finance.site_id,
            DATE_FORMAT(finance.update_time, '%d.%m.%y %H:%i:%s') as update_time,
            DATE_FORMAT(finance.response_time, '%d.%m.%y %H:%i:%s') as response_time,
            DATE_FORMAT(finance.request_time, '%d.%m.%y %H:%i:%s') as request_time,
            finance.update_time as update_time_default,
            finance.response_time as response_time_default,
            finance.request_time as request_time_default,
            finance.user_id as user_id,
            finance.account_id,
            finance.transaction_id,
            finance.gamer_site_id,
            finance.method,
            finance.notes,
            account.dataType as account_type,
            account.account_name,
            site.site_name,
            site_gamer.id as customer_id,
            site_gamer.gamer_name,
            site_gamer.gamer_nick,
            user.user_name,
            finance_user_account.account_number
            from `finance`
            left join `user` on user.id=finance.user_id
            left join finance_user_account on finance_user_account.finance_id=finance.id
            left join site_gamer on site_gamer.gamer_site_id=finance.gamer_site_id
            left join account on account.id=finance.account_id
            left join site on site.id=finance.site_id
            where finance.id='" . $id . "'");

        $this->error->dbException($this->db->error()) != true ? die() : null;
        return $x->getRow();
    }

    public function tokenUpdate($token)
    {
        $tokenData = $this->db->query("select * from token where token='" . $token . "'")->getRow();
        if ($tokenData->id > 0) {
            $this->db->query("update token set status=2, updateTime=NOW() where token='" . $token . "'");
            $this->error->dbException($this->db->error()) != true ? die() : null;
        }
    }

    public function notificationSound($status)
    {
        $this->db->query("update " . (userId == 0 ? "root" : "user") . " set notificationSound='" . $status . "' where id='" . userId . "'");
        $this->error->dbException($this->db->error()) != true ? die() : null;
    }

    public function getNotificationSoundStatus()
    {
        $data = $this->db->query("select notificationSound from " . (userId == 0 ? "root" : "user") . " where id='" . userId . "'")->getRow();
        return $data->notificationSound;
    }

    public function dataUpdate($data)
    {
        $finance = $this->db->query("select * from finance where id='" . $data['id'] . "'")->getRow();
        $site = $this->db->query("select private_key from site where id='" . $finance->site_id . "'")->getRow();
        $match = $this->db->query("select * from site_gamer_match where gamer_site_id='" . $finance->gamer_site_id . "' and account_id='" . $finance->account_id . "'")->getRow();

        $this->db->query("
            UPDATE finance SET
            response_time=NOW(),
            update_time=NOW(),
            notes=?,
            user_id=?,
            status=?,
            setUpdate=1
            WHERE id=?
        ", [ $data['notes'], $this->session->get('primeId'), $data['status'], $data['id'] ]);

        if ($data['status'] == "reddedildi" && $match->firstMatch == 1 && $finance->request == "deposit") {
            $this->db->query("delete from site_gamer_match where gamer_site_id='" . $finance->gamer_site_id . "' and account_id='" . $finance->account_id . "'");
            $this->paypara->setLog("dataUpdate", "MÜŞTERİ TALEBİ REDDEDİLDİĞİ İÇİN HESAP EŞLEŞMESİ SONLANDIRILDI", $finance->gamer_site_id, $finance->site_id, $finance->price, 0, $finance->account_id, $finance->transaction_id);
        }

        if (!empty($finance->callBackURL) && $data['status'] !== "işlemde" && $data['status'] !== "beklemede") {
            $status = $data['status'] == "onaylandı" ? "success" : "rejected";
            $hash = md5($finance->transaction_id . $finance->gamer_site_id . $finance->price . $site->private_key);

            $requestAmount = floatval(str_replace(",", "", $finance->price));
            $processedAmount = floatval(str_replace(",", "", $data['price']));

            $postData = [
                'hash' => $hash,
                'transactionId' => $finance->transaction_id,
                'requestId' => $finance->request_id,
                'transaction' => $status,
                'processTime' => $finance->update_time,
                'message' => $data['notes'],
                'requestAmount' => $requestAmount,
                'processedAmount' => $processedAmount,
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $finance->callBackURL,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($postData),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5
            ]);

            $server_output = curl_exec($ch);

            $this->db->query("
                INSERT INTO log_callback (dataPost, dataResponse, error, siteId, callBackUrl, callbackTime)
                VALUES (
                    '" . http_build_query($postData) . "',
                    " . $this->db->escape($server_output) . ",
                    " . $this->db->escape(curl_error($ch)) . ",
                    '" . $finance->site_id . "',
                    '" . $finance->callBackURL . "',
                    NOW()
                )
            ");

            curl_close($ch);
        }

        $this->error->dbException($this->db->error()) != true ? die() : null;
        return $data["process"] == "update" ? $data['id'] : $this->db->insertID();
    }

    public function saveData($data)
    {
        if ($data['id'] == 0) {
            $sqlProcess    =    "insert into";
        } elseif ($data['id'] > 0) {
            $sqlProcess    = "update";
            $sqlUpdate    = "where id='" . $data['id'] . "'";
        }

        $perm_site_ids = "";
        if (is_array($data["perm_site"])) {
            foreach ($data["perm_site"] as $perm_site) {
                $perm_site_ids .= $perm_site . ",";
            }
        }

        $this->db->query("insert into log_query set query=" . $this->db->escape(json_encode($data)));

        $dataOld = $this->db->query("select * from account where id='" . $data['id'] . "'")->getRowArray();
        $dataOld = is_array($dataOld) ? $dataOld : array();

        $this->db->query("insert into logSys set
            `method`	='formPaparaAccountUpdate()',
            `user_id`	='" . $this->session->get('primeId') . "',
            `data_id`	='" . $data['id'] . "',
            `timestamp` =NOW(),
            `ip` 		='" . getClientIpAddress() . "',
            `dataOld`	=" . $this->db->escape(json_encode($dataOld)) . ",
            `dataNew`	=" . $this->db->escape(json_encode($data)) . "
		");

        $this->db->query($sqlProcess . " account set
            updateTime			=NOW(),
            perm_site			='" . rtrim($perm_site_ids, ",") . "',
            match_limit			='" . $data['match_limit'] . "',
            dataType			='" . $data['dataType'] . "',
            limitDeposit        ='" . $data['limitDeposit'] . "',
            status				='" . $data['status'] . "',
            limit_min			='" . $data['limit_min'] . "',
            limit_max			='" . $data['limit_max'] . "',
            account_name		='" . $data['account_name'] . "',
            account_number		='" . $data['account_number'] . "'
		" . $sqlUpdate);

        $this->error->dbException($this->db->error()) != true ? die() : null;
        return $data["process"] == "update" ? $data['id'] : $this->db->insertID();
    }

    public function datatable($dataStart = 0, $dataEnd = 99999999, $postData = [], $request)
    {
        $searchArray = explode("::", $postData["search"]["value"]);

        if ($searchArray[1] != "" && $searchArray[1] != "all") {
            $search = " and " . $searchArray[0] . "='" . $searchArray[1] . "'";
        } elseif ($searchArray[1] == "") {
            if (!empty($postData["search"]["value"])) {
                $search = " and (
                    finance.transaction_id LIKE '%" . $postData["search"]["value"] . "%' or
                    finance.gamer_site_id LIKE '%" . $postData["search"]["value"] . "%' or
                    finance.status LIKE '%" . $postData["search"]["value"] . "%' or
                    finance.method LIKE '%" . $postData["search"]["value"] . "%' or
                    finance.account_id LIKE '%" . $postData["search"]["value"] . "%' or
                    account.account_name LIKE '%" . $postData["search"]["value"] . "%' or
                    site_gamer.gamer_name LIKE '%" . $postData["search"]["value"] . "%' or
                    site.site_name LIKE '%" . $postData["search"]["value"] . "%'
                ) ";
            }
        }

        if ($postData["siteId"] != "")     $filter .= " and finance.site_id ='" . $postData["siteId"] . "' ";
        if ($postData["method"] != "")     $filter .= " and finance.method  ='" . $postData["method"] . "' ";
        if ($postData["status"] != "")     $filter .= " and finance.status ='" . $postData["status"] . "' ";
        if ($postData["accountId"] != "")  $filter .= " and finance.account_id ='" . $postData["accountId"] . "' ";

        // 09/09/2022 - 08/10/2022
        $dateParse      = explode(" - ", $postData["transactionDate"]);
        $dateStartParse = explode("/",  $dateParse[0]);
        $dateEndParse   = explode("/",  $dateParse[1]);
        $dateStart      = $dateStartParse[2] . "-" . $dateStartParse[1] . "-" . $dateStartParse[0];
        $dateEnd        = $dateEndParse[2] . "-" . $dateEndParse[1] . "-" . $dateEndParse[0];

        //$dateFilter 	= $postData["transactionDate"]!="" ? $postData["transactionDate"] : date("Y-m-d");
        $orderCol = $postData["order"][0]["column"];
        $orderDir = $postData["order"][0]["dir"];

        if ($orderDir == "") $orderDir = "desc";
        else $orderDir = $orderDir;

        if ($orderCol == "") $orderCol = "finance.request_time";
        if ($orderCol == 0) $orderCol = "finance.request_time";
        if ($orderCol == 4) $orderCol = "site.site_name";
        if ($orderCol == 5) $orderCol = "accountType";
        if ($orderCol == 6) $orderCol = "site_gamer.gamer_name";
        if ($orderCol == 7) $orderCol = "finance.price";
        if ($orderCol == 8) $orderCol = "finance.status";
        if (!empty($dataEnd)) $limit = "limit " . $dataStart . ", " . $dataEnd . "";

        $x = $this->db->query("
            select
            CASE
                WHEN account.dataType = 1 THEN 'papara'
                WHEN account.dataType = 2 THEN 'eşleşme'
                WHEN account.dataType = 3 THEN 'banka'
            END as accountType,
            finance.id as id,
            DATE_FORMAT(finance.update_time, '%d.%m.%y %H:%i:%s') as update_time,
            DATE_FORMAT(finance.response_time, '%d.%m.%y %H:%i:%s') as response_time,
            DATE_FORMAT(finance.request_time, '%d.%m.%y %H:%i:%s') as request_time,
            finance.update_time as update_time_default,
            finance.response_time as response_time_default,
            finance.request_time as request_time_default,
            finance.transaction_id,
            finance.account_id,
            finance.gamer_site_id,
            finance.price,
            finance.status,
            finance.site_id,
            finance.notes  as processNotes,
            account.dataType as account_type,
            account.account_name,
            account.account_number,
            user.user_name,
            site.site_name,
            finance.method,
            site_gamer.id as customer_id,
            site_gamer.gamer_name,
            site_gamer.isVip,
            site_gamer.deposit,
            site_gamer.note as customerNotes,
            site_gamer.withdraw,
            finance_user_account.account_number
            from `finance`
            left join finance_user_account on finance_user_account.finance_id=finance.id
            left join site_gamer on site_gamer.gamer_site_id=finance.gamer_site_id
            left join account on account.id=finance.account_id
            left join site on site.id=finance.site_id
            left join user on user.id=finance.user_id
            where
            request='" . $request . "' and finance.status NOT LIKE '%pre-request%' and request_time>='" . $dateStart . " 00:00:00' and request_time<='" . $dateEnd . " 23:59:59' " . $filter . $search . " order by " . $orderCol . " " . $orderDir . " " . $limit
        );

        $this->error->dbException($this->db->error()) != true ? die() : null;
        return $x;
    }

    public function customerTransactionTable($dataStart = 0, $dataEnd = 99999999, $postData = [], $site_id, $gamer_site_id)
    {
        $searchArray = explode("::", $postData["search"]["value"]);
        if ($searchArray[1] != "" && $searchArray[1] != "all") {
            $search = " and " . $searchArray[0] . "='" . $searchArray[1] . "'";
        } elseif ($searchArray[1] == "") {
            if (!empty($postData["search"]["value"])) {
                $search = " and (
                    finance.transaction_id LIKE '%" . $postData["search"]["value"] . "%' or
                    finance.status LIKE '%" . $postData["search"]["value"] . "%' or
                    finance.method LIKE '%" . $postData["search"]["value"] . "%' or
                    finance.account_id LIKE '%" . $postData["search"]["value"] . "%' or
                    ) ";
            }
        }

        if ($postData["siteId"] != "")     $filter .= " and finance.site_id ='" . $postData["siteId"] . "' ";
        if ($postData["method"] != "")     $filter .= " and finance.method  ='" . $postData["method"] . "' ";
        if ($postData["status"] != "")     $filter .= " and finance.status ='" . $postData["status"] . "' ";
        if ($postData["accountId"] != "")  $filter .= " and finance.account_id ='" . $postData["accountId"] . "' ";

        // 09/09/2022 - 08/10/2022
        $dateParse      = explode(" - ", $postData["transactionDate"]);
        $dateStartParse = explode("/",  $dateParse[0]);
        $dateEndParse   = explode("/",  $dateParse[1]);
        $dateStart      = $dateStartParse[2] . "-" . $dateStartParse[1] . "-" . $dateStartParse[0];
        $dateEnd        = $dateEndParse[2] . "-" . $dateEndParse[1] . "-" . $dateEndParse[0];
        $orderCol = $postData["order"][0]["column"];
        $orderDir = $postData["order"][0]["dir"];

        if ($orderDir == "") $orderDir = "desc";
        else $orderDir = $orderDir;

        if ($orderCol == "") $orderCol = "finance.request_time";
        if ($orderCol == 0) $orderCol = "finance.request_time";
        if ($orderCol == 2) $orderCol = "finance.account_id";
        if ($orderCol == 3) $orderCol = "accountType";
        if ($orderCol == 4) $orderCol = "finance.price";
        if ($orderCol == 5) $orderCol = "finance.status";
        if (!empty($dataEnd)) $limit = "limit " . $dataStart . ", " . $dataEnd . "";

        $x = $this->db->query("
            select
            CASE
                WHEN account.dataType = 1 THEN 'papara'
                WHEN account.dataType = 2 THEN 'eşleşme'
                WHEN account.dataType = 3 THEN 'banka'
            END as accountType,
            finance.id as id,
            DATE_FORMAT(finance.update_time, '%d.%m.%y %H:%i:%s') as update_time,
            DATE_FORMAT(finance.response_time, '%d.%m.%y %H:%i:%s') as response_time,
            DATE_FORMAT(finance.request_time, '%d.%m.%y %H:%i:%s') as request_time,
            finance.update_time as update_time_default,
            finance.response_time as response_time_default,
            finance.request_time as request_time_default,
            finance.transaction_id,
            finance.account_id,
            finance.gamer_site_id,
            finance.price,
            finance.status,
            account.account_name,
            account.account_number,
            site.site_name,
            finance.method,
            site_gamer.id as customer_id,
            site_gamer.gamer_name,
            site_gamer.isVip,
            site_gamer.deposit,
            site_gamer.withdraw,
            finance_user_account.account_number
            from `finance`
            left join finance_user_account on finance_user_account.finance_id=finance.id
            left join site_gamer on site_gamer.gamer_site_id=finance.gamer_site_id
            left join account on account.id=finance.account_id
            left join site on site.id=finance.site_id
            where
            request='deposit' and finance.site_id='" . $site_id . "' and finance.gamer_site_id='" . $gamer_site_id . "' and finance.status NOT LIKE '%pre-request%' and request_time>='" . $dateStart . " 00:00:00' and request_time<='" . $dateEnd . " 23:59:59' " . $filter . $search . " order by " . $orderCol . " " . $orderDir . " " . $limit
        );

        $this->error->dbException($this->db->error()) != true ? die() : null;
        return $x;
    }
}