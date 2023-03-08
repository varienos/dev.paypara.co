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

    /**
     * Returns all firms in the database that are not deleted, sorted by status and then by id in descending order.
     * @return array An array of firm data including id, name, and status
     */
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

    /**
     * Returns the firms that are associated with the currently logged in user.
     * @return array An array of firm data including id, name, and status
     */
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

    /**
     * This function returns the current year if no year is specified, otherwise returns the specified year.
     * @param int|null $year The year to return. If null, the current year is returned.
     * @return int The current year if no year is specified, otherwise the specified year.
     */
    public function getYear($year)
    {
      return is_null($year) ? idate('Y') : $year;
    }

    /**
     * This function returns the current month if no month is specified, otherwise returns the specified month.
     * @param int|null $month The month to return. If null, the current month is returned.
     * @return int The current month if no month is specified, otherwise the specified month.
     */
    public function getMonth($month)
    {
      return is_null($month) ? idate('m') : $month;
    }

    /**
     * This function returns a SQL query fragment to filter the finance records by a specific firm ID.
     * @param int|null $firm The ID of the firm to filter by. If null, no filtering is performed.
     * @return string|null A SQL query fragment to filter the finance records by a specific firm ID, or null if no filtering is performed.
     */
    public function firmQuery($firm)
    {
        if($firm == 0) {
          return $this->session->get('root') ? null : filterSite();
        } else {
          return "AND finance.`site_id` = " . $firm;
        }
    }

    /**
     * Returns summary data for the given month and year, and optionally filtered by firm
     * @param string|null $month The month to get summary data for (in the format of "MM")
     * @param string|null $year The year to get summary data for (in the format of "YYYY")
     * @param int|null $firm The ID of the firm to filter by
     * @return array An array containing summary data for the given month and year, and optionally filtered by firm
     * The array contains the following keys:
     *   'deposit': The total amount deposited in the given month and year (or filtered by firm)
     *   'withdraw': The total amount withdrawn in the given month and year (or filtered by firm)
     *   'average': The average amount deposited in the given month and year (or filtered by firm)
     */
    public function getSummaryData($month = null, $year = null, $firm = null)
    {
      // Establish a connection to the database
      $db = \Config\Database::connect();

      // Query the database to get the summary data for deposits, withdrawals, and averages for the given month, year and firm (if provided) and return the result
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

    /**
     * Returns deposit distribution percentage by payment method for a given month and year.
     * @param int|null $month Month of the year to filter results. If null, current month is used.
     * @param int|null $year Year to filter results. If null, current year is used.
     * @param int|null $firm ID of the firm to filter results. If null, all firms are included.
     * @return array Array of deposit distribution percentage by payment method. Each item in the array has the following keys:
     *               'method': the name of the payment method
     *               'percentage': the percentage of the total deposit that uses this payment method
     */
    public function getDepositDistribution($month = null, $year = null, $firm = null)
    {
      // Connect to the database
      $db = \Config\Database::connect();

      // Query the database to get the deposit distribution for the given parameters
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

      // Loop through each method to check if it exists in the result set
      foreach ($all_methods as $method) {
          $method_exists = false;
          foreach ($results as $row) {
              // If the method exists in the result set, add it to the result array
              if ($row['method'] == $method) {
                  $result_array[] = $row;
                  $method_exists = true;
                  break;
              }
          }
          // If the method does not exist in the result set, add it to the result array with a percentage of 0
          if (!$method_exists) {
              $result_array[] = ['method' => $method, 'percentage' => '0.00'];
          }
      }

      // Return the result array, which now includes all possible payment methods with their corresponding percentages
      return $result_array;
    }

    public function getHighlightsData($month = null, $year = null, $firm = null)
    {
      // Connect to the database
      $db = \Config\Database::connect();

      // Run a SQL query to get various highlights data about gamers and finances
      $result = $db->query("
        SELECT
          (SELECT MAX(id) FROM site_gamer) as totalClients,
          (SELECT COUNT(id) FROM site_gamer WHERE isVip = 'on') as vipClients,
          (SELECT COUNT(id) FROM site_gamer WHERE perm_deposit != 'on') as depositRestricted,
          (SELECT COUNT(id) FROM site_gamer WHERE perm_withdraw != 'on') as withdrawRestricted,
          (SELECT COUNT(DISTINCT gamer_site_id) FROM `finance` where request='deposit' AND status = 'onaylandı') as activeClients;
      ")->getResultArray();

      // Return the first element of the result array
      // (since the query only returns a single row of data)
      return $result[0];
    }

    /**
     * Retrieves the transactions data for a specific year and month, filtered by a firm (if provided).
     * The data includes the count and total amount of deposit and withdraw transactions, as well as
     * the count and total amount of transactions per payment method (if the user has root access).
     * @param int|string|null $year The year to filter by. If null, the current year will be used.
     * @param int|string|null $month The month to filter by. If null, the current month will be used.
     * @param string|null $firm The firm to filter by. If null, all firms will be included.
     * @return \CodeIgniter\Database\ResultInterface The query result containing the transactions data.
     */
    public function getTransactions($year = null, $month = null, $firm = null)
    {
      // Initialize the query with the necessary columns and date formatting
      $query = "SELECT DATE_FORMAT(request_time, '%d.%m.%Y') AS request_time, method,";

      // Add column totals for root users
      if($this->session->get('root')) {
        $query .= "SUM(CASE WHEN method = 'cross' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS crossTotal,";
        $query .= "SUM(CASE WHEN method = 'bank' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS bankTotal,";
        $query .= "SUM(CASE WHEN method = 'pos' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS posTotal,";
        $query .= "SUM(CASE WHEN method = 'papara' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS paparaTotal,";
        $query .= "SUM(CASE WHEN method = 'match' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE '-' END) AS matchingTotal,";
      }

      // Add columns for successful deposit and withdraw transactions and totals
      $query .= "COUNT(CASE WHEN request = 'deposit' AND status = 'onaylandı' THEN price END) AS depositTxn,";
      $query .= "SUM(CASE WHEN request = 'deposit' AND status = 'onaylandı' THEN price ELSE 0 END) AS depositTotal,";
      $query .= "COUNT(CASE WHEN request = 'withdraw' AND status = 'onaylandı' THEN price END) AS withdrawTxn,";
      $query .= "SUM(CASE WHEN request = 'withdraw' AND status = 'onaylandı' THEN price ELSE 0 END) AS withdrawTotal ";

      // Add the finance table to the query and filter by year, month and firm
      $query .= "FROM finance ";
      $query .= "WHERE MONTH(request_time) = '" . $this->getMonth($month) . "' ";
      $query .= "AND YEAR(request_time)  = '" . $this->getYear($year) . "' ";
      $query .= $this->firmQuery($firm) . " ";

      // Group the results by year, month and day and sort by request_time in ascending order
      $query .= "GROUP BY YEAR(request_time), MONTH(request_time), DAY(request_time) ";
      $query .= "ORDER BY request_time ASC";

      // Execute the query and return the result
      return $this->db->query($query);
    }


    /**
     * Retrieves custom statistics for deposits made by users in a given month and year
     * @param int|null $year The year for which to retrieve statistics
     * @param int|null $month The month for which to retrieve statistics
     * @param string|null $firm The name of the firm for which to retrieve statistics
     * @return object The result of the SQL query
    */
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