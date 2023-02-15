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

    public function getSummaryData($year = null, $month = null)
    {
      $year = is_null($year) ? idate('Y') : $year;
      $month = is_null($month) ? idate('m') : $month;
      $firms = $this->session->get('root') ? null : filterSite();

      $db = \Config\Database::connect();

      return $db->query("
        SELECT
          (SELECT COALESCE(SUM(price), 0) FROM finance
          WHERE status = 'onaylandı' AND request = 'deposit' $firms AND MONTH(request_time) = $month AND YEAR(request_time) = $year) as deposit,
          (SELECT COALESCE(SUM(price), 0) FROM finance
          WHERE status = 'onaylandı' AND request = 'withdraw' $firms AND MONTH(request_time) = $month AND YEAR(request_time) = $year) as withdraw,
          (SELECT COALESCE(AVG(price), 0) FROM finance
          WHERE status = 'onaylandı' AND request = 'deposit' $firms AND MONTH(request_time) = $month AND YEAR(request_time) = $year) as average;
      ")->getResultArray()[0];
    }

    public function getMonthlyTransactionSum($type = 'deposit')
    {
      $firms = $this->session->get('root') ? null : filterSite();

      $db = \Config\Database::connect();
      return $db->query("
        SELECT DATE(request_time) AS day, COALESCE(SUM(price), 0) AS total
        FROM finance
        WHERE request = '$type'
          AND status = 'onaylandı'
          $firms
          AND MONTH(request_time) = MONTH(CURRENT_DATE())
          AND YEAR(request_time) = YEAR(CURRENT_DATE())
        GROUP BY DAY(request_time)
      ")->getResultArray();
    }
}