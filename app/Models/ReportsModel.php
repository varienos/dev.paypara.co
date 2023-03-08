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

    /**
     * Retrieves the monthly transaction sum for a given month and year for a specific firm.
     *
     * @param int|string|null $month Optional. The month to retrieve data for. Defaults to the current month if not provided.
     * @param int|string|null $year Optional. The year to retrieve data for. Defaults to the current year if not provided.
     * @param int|string|null $firm Optional. The ID of the firm to retrieve data for. If not provided, retrieves data for all firms.
     * @return array An array of transaction data for each day in the specified month.
    */
    public function getMonthlyTransactionSum($month = null, $year = null, $firm = null)
    {
      // set the year and month based on the input or current date
      $year = $this->getYear($year);
      $month = $this->getMonth($month);

      // connect to the database
      $db = \Config\Database::connect();

      // query to get the total deposits and withdrawals for each day in the given month
      $result = $db->query("
        SELECT
          DATE(request_time) AS day,
          SUM(CASE WHEN request = 'deposit' THEN price ELSE 0 END) AS deposit,
          SUM(CASE WHEN request = 'withdraw' THEN price ELSE 0 END) AS withdraw
        FROM finance
        WHERE status = 'onaylandı'
          " . $this->firmQuery($firm) . "
          AND MONTH(request_time) = $month
          AND YEAR(request_time) = $year
        GROUP BY DAY(request_time)
      ")->getResultArray();

      // create an array of all days in the month
      $days_in_month = [];
      $days_count = date('j', strtotime('last day of ' . $year . '-' . $month));
      for ($i = 1; $i <= $days_count; ++$i) {
        // format the date as YYYY-MM-DD and initialize the deposit and withdraw values to 0
        $day = sprintf('%04d-%02d-%02d', $year, $month, $i);
        $days_in_month[$day] = [
          'day' => $day,
          'deposit' => 0,
          'withdraw' => 0,
        ];
      }

      // merge the result array with the days in the month array
      $merged = array_map(function ($day) use ($result) {
        // filter the result array to get the deposit and withdraw values for the current day
        $item = array_filter($result, function ($r) use ($day) {
          return substr($r['day'], 0, 10) == $day['day'];
        });
        // get the first (and only) item from the filtered array, or an empty array if none found
        $item = array_shift($item);

        // return an array with the day, deposit, and withdraw values for the current day
        return [
          'day' => $day['day'],
          'deposit' => $item['deposit'] ?? "0.00",
          'withdraw' => $item['withdraw'] ?? "0.00",
        ];
      }, $days_in_month);

      // return the merged array as a list of values (without the keys)
      return array_values($merged);
    }

    public function getDepositDistribution($month = null, $year = null, $firm = null)
    {
      $db = \Config\Database::connect();

      $results = $db->query("
        SELECT method, ROUND(COUNT(*) * 100.0 / SUM(COUNT(*)) OVER(), 2) AS percentage
        FROM finance
        WHERE status = 'onaylandı'
          " . $this->firmQuery($firm) . "
          AND MONTH(request_time) = " . $this->getMonth($month) . "
          AND YEAR(request_time) = " . $this->getYear($year) . "
        GROUP BY method
        ORDER BY method DESC;
      ")->getResultArray();

      // Include all methods on the result if they don't have any transaction
      $result_array = [];
      $all_methods = ['papara', 'match', 'bank', 'cross', 'pos'];
      foreach ($all_methods as $method) {
          $method_exists = false;
          foreach ($results as $row) {
              if ($row['method'] == $method) {
                  $result_array[] = $row;
                  $method_exists = true;
                  break;
              }
          }
          if (!$method_exists) {
              $result_array[] = ['method' => $method, 'percentage' => '0.00'];
          }
      }

      return $result_array;
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
      $query = "SELECT DATE_FORMAT(request_time, '%d.%m.%Y') AS request_time, method,";

      if($this->session->get('root')) {
        $query .= "SUM(CASE WHEN method = 'cross' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS crossTotal,";
        $query .= "SUM(CASE WHEN method = 'bank' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS bankTotal,";
        $query .= "SUM(CASE WHEN method = 'pos' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS posTotal,";
        $query .= "SUM(CASE WHEN method = 'papara' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS paparaTotal,";
        $query .= "SUM(CASE WHEN method = 'match' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS matchingTotal,";
      }

      $query .= "COUNT(CASE WHEN request = 'deposit' AND status = 'onaylandı' THEN price END) AS depositTxn,";
      $query .= "SUM(CASE WHEN request = 'deposit' AND status = 'onaylandı' THEN price ELSE 0 END) AS depositTotal,";
      $query .= "COUNT(CASE WHEN request = 'withdraw' AND status = 'onaylandı' THEN price END) AS withdrawTxn,";
      $query .= "SUM(CASE WHEN request = 'withdraw' AND status = 'onaylandı' THEN price ELSE 0 END) AS withdrawTotal ";
      $query .= "FROM finance ";
      $query .= "WHERE MONTH(request_time) = '" . $this->getMonth($month) . "' ";
      $query .= "AND YEAR(request_time)  = '" . $this->getYear($year) . "' ";
      $query .= $this->firmQuery($firm) . " ";
      $query .= "GROUP BY YEAR(request_time), MONTH(request_time), DAY(request_time) ";
      $query .= "ORDER BY request_time ASC";

      return $this->db->query($query);
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