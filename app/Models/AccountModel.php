<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->settings = new \App\Models\SettingsModel();
        $this->paypara = new \App\Libraries\Paypara();
        $this->error = new \App\Libraries\Error();
    }

    public function deleteAccount($id)
    {
        $this->db->query("update account set isDelete='1', status='0' where id='" . $id . "'");
        $this->error->dbException($this->db->error()) != true ? die() : null;

        $this->db->query("insert into logSys set
            `method`	='paparaAccountDelete()',
            `user_id`	='" . $this->session->get('primeId') . "',
            `data_id`	='" . $id . "',
            `timestamp` =NOW(),
            `ip` 		='" . getClientIpAddress() . "'
		");

        return true;
    }

    public function saveData($data)
    {
        if ($data['id'] == 0) {
            $sqlProcess    =    "insert into";
            $createTime    = "createTime=NOW(),";
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

        $this->db->query(
            "insert into logSys set
            `method`	='formPaparaAccountUpdate()',
            `user_id`	='" . $this->session->get('primeId') . "',
            `data_id`	='" . $data['id'] . "',
            `timestamp` =NOW(),
            `ip` 		='" . getClientIpAddress() . "',
            `dataOld`	=" . $this->db->escape(json_encode($dataOld)) . ",
            `dataNew`	=" . $this->db->escape(json_encode($data)) . "
		");

        $this->db->query($sqlProcess . " account set
        " . $createTime . "
            updateTime      = NOW(),
            perm_site       ='" . rtrim($perm_site_ids, ",") . "',
            match_limit     ='" . $data['match_limit'] . "',
            dataType        ='" . $data['dataType'] . "',
            bank_id         ='" . $data['bank_id'] . "',
            limitDeposit    ='" . $data['limitDeposit'] . "',
            limitProcess    ='" . $data['limitProcess'] . "',
            status          ='" . $data['status'] . "',
            limit_min       ='" . $data['limit_min'] . "',
            limit_max       ='" . $data['limit_max'] . "',
            account_name    ='" . stringNormalize($data['account_name']) . "',
            account_number  ='" . $data['account_number'] . "'
		" . $sqlUpdate);

        $this->error->dbException($this->db->error()) != true ? die() : null;
        return $data["process"] == "update" ? $data['id'] : $this->db->insertID();
    }

    public function transaction($dataStart = 0, $dataEnd = 99999999, $postData = [], $account_id)
    {
        $searchArray = explode("::", $postData["search"]["value"]);

        if ($searchArray[1] != "" && $searchArray[1] != "all") {
            $search = " and " . $searchArray[0] . "='" . $searchArray[1] . "'";
        } elseif ($searchArray[1] == "") {
            if (!empty($postData["search"]["value"])) {
                $search = " and (finance.transaction_id LIKE '%" . $postData["search"]["value"] . "%' or finance.gamer_site_id LIKE '%" . $postData["search"]["value"] . "%')";
            }
        }

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

        if ($orderCol == "") $orderCol = "finance.id";
        if ($orderCol == 0) $orderCol = "finance.id";
        if (!empty($dataEnd)) $limit  = "limit " . $dataStart . ", " . $dataEnd . "";

        $x = $this->db->query("
        select
        CASE
            WHEN account.dataType = 1 THEN 'papara'
            WHEN account.dataType = 2 THEN 'eşleşme'
        END as accountType,
        finance.id as id,
        DATE_FORMAT(finance.update_time, '%d.%m.%y %H:%i:%s') as update_time,
        DATE_FORMAT(finance.response_time, '%d.%m.%y %H:%i:%s') as response_time,
        DATE_FORMAT(finance.request_time, '%d.%m.%y %H:%i:%s') as request_time,
        finance.update_time as update_time_default,
        finance.response_time as response_time_default,
        finance.request_time as request_time_default,
        finance.transaction_id,
        finance.gamer_site_id,
        account.account_name,
        account.account_number,
        account.match_limit,
        site.site_name,
        finance.method,
        site_gamer.gamer_name,
        finance.price,
        finance.status,
        finance_user_account.account_number
        from `finance`
        left join finance_user_account on finance_user_account.finance_id=finance.id
        left join site_gamer on site_gamer.gamer_site_id=finance.gamer_site_id
        left join account on account.id=finance.account_id
        left join site on site.id=finance.site_id
        where
        finance.account_id='" . $account_id . "' and request_time>='" . $dateStart . " 00:00:00' and request_time<='" . $dateEnd . " 23:59:59'  " . $search . " order by " . $orderCol . " " . $orderDir . " " . $limit);

        $this->error->dbException($this->db->error()) != true ? die() : null;
        return $x;
    }

    public function datatable($dataStart = 0, $dataEnd = 99999999, $postData = [], $type = 1)
    {
        $searchArray = explode("::", $postData["search"]["value"]);
        if ($searchArray[1] != "" && $searchArray[1] != "all") {
            $search = " and " . $searchArray[0] . "='" . $searchArray[1] . "'";
        } elseif ($searchArray[1] == "") {
            if (!empty($postData["search"]["value"])) {
                $search = " and (account_name LIKE '%" . $postData["search"]["value"] . "%' or account_number LIKE '%" . $postData["search"]["value"] . "%')";
            }
        }

        $orderCol = $postData["order"][0]["column"];

        if ($orderCol == "") $orderCol = "id";
        if ($orderCol == 0) $orderCol = "id";

        if ($type == 1) {
            if ($orderCol == 1) $orderCol = "account_name";
            if ($orderCol == 2) $orderCol = "account_number";
            if ($orderCol == 3) $orderCol = "totalProcess";
            if ($orderCol == 4) $orderCol = "lastProcess";
            if ($orderCol == 5) $orderCol = "status";
        }

        if ($type == 2) {
            if ($orderCol == 1) $orderCol = "account_name";
            if ($orderCol == 2) $orderCol = "account_number";
            if ($orderCol == 3) $orderCol = "totalMatch";
            if ($orderCol == 4) $orderCol = "totalProcess";
            if ($orderCol == 5) $orderCol = "lastProcess";
            if ($orderCol == 6) $orderCol = "status";
        }

        if (!empty($dataEnd)) $limit  = "limit " . $dataStart . ", " . $dataEnd . "";

        return $this->db->query("
            select *,
            @id :=  id,
            @totalProcess   := (select COUNT(id) as totalProcess from finance where request='deposit' and account_id=@id) as totalProcess,
            @totalMatch     := (select COUNT(id) as totalMatch from site_gamer_match where isDelete=0 and account_id=@id) as totalMatch,
            @lastProcess    := (select DATE_FORMAT(update_time,'%d %b %y') from finance where account_id=@id order by update_time desc limit 1 ) as lastProcess
            from account
            where isDelete='0' and dataType='" . $type . "' " . $search . " order by " . $orderCol . " DESC " . $limit);
    }
}