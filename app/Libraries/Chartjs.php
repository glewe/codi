<?php

namespace App\Libraries;

use App\Libraries\Bootstrap;

class Chartjs {

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   */
  public function __construct() {}

  /**
   * --------------------------------------------------------------------------
   * Line Chart.
   * --------------------------------------------------------------------------
   *
   * This method creates a line chart using Chart.js.
   *
   *   $chart = array (
   *      'label' => 'My first Dataset',
   *      'backgroundColor' => '#ff99cc',
   *      'borderColor' => '#aa0000',
   *      'labels' => array ('January', 'February', 'March', 'April', 'May', 'June', 'July'),
   *      'data' => array (0, 10, 5, 2, 20, 30, 45),
   *      'height' => 200
   *   );
   *
   * @param array $chart
   *
   * @return string
   */
  public function lineChart($chart): string {
    $alphanum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $randid = substr(str_shuffle($alphanum), 0, 32);

    //
    // Build labels
    //
    $labels = '';
    foreach ($chart['labels'] as $label) {
      $labels .= "'" . $label . "',";
    }
    $labels = rtrim($labels, ',');

    //
    // Build data
    //
    $vals = '';
    foreach ($chart['data'] as $val) {
      $vals .= $val . ",";
    }
    $vals = rtrim($vals, ',');

    return "
      <div style=\"height:" . $chart['height'] . "px;\">
        <canvas id=\"" . $randid . "\"></canvas>
      </div>
      <script>
        var ctx = document.getElementById('" . $randid . "').getContext('2d');
        var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'line',

          // The data for our dataset
          data: {
            labels: [" . $labels . "],
            datasets: [{
              label: '" . $chart['label'] . "',
              backgroundColor: '" . $chart['backgroundColor'] . "',
              borderColor: '" . $chart['borderColor'] . "',
              data: [" . $vals . "]
            }]
          },

          // Configuration options go here
          options: {
            responsive: true,
            maintainAspectRatio: false
          }
        });
      </script>";
  }
}
