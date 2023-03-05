<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportsModel extends Model
{
    function __construct()
    {
      $this->db = \Config\Database::connect();
      $this->session = \Config\Services::session();
    }

    public function getAllFirms()
    {
      $db = \Config\Database::connect();

      return $db->query("
        SELECT id, site_name AS name, status
        FROM site
        WHERE isDelete = 0
        ORDER BY
          CASE WHEN status = 0 THEN 1 ELSE 0 END,
          id DESC
      ")->getResultArray();
    }

    public function getUserFirms()
    {
      $db = \Config\Database::connect();

      return $db->query("
        SELECT site.id, site.site_name AS name, site.status
        FROM user
        JOIN site ON FIND_IN_SET(site.id, user.perm_site) > 0
        WHERE user.id = " . $this->session->get('userId')
      )->getResultArray();
    }

    public function getYear($year)
    {
      return is_null($year) ? idate('Y') : $year;
    }

    public function getMonth($month)
    {
      return is_null($month) ? idate('m') : $month;
    }

    public function firmQuery($firm)
    {
        if($firm == 0) {
          return $this->session->get('root') ? null : filterSite();
        } else {
          return "AND finance.`site_id` = " . $firm;
        }
    }

    public function getSummaryData($month = null, $year = null, $firm = null)
    {
      $db = \Config\Database::connect();

      return $db->query("
        SELECT
          (SELECT COALESCE(SUM(price), 0) FROM finance
          WHERE status = 'onaylandı' AND request = 'deposit' " . $this->firmQuery($firm) . " AND MONTH(request_time) = " . $this->getMonth($month) . " AND YEAR(request_time) = " . $this->getYear($year) . ") as deposit,

          (SELECT COALESCE(SUM(price), 0) FROM finance
          WHERE status = 'onaylandı' AND request = 'withdraw' " . $this->firmQuery($firm) . " AND MONTH(request_time) = " . $this->getMonth($month) . " AND YEAR(request_time) = " . $this->getYear($year) . ") as withdraw,

          (SELECT COALESCE(AVG(price), 0) FROM finance
          WHERE status = 'onaylandı' AND request = 'deposit' " . $this->firmQuery($firm) . " AND MONTH(request_time) = " . $this->getMonth($month) . " AND YEAR(request_time) = " . $this->getYear($year) . ") as average;
      ")->getResultArray()[0];
    }

    public function getMonthlyTransactionSum($type = 'deposit', $month = null, $year = null, $firm = null)
    {
      $db = \Config\Database::connect();

      return $db->query("
        SELECT DATE(request_time) AS day, COALESCE(SUM(price), 0) AS total
        FROM finance
        WHERE request = '$type'
          AND status = 'onaylandı'
          " . $this->firmQuery($firm) . "
          AND MONTH(request_time) = " . $this->getMonth($month) . "
          AND YEAR(request_time) = " . $this->getYear($year) . "
        GROUP BY DAY(request_time)
      ")->getResultArray();
    }

    public function getHighlightsData($month = null, $year = null, $firm = null)
    {
      $db = \Config\Database::connect();

      return $db->query("
        SELECT
          (SELECT MAX(id) FROM site_gamer) as totalClients,
          (SELECT COUNT(id) FROM site_gamer WHERE isVip = 'on') as vipClients,
          (SELECT COUNT(id) FROM site_gamer WHERE perm_deposit != 'on') as depositRestricted,
          (SELECT COUNT(id) FROM site_gamer WHERE perm_withdraw != 'on') as withdrawRestricted,
          (SELECT COUNT(DISTINCT gamer_site_id) FROM `finance` where request='deposit' AND status = 'onaylandı') as activeClients;
      ")->getResultArray()[0];
    }

    public function getTransactions($year = null, $month = null, $firm = null)
    {
      return $this->db->query("
        SELECT DATE_FORMAT(request_time, '%d.%m.%Y') AS request_time, method,
        SUM(CASE WHEN method = 'cross' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS crossTotal,
        SUM(CASE WHEN method = 'bank' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS bankTotal,
        SUM(CASE WHEN method = 'pos' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS posTotal,
        SUM(CASE WHEN method = 'papara' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS paparaTotal,
        SUM(CASE WHEN method = 'match' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS matchingTotal,
        SUM(CASE WHEN request = 'deposit' AND status = 'onaylandı' THEN price ELSE 0 END) AS depositTotal,
        SUM(CASE WHEN request = 'withdraw' AND status = 'onaylandı' THEN price ELSE 0 END) AS withdrawTotal
        FROM finance
        WHERE MONTH(request_time) = '" . $this->getMonth($month) . "'
        AND YEAR(request_time)  = '" . $this->getYear($year) . "'
        " . $this->firmQuery($firm) . "
        GROUP BY YEAR(request_time), MONTH(request_time), DAY(request_time)
        ORDER BY request_time ASC
      ");
    }

    public function getStatistics($year = null, $month = null, $firm = null)
    {
      return $this->db->query("
        SELECT sg.gamer_site_id as userId, sg.gamer_nick as userNick, sg.gamer_name as userName, COUNT(f.price) as count, SUM(f.price) AS total
        FROM site_gamer sg
        JOIN finance f ON sg.site_id = f.site_id
        WHERE sg.gamer_site_id = f.user_id
          AND f.request = 'deposit'
          AND f.status = 'approved'
        GROUP BY sg.gamer_site_id, sg.gamer_nick, sg.gamer_name
        ORDER BY SUM(f.price) DESC
        LIMIT 50;
      ");
    }
}