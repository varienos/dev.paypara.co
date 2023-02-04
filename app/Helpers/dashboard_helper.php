<?php

function filterSite($table = "finance")
{
    if ($_SESSION['root'] != 1) {
        $siteFilter = null;
        foreach (getUserFirms() as $site_id) {
            $siteFilter .= $table . ".site_id='" . $site_id . "' or ";
        }

        return " and (" . rtrim($siteFilter, " or") . ")";
    }
}

function filterDate($table = 'finance', $filterDate = "")
{
    // 07/11/2022+-+07/11/2022
    // 09/09/2022 - 08/10/2022
    $filterDate = $filterDate == "" ? $_POST["filterDate"] : $filterDate;
    if ($filterDate != "") {
        $dateParse = explode("+-+", $filterDate);
        $dateStartParse = explode("/",  $dateParse[0]);
        $dateEndParse = explode("/",  $dateParse[1]);
        $dateStart = $dateStartParse[2] . "-" . $dateStartParse[1] . "-" . $dateStartParse[0];
        $dateEnd = $dateEndParse[2] . "-" . $dateEndParse[1] . "-" . $dateEndParse[0];

        return "and " . $table . ".request_time>='" . $dateStart . " 00:00:00' and " . $table . ".request_time<='" . $dateEnd . " 23:59:59'";
    }
}

function filterUser($table = "finance")
{
    if ($_SESSION['root'] != 1) {
        return " and " . $table . ".user_id='" . $_SESSION['userId'] . "'";
    }
}

function pendingProcess($request = "")
{
    $db = \Config\Database::connect();
    $data = $db->query("select COUNT(id) as pendingProcess from finance where " . ($request != "" ? " request='" . $request . "' and " : null) . " `status`='beklemede' " . filterSite())->getRow();

    return $data->pendingProcess != "" ? $data->pendingProcess : 0;
}

function pendingProcessDaily($request = "")
{
    $db = \Config\Database::connect();
    $data = $db->query("select COUNT(id) as pendingProcessDaily from finance where " . ($request != "" ? " request='" . $request . "' and " : null) . " `status`='beklemede' and DATE(`request_time`) = CURDATE()" . filterSite())->getRow();

    return $data->pendingProcessDaily != "" ? $data->pendingProcessDaily : 0;
}

function depositDaily()
{
    $db = \Config\Database::connect();
    $data = $db->query("select SUM(price) as depositDaily from finance where request='deposit' and `status`='onaylandı' and DATE(`request_time`) = CURDATE() " . filterSite())->getRow();

    return $data->depositDaily != "" ? $data->depositDaily : 0;
}

function withdrawDaily()
{
    $db = \Config\Database::connect();
    $data = $db->query("select SUM(price) as withdrawDaily from finance where request='withdraw' and `status`='onaylandı' and DATE(`request_time`) = CURDATE()" . filterSite())->getRow();

    return $data->withdrawDaily != "" ? $data->withdrawDaily : 0;
}

function depositPendingDaily()
{
    $db = \Config\Database::connect();
    $data = $db->query("select SUM(price) as depositPendingDaily from finance where request='deposit' and `status`='beklemede' and DATE(`request_time`) = CURDATE()" . filterSite())->getRow();

    return $data->depositPendingDaily != "" ? $data->depositPendingDaily : 0;
}

function depositProcessDaily()
{
    $db = \Config\Database::connect();
    $data = $db->query("select COUNT(id) as depositProcessDaily from finance where request='deposit' and `status`='onaylandı' and DATE(`request_time`) = CURDATE() " . filterSite())->getRow();

    return $data->depositProcessDaily != "" ? $data->depositProcessDaily : 0;
}

function withdrawProcessDaily()
{
    $db = \Config\Database::connect();
    $data = $db->query("select COUNT(id) as withdrawProcessDaily from finance where request='withdraw' and `status`='onaylandı' and DATE(`request_time`) = CURDATE()" . filterSite())->getRow();

    return $data->withdrawProcessDaily != "" ? $data->withdrawProcessDaily : 0;
}

function withdrawPendingDaily()
{
    $db = \Config\Database::connect();
    $data = $db->query("select SUM(price) as withdrawPendingDaily from finance where request='withdraw' and `status`='beklemede' and DATE(`request_time`) = CURDATE()" . filterSite())->getRow();

    return $data->withdrawPendingDaily != "" ? $data->withdrawPendingDaily : 0;
}

function depositFetchWeekly()
{
    $db   = \Config\Database::connect();
    $data = $db->query("
        SELECT SUM(price) as dayTotal,
        DATE_FORMAT(request_time,'%d.%m.%Y') as day,
        DATE(request_time) as request_time
        FROM finance
        WHERE request='deposit'
        AND YEARWEEK(request_time,1) = YEARWEEK(NOW(),1)
        AND `status`='onaylandı'
        GROUP BY DATE(request_time) " . filterSite()
    )->getResult('array');

    date_default_timezone_set('Europe/Istanbul');
    $day = date('w') - 1;
    $wStart = date('Y-m-d', strtotime('-' . $day . ' days'));
    $wEnd = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
    $now = strtotime($wStart);
    $days = array();

    $j = 0;
    for ($i = 0; $i < 7; $i++) {
        $x = new DateTime($data[$j]['request_time']);
        $y = new DateTime(strftime('%Y-%m-%d', $now));
        $days[] =  ['dayTotal' => ($x != $y ? 0 : $data[$j]['dayTotal']), 'day' => strftime('%d.%m.%Y', $now)];
        $now += 60 * 60 * 24;
        $j = $x == $y ? $j + 1 : $j;
    };

    return json_encode($days, JSON_NUMERIC_CHECK);
}

function withdrawFetchWeekly()
{
    $db = \Config\Database::connect();
    $data = $db->query("
    SELECT SUM(price) as dayTotal,
    DATE_FORMAT(request_time,'%d.%m.%Y') as day,
    DATE(request_time) as request_time
    FROM finance
    WHERE request='withdraw'
    AND YEARWEEK(request_time,1) = YEARWEEK(NOW(),1)
    AND `status`='onaylandı'
    GROUP BY DATE(request_time) " . filterSite())->getResult('array');

    date_default_timezone_set('Europe/Istanbul');

    $day = date('w') - 1;
    $wStart = date('Y-m-d', strtotime('-' . $day . ' days'));
    $wEnd = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
    $now = strtotime($wStart);
    $days = array();

    $j = 0;
    for ($i = 0; $i < 7; $i++) {
        $x = new DateTime($data[$j]['request_time']);
        $y = new DateTime(strftime('%Y-%m-%d', $now));
        $days[] =  ['dayTotal' => ($x != $y ? 0 : $data[$j]['dayTotal']), 'day' => strftime('%d.%m.%Y', $now)];
        $now += 60 * 60 * 24;
        $j = $x == $y ? $j + 1 : $j;
    };

    return json_encode($days, JSON_NUMERIC_CHECK);
}

function depositMonthly()
{
    $db = \Config\Database::connect();
    $data = $db->query("
        SELECT SUM(price) as depositMonthly
        FROM finance
        WHERE request='deposit' AND
        MONTH(request_time) = MONTH(CURRENT_DATE()) AND
        YEAR(request_time)  = YEAR(CURRENT_DATE()) AND
        `status`='onaylandı' " . filterSite())->getRow();

    return $data->depositMonthly == "" ? 0 : $data->depositMonthly;
}

function depositProcessMonthly()
{
    $db = \Config\Database::connect();
    $data = $db->query("
        SELECT COUNT(id) as depositProcessMonthly
        FROM finance
        WHERE request='deposit' AND
        MONTH(request_time) = MONTH(CURRENT_DATE()) AND
        YEAR(request_time)  = YEAR(CURRENT_DATE()) AND
        `status`='onaylandı' " . filterSite())->getRow();

    return $data->depositProcessMonthly == "" ? 0 : $data->depositProcessMonthly;
}

function bankProcessMonthly()
{
    $db = \Config\Database::connect();
    $data = $db->query("
        SELECT COUNT(id) as bankProcessMonthly
        FROM finance
        WHERE request='deposit'
        AND account_type=3
        AND MONTH(request_time) = MONTH(CURRENT_DATE())
        AND YEAR(request_time)  = YEAR(CURRENT_DATE())
        AND `status`='onaylandı' " . filterSite())->getRow();

    return $data->bankProcessMonthly == "" ? 0 : $data->bankProcessMonthly;
}

function posProcessMonthly()
{
    $db = \Config\Database::connect();
    $data = $db->query("
        SELECT COUNT(id) as posProcessMonthly
        FROM finance
        WHERE request='deposit'
        AND account_type=4
        AND MONTH(request_time) = MONTH(CURRENT_DATE())
        AND YEAR(request_time)  = YEAR(CURRENT_DATE())
        AND `status`='onaylandı' " . filterSite())->getRow();

    return $data->posProcessMonthly == "" ? 0 : $data->posProcessMonthly;
}

function matchProcessMonthly()
{
    $db = \Config\Database::connect();
    $data = $db->query("
        SELECT COUNT(id) as matchProcessMonthly
        FROM finance
        WHERE request='deposit'
        AND account_type=2
        AND MONTH(request_time) = MONTH(CURRENT_DATE())
        AND YEAR(request_time)  = YEAR(CURRENT_DATE())
        AND `status`='onaylandı' " . filterSite())->getRow();

    return $data->matchProcessMonthly == "" ? 0 : $data->matchProcessMonthly;
}

function withdrawMonthly()
{
    $db = \Config\Database::connect();
    $data = $db->query("
        SELECT SUM(price) as withdrawMonthly
        FROM finance
        WHERE request='withdraw'
        AND MONTH(request_time) = MONTH(CURRENT_DATE())
        AND YEAR(request_time)  = YEAR(CURRENT_DATE())
        AND `status`='onaylandı' " . filterSite())->getRow();

    return $data->withdrawMonthly == "" ? 0 : $data->withdrawMonthly;
}

function withdrawProcessMonthly()
{
    $db = \Config\Database::connect();
    $data = $db->query("
        SELECT COUNT(id) as withdrawProcessMonthly
        FROM finance
        WHERE request='withdraw'
        AND MONTH(request_time) = MONTH(CURRENT_DATE())
        AND YEAR(request_time)  = YEAR(CURRENT_DATE())
        AND `status`='onaylandı' " . filterSite())->getRow();

    return $data->withdrawProcessMonthly == "" ? 0 : $data->withdrawProcessMonthly;
}

function getCustomerTotalProcessWithAccount($gamer_site_id, $account_id)
{
    $db = \Config\Database::connect();
    $data = $db->query("
        SELECT COUNT(id) as getCustomerTotalProcessWithAccount
        FROM finance
        WHERE request='deposit'
        AND `status`='onaylandı'
        AND gamer_site_id='" . $gamer_site_id . "'
        AND account_id='" . $account_id . "'")->getRow();

    return $data->getCustomerTotalProcessWithAccount == "" ? 0 : $data->getCustomerTotalProcessWithAccount;
}

function getCustomerTotalDepositWithAccount($gamer_site_id, $account_id)
{
    $db = \Config\Database::connect();
    $data = $db->query("
        SELECT SUM(price) as getCustomerTotalDepositWithAccount
        FROM finance
        WHERE request='deposit'
        AND `status`='onaylandı'
        AND gamer_site_id='" . $gamer_site_id . "'
        AND account_id='" . $account_id . "'")->getRow();

    return $data->getCustomerTotalDepositWithAccount == "" ? 0 : $data->getCustomerTotalDepositWithAccount;
}