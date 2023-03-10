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
     *
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
     *
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
     *
     * @param int|null $year The year to return. If null, the current year is returned.
     *
     * @return int The current year if no year is specified, otherwise the specified year.
     */
    public function getYear($year)
    {
      return is_null($year) ? idate('Y') : $year;
    }

    /**
     * This function returns the current month if no month is specified, otherwise returns the specified month.
     *
     * @param int|null $month The month to return. If null, the current month is returned.
     *
     * @return int The current month if no month is specified, otherwise the specified month.
     */
    public function getMonth($month)
    {
      return is_null($month) ? idate('m') : $month;
    }

    /**
     * This function returns a SQL query fragment to filter the finance records by a specific firm ID.
     *
     * @param int|null $firm The ID of the firm to filter by. If null, no filtering is performed.
     *
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
     * Retrieves the monthly transaction sum for a given month and year for a specific firm.
     *
     * @param int|string|null $month Optional. The month to retrieve data for. Defaults to the current month if not provided.
     * @param int|string|null $year Optional. The year to retrieve data for. Defaults to the current year if not provided.
     * @param int|string|null $firm Optional. The ID of the firm to retrieve data for. If not provided, retrieves data for all firms.
     *
     * @return array An array of transaction data for each day in the specified month.
     */
    public function getMonthlyTransactionSum($month = null, $year = null, $firm = null)
    {
      // Set the year and month based on the input or current date
      $year = $this->getYear($year);
      $month = $this->getMonth($month);

      // Connect to the database
      $db = \Config\Database::connect();

      // Query to get the total deposits and withdrawals for each day in the given month
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

      // Create an array of all days in the month
      $days_in_month = [];
      $days_count = date('j', strtotime('last day of ' . $year . '-' . $month));
      for ($i = 1; $i <= $days_count; ++$i) {
        // Format the date as YYYY-MM-DD and initialize the deposit and withdraw values to 0
        $day = sprintf('%04d-%02d-%02d', $year, $month, $i);
        $days_in_month[$day] = [
          'day' => $day,
          'deposit' => 0,
          'withdraw' => 0,
        ];
      }

      // Merge the result array with the days in the month array
      $merged = array_map(function ($day) use ($result) {
        // Filter the result array to get the deposit and withdraw values for the current day
        $item = array_filter($result, function ($r) use ($day) {
          return substr($r['day'], 0, 10) == $day['day'];
        });
        // Get the first (and only) item from the filtered array, or an empty array if none found
        $item = array_shift($item);

        // Return an array with the day, deposit, and withdraw values for the current day
        return [
          'day' => $day['day'],
          'deposit' => $item['deposit'] ?? "0.00",
          'withdraw' => $item['withdraw'] ?? "0.00",
        ];
      }, $days_in_month);

      // Return the merged array as a list of values (without the keys)
      return array_values($merged);
    }

    /**
     * Returns deposit distribution percentage by payment method for a given month and year.
     *
     * @param int|null $month Month of the year to filter results. If null, current month is used.
     * @param int|null $year Year to filter results. If null, current year is used.
     * @param int|null $firm ID of the firm to filter results. If null, all firms are included.
     *
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

    /**
     * Get various highlights data about gamers and finances for a given month, year, and firm.
     *
     * @param int|null $month The month to get highlights data for.
     * @param int|null $year The year to get highlights data for.
     * @param string|null $firm The firm to get highlights data for.
     *
     * @return array An array of highlights data.
     */
    public function getHighlightsData($month = null, $year = null, $firm = null)
    {
      // Connect to the database
      $db = \Config\Database::connect();

      // Run a SQL query to get various highlights data about gamers and finances
      $result = $db->query("
        SELECT
          (SELECT COALESCE((SELECT MAX(id) FROM site_gamer WHERE isDelete = 0), 0)) as totalClients,
          (SELECT COALESCE(COUNT(id), 0) FROM site_gamer WHERE isVip = 'on' AND isDelete = 0) as vipClients,
          (SELECT COALESCE(COUNT(id), 0) FROM site_gamer WHERE perm_deposit != 'on' AND isDelete = 0) as depositRestricted,
          (SELECT COALESCE(COUNT(id), 0) FROM site_gamer WHERE perm_withdraw != 'on' AND isDelete = 0) as withdrawRestricted,
          (SELECT COALESCE(COUNT(DISTINCT gamer_site_id), 0) FROM `finance` where status = 'onaylandı') as activeClients
      ")->getResultArray();

      // Return the first element of the result array
      // (since the query only returns a single row of data)
      return $result[0];
    }

    /**
     * Retrieves the transactions data for a specific year and month, filtered by a firm (if provided).
     * The data includes the count and total amount of deposit and withdraw transactions, as well as
     * the count and total amount of transactions per payment method (if the user has root access).
     *
     * @param int|null $year Year to get transactions for. If not provided, current year is used.
     * @param int|null $month Month to get transactions for. If not provided, current month is used.
     * @param string|null $firm Firm to get transactions for. If not provided, all firms are included.
     *
     * @return array Transactions data for the given year, month, and firm.
    */
    public function getTransactions($year = null, $month = null, $firm = null)
    {
      // Set default values.
      $year = $this->getYear($year);
      $firm = $this->firmQuery($firm);
      $month = $this->getMonth($month);

      // Initialize days array.
      $days = [];

      // Get current day, month, and year.
      $current_day = date('d');
      $current_year = date('Y');
      $current_month = date('m');

      // If year and month are current, only include days up to the current day
      if ($year == $current_year && $month == $current_month) {
          for ($i = 1; $i <= $current_day; $i++) {
              $days[] = date('Y-m-d', strtotime("$year-$month-$i"));
          }
      } else { // Otherwise, include all days for the given month
          for ($i = 1; $i <= date('t', strtotime("$year-$month-01")); $i++) {
              $days[] = date('Y-m-d', strtotime("$year-$month-$i"));
          }
      }

      // Start building the query with the necessary columns and date formatting
      $query = "SELECT DATE_FORMAT(days.request_time, '%d.%m.%Y') as request_time ";

      // Add column totals for root users
      if($this->session->get('root')) {
          $query .= ", SUM(CASE WHEN method = 'cross' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE 0 END) AS crossTotal ";
          $query .= ", SUM(CASE WHEN method = 'bank' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE 0 END) AS bankTotal ";
          $query .= ", SUM(CASE WHEN method = 'pos' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE 0 END) AS posTotal ";
          $query .= ", SUM(CASE WHEN method = 'papara' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE 0 END) AS paparaTotal ";
          $query .= ", SUM(CASE WHEN method = 'match' AND request = 'deposit' AND status = 'onaylandı' THEN price ELSE 0 END) AS matchingTotal ";
      }

      // Add columns for successful deposit and withdraw transactions and totals
      $query .= ", COUNT(CASE WHEN request = 'deposit' AND status = 'onaylandı' THEN price END) AS depositTxn ";
      $query .= ", SUM(CASE WHEN request = 'deposit' AND status = 'onaylandı' THEN price ELSE 0 END) AS depositTotal ";
      $query .= ", COUNT(CASE WHEN request = 'withdraw' AND status = 'onaylandı' THEN price END) AS withdrawTxn ";
      $query .= ", SUM(CASE WHEN request = 'withdraw' AND status = 'onaylandı' THEN price ELSE 0 END) AS withdrawTotal ";

      // Add the FROM and WHERE clauses
      $query .= "FROM (SELECT ? as request_time ";

      // Add placeholders for each day
      for ($i = 1; $i < count($days); $i++) {
          $query .= "UNION SELECT ? ";
      }

      // Add the table joins and where conditions
      $query .= ") days LEFT JOIN finance ON DATE(days.request_time) = DATE(finance.request_time) AND finance.status = 'onaylandı' ";
      $query .= "WHERE MONTH(days.request_time) = ? AND YEAR(days.request_time) = ? ";
      $query .= $firm . " ";

      // Group by year, month, and day
      $query .= "GROUP BY YEAR(days.request_time), MONTH(days.request_time), DAY(days.request_time) ";
      $query .= "ORDER BY days.request_time ASC";

      // Merge the placeholders for the query
      $placeholders = array_merge($days, [$month, $year]);

      // Execute the query and return the result
      return $this->db->query($query, $placeholders)->getResult();
    }

    /**
     * Retrieves custom statistics for deposits made by users in a given month and year
     *
     * @param int|null $year The year for which to retrieve statistics
     * @param int|null $month The month for which to retrieve statistics
     * @param string|null $firm The name of the firm for which to retrieve statistics
     *
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