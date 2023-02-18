<?php
namespace App\Models;
use CodeIgniter\Model;
class ReportsModel extends Model
{
    function __construct()
    {
      $this->db       = \Config\Database::connect();
      $this->session  = \Config\Services::session();
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
    public function getSummaryData($month = null, $year = null, $firm = null)
    {
      $year = is_null($year) ? idate('Y') : $year;
      $month = is_null($month) ? idate('m') : $month;
      if($firm == 0) {
        $firmQuery = $this->session->get('root') ? null : filterSite();
      } else {
        $firmQuery = "AND finance.site_id = " . $firm;
      }
      $db = \Config\Database::connect();
      return $db->query("
        SELECT
          (SELECT COALESCE(SUM(price), 0) FROM finance
          WHERE status = 'onaylandı' AND request = 'deposit' $firmQuery AND MONTH(request_time) = $month AND YEAR(request_time) = $year) as deposit,
          (SELECT COALESCE(SUM(price), 0) FROM finance
          WHERE status = 'onaylandı' AND request = 'withdraw' $firmQuery AND MONTH(request_time) = $month AND YEAR(request_time) = $year) as withdraw,
          (SELECT COALESCE(AVG(price), 0) FROM finance
          WHERE status = 'onaylandı' AND request = 'deposit' $firmQuery AND MONTH(request_time) = $month AND YEAR(request_time) = $year) as average;
      ")->getResultArray()[0];
    }
    public function getMonthlyTransactionSum($type = 'deposit', $month = null, $year = null, $firm = null)
    {
      $year = is_null($year) ? idate('Y') : $year;
      $month = is_null($month) ? idate('m') : $month;
      if($firm == 0) {
        $firmQuery = $this->session->get('root') ? null : filterSite();
      } else {
        $firmQuery = "AND finance.site_id = " . $firm;
      }
      $db = \Config\Database::connect();
      return $db->query("
        SELECT DATE(request_time) AS day, COALESCE(SUM(price), 0) AS total
        FROM finance
        WHERE request = '$type'
          AND status = 'onaylandı'
          $firmQuery
          AND MONTH(request_time) = $month
          AND YEAR(request_time) = $year
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
    public function year($year)
    {
      return is_null($year) ? idate('Y') : $year;
    }
    public function month($month)
    {
      return is_null($month) ? idate('m') : $month;
    }
    public function firmQuery($firm)
    {
        if($firm == 0) 
        {
          return $this->session->get('root') ? null : filterSite();
        } else {
          return "AND finance.`site_id` = " . $firm;
        }
    }
    public function datatableTransactions($dataStart = 0, $dataEnd = 99999999, $postData = [], $year = null, $month = null, $firm = null)
    {
        $orderCol = $postData["order"][0]["column"];
        $orderDir = $postData["order"][0]["dir"];
        if ($orderDir == "") $orderDir = "desc";
        else $orderDir = $orderDir;
        if ($orderCol == "") $orderCol = "finance.id";
        if ($orderCol == 0) $orderCol = "finance.id";
        if (!empty($dataEnd)) $limit  = "limit " . $dataStart . ", " . $dataEnd . "";
        return  $this->db->query("
                SELECT
                `request_time`,
                `method`,
                SUM(CASE
                    WHEN `method` = 'papara'
                        THEN price
                        ELSE 0
                    END) AS paparaTotal,
                SUM(CASE
                    WHEN `method` = 'bank'
                        THEN price
                        ELSE 0
                    END) AS bankTotal,
                SUM(CASE
                    WHEN `method` = 'cross'
                        THEN price
                        ELSE 0
                    END) AS crossTotal,
                SUM(CASE
                    WHEN `method` = 'matching'
                        THEN price
                        ELSE 0
                    END) AS matchingTotal,
                SUM(CASE
                    WHEN `method` = 'pos'
                        THEN price
                        ELSE 0
                    END) AS posTotal,
                SUM(CASE
                    WHEN `request` = 'deposit'
                        THEN price
                        ELSE 0
                    END) AS depositTotal,
                SUM(CASE
                    WHEN `request` = 'withdraw'
                        THEN price
                        ELSE 0
                    END) AS withdrawTotal
                FROM finance
                WHERE  
                MONTH(request_time) = '".$this->month($month)."' AND
                ".$this->firmQuery($firm)."
                YEAR(request_time)  = '".$this->year($year)."' 
                GROUP BY
                YEAR(request_time), MONTH(request_time), DAY(request_time)
                ORDER BY 
                " . $orderCol . " " . $orderDir . " " . $limit);
    }
}