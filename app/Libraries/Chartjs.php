<?php

declare(strict_types=1);

namespace App\Libraries;

/**
 * ============================================================================
 * Chartjs Library
 * ============================================================================
 */
class Chartjs
{
  //---------------------------------------------------------------------------
  /**
   * Constructor.
   */
  public function __construct()
  {
  }

  //---------------------------------------------------------------------------
  /**
   * This method creates a line chart using Chart.js.
   *
   *   $chart = [
   *      'label'           => 'My first Dataset',
   *      'backgroundColor' => '#ff99cc',
   *      'borderColor'     => '#aa0000',
   *      'labels'          => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
   *      'data'            => [0, 10, 5, 2, 20, 30, 45],
   *      'height'          => 200
   *   ];
   *
   * @param array $chart Array with chart data.
   *
   * @return string HTML for the chart.
   */
  public function lineChart(array $chart): string
  {
    $alphanum = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randid   = substr(str_shuffle($alphanum), 0, 32);

    //
    // Build labels
    //
    $labels = '';

    foreach ($chart['labels'] as $label) {
      $labels .= "'" . (string)$label . "',";
    }

    $labels = rtrim($labels, ',');

    //
    // Build data
    //
    $vals = '';

    foreach ($chart['data'] as $val) {
      $vals .= (string)$val . ',';
    }

    $vals = rtrim($vals, ',');

    return "
      <div style=\"height:" . (string)$chart['height'] . "px;\">
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
              label: '" . (string)$chart['label'] . "',
              backgroundColor: '" . (string)$chart['backgroundColor'] . "',
              borderColor: '" . (string)$chart['borderColor'] . "',
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

