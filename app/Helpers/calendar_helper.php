<?php

declare(strict_types=1);

/**
 * ============================================================================
 * Calendar Helper Functions
 * ============================================================================
 */

if (!function_exists('dateInfo')) {
  //---------------------------------------------------------------------------
  /**
   * Function to get date information.
   *
   * This function generates an array of date information based on the provided
   * year, month, and day. The information includes the day, month, year,
   * days in the month, ISO date, weekday, week number, month name, first and
   * last day of the month, first and last day of the year, first and last day
   * of the quarter, and first and last day of the half year.
   *
   * @param int|string $year  The year for which the date information is to be generated.
   * @param int|string $month The month for which the date information is to be generated.
   * @param int|string $day   Optional. The day for which the date information is to be generated. Default is 1.
   *
   * @return array $dateInfo The array containing the date information.
   */
  function dateInfo(int|string $year, int|string $month, int|string $day = '1'): array {
    $dateInfo = [];
    $myts     = strtotime((string)$year . '-' . (string)$month . '-' . (string)$day);
    $mydate   = getdate($myts);

    $dateInfo['dd']          = sprintf('%02d', $mydate['mday']); // Numeric representation of today's' day of the month, 2 digits
    $dateInfo['mm']          = sprintf('%02d', $mydate['mon']);  // Numeric representation of today's' month, 2 digits
    $dateInfo['year']        = $mydate['year'];                  // Numeric representation of today's' year, 4 digits
    $dateInfo['month']       = $mydate['month'];                 // Numeric representation of today's' month, 2 digits
    $dateInfo['daysInMonth'] = date('t', $myts);                 // Number of days in current month

    /**
     * Current day
     * ISO 8601 formatted date of today, e.g.
     * 2014-03-03
     */
    $dateInfo['ISO'] = $dateInfo['year'] . '-' . $dateInfo['mm'] . '-' . $dateInfo['dd'];

    /**
     * Weekday
     * 1 = Monday, 2 = Tuesday, ..., 7 = Sunday
     */
    $dateInfo['wday']         = date('N', $myts);
    $dateInfo['weekdayShort'] = lang('App.weekdayShort.' . $dateInfo['wday']);
    $dateInfo['weekdayLong']  = lang('App.weekdayLong.' . $dateInfo['wday']);

    /**
     * Week number
     */
    $dateInfo['week'] = date('W', $myts);

    /**
     * Current month
     * - ISO 8601 formatted date of the first day of the current month, e.g. 2014-03-01
     * - ISO 8601 formatted date of the last day of the current month, e.g. 2014-03-31
     */
    $dateInfo['monthname']    = lang('App.monthnames.' . (string)$mydate['mon']);
    $dateInfo['firstOfMonth'] = $dateInfo['year'] . '-' . $dateInfo['mm'] . '-01';
    $dateInfo['lastOfMonth']  = (string)$dateInfo['year'] . '-' . $dateInfo['mm'] . '-' . (string)$dateInfo['daysInMonth'];

    /**
     * Current year
     */
    $dateInfo['firstOfYear'] = $dateInfo['year'] . '-01-01';
    $dateInfo['lastOfYear']  = $dateInfo['year'] . '-12-31';

    /**
     * Current quarter and half year
     */
    switch ($dateInfo['mm']) {
      case 4:
      case 5:
      case 6:
        $dateInfo['quarterShort']   = 'Q2';
        $dateInfo['quarterLong']    = lang('App.quarter') . ' 2';
        $dateInfo['firstOfQuarter'] = $dateInfo['year'] . '-04-01';
        $dateInfo['lastOfQuarter']  = $dateInfo['year'] . '-06-30';
        $dateInfo['firstOfHalf']    = $dateInfo['year'] . '-01-01';
        $dateInfo['lastOfHalf']     = $dateInfo['year'] . '-06-30';
        break;

      case 7:
      case 8:
      case 9:
        $dateInfo['quarterShort']   = 'Q3';
        $dateInfo['quarterLong']    = lang('App.quarter') . ' 3';
        $dateInfo['firstOfQuarter'] = $dateInfo['year'] . '-07-01';
        $dateInfo['lastOfQuarter']  = $dateInfo['year'] . '-09-30';
        $dateInfo['firstOfHalf']    = $dateInfo['year'] . '-07-01';
        $dateInfo['lastOfHalf']     = $dateInfo['year'] . '-12-31';
        break;

      case 10:
      case 11:
      case 12:
        $dateInfo['quarterShort']   = 'Q4';
        $dateInfo['quarterLong']    = lang('App.quarter') . ' 4';
        $dateInfo['firstOfQuarter'] = $dateInfo['year'] . '-10-01';
        $dateInfo['lastOfQuarter']  = $dateInfo['year'] . '-12-31';
        $dateInfo['firstOfHalf']    = $dateInfo['year'] . '-07-01';
        $dateInfo['lastOfHalf']     = $dateInfo['year'] . '-12-31';
        break;

      default:
        $dateInfo['quarterShort']   = 'Q1';
        $dateInfo['quarterLong']    = lang('App.quarter') . ' 1';
        $dateInfo['firstOfQuarter'] = $dateInfo['year'] . '-01-01';
        $dateInfo['lastOfQuarter']  = $dateInfo['year'] . '-03-31';
        $dateInfo['firstOfHalf']    = $dateInfo['year'] . '-01-01';
        $dateInfo['lastOfHalf']     = $dateInfo['year'] . '-06-30';
        break;
    }

    return $dateInfo;
  }
}

if (!function_exists('getWeekday')) {
  //---------------------------------------------------------------------------
  /**
   * Function to get the numeric weekday.
   *
   * @param int|string $year  The year
   * @param int|string $month The month
   * @param int|string $day   The day
   *
   * @return int Numeric representation of the weekday:
   *             1 = Monday,
   *             2 = Tuesday,
   *             ...,
   *             7 = Sunday
   */
  function getWeekday(int|string $year, int|string $month, int|string $day): int {
    $myts = strtotime((string)$year . '-' . (string)$month . '-' . (string)$day);

    return (int)date('N', $myts);
  }
}

if (!function_exists('getWeeknumber')) {
  //---------------------------------------------------------------------------
  /**
   * Function to get the calendar week number.
   *
   * @param int|string $year  The year
   * @param int|string $month The month
   * @param int|string $day   The day
   *
   * @return int Calendar week number
   */
  function getWeeknumber(int|string $year, int|string $month, int|string $day): int {
    $myts = strtotime((string)$year . '-' . (string)$month . '-' . (string)$day);

    return (int)date('W', $myts);
  }
}

if (!function_exists('isWeekend')) {
  //---------------------------------------------------------------------------
  /**
   * Function to check for a weekend day.
   *
   * This function checks whether a given date is a weekend day.
   *
   * @param int|string $year  The year
   * @param int|string $month The month
   * @param int|string $day   The day
   *
   * @return bool
   */
  function isWeekend(int|string $year, int|string $month, int|string $day): bool {
    $myts = strtotime((string)$year . '-' . (string)$month . '-' . (string)$day);
    $wday = (int)date('N', $myts);

    return $wday === 6 || $wday === 7;
  }
}

if (!function_exists('isSaturday')) {
  //---------------------------------------------------------------------------
  /**
   * Function to check whether as given date is a Saturday.
   *
   * @param int|string $year  The year
   * @param int|string $month The month
   * @param int|string $day   The day
   *
   * @return bool
   */
  function isSaturday(int|string $year, int|string $month, int|string $day): bool {
    $myts = strtotime((string)$year . '-' . (string)$month . '-' . (string)$day);

    return (int)date('N', $myts) === 6;
  }
}

if (!function_exists('isSunday')) {
  //---------------------------------------------------------------------------
  /**
   * Function to check whether as given date is a Sunday.
   *
   * @param int|string $year  The year
   * @param int|string $month The month
   * @param int|string $day   The day
   *
   * @return bool
   */
  function isSunday(int|string $year, int|string $month, int|string $day): bool {
    $myts = strtotime((string)$year . '-' . (string)$month . '-' . (string)$day);

    return (int)date('N', $myts) === 7;
  }
}

