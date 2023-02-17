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
}