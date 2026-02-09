<?php

namespace App\Libraries;

/**
 * Bootstrap Library for CodeIgniter
 *
 * This library provides a set of functions to generate Bootstrap 5 components.
 * The components are based on Bootstrap 5.3.2
 *
 * @author  George Lewe <george@lewe.com>
 * @year    2024
 * @link    https://github.com/glewe/bootstrap-codeigniter
 * @version 1.0.0
 * @license The MIT License (MIT)
 * @link    http://opensource.org/licenses/MIT
 */
class Bootstrap {

  public $color;

  /**
   * --------------------------------------------------------------------------
   * Constructor
   * --------------------------------------------------------------------------
   *
   * This function initializes the Bootstrap library.
   * It sets up various color properties required for the library to function correctly.
   */
  public function __construct() {
    $this->color = array(
      'danger' => array(
        'default' => '#dc3545',
        'text-emphasis' => '#58151c',
        'bg-subtle' => '#f8d7da',
        'border-subtle' => '#f1aeb5',
      ),
      'dark' => array(
        'default' => '#212529',
        'text-emphasis' => '#495057',
        'bg-subtle' => '#ced4da',
        'border-subtle' => '#adb5bd',
      ),
      'info' => array(
        'default' => '#0dcaf0',
        'text-emphasis' => '#055160',
        'bg-subtle' => '#cff4fc',
        'border-subtle' => '#9eeaf9',
      ),
      'light' => array(
        'default' => '#f8f9fa',
        'text-emphasis' => '#495057',
        'bg-subtle' => '#fcfcfd',
        'border-subtle' => '#e9ecef',
      ),
      'primary' => array(
        'default' => '#0d6efd',
        'text-emphasis' => '#052c65',
        'bg-subtle' => '#cfe2ff',
        'border-subtle' => '#9ec5fe',
      ),
      'secondary' => array(
        'default' => '#6c757d',
        'text-emphasis' => '#2b2f32',
        'bg-subtle' => '#e2e3e5',
        'border-subtle' => '#c4c8cb',
      ),
      'success' => array(
        'default' => '#198754',
        'text-emphasis' => '#0a3622',
        'bg-subtle' => '#d1e7dd',
        'border-subtle' => '#a3cfbb',
      ),
      'warning' => array(
        'default' => '#ffc107',
        'text-emphasis' => '#664d03',
        'bg-subtle' => '#fff3cd',
        'border-subtle' => '#ffe69c',
      ),
    );
  }

  /**
   * --------------------------------------------------------------------------
   * Alert
   * --------------------------------------------------------------------------
   *
   * Creates an alert box with the specified data.
   *
   * @param array $data An associative array containing the alert data:
   *                    - 'type': The type of alert ('danger', 'dark', 'info', 'light', 'primary', 'secondary', 'success', 'warning').
   *                    - 'dismissible' (optional): A boolean indicating if the alert is dismissible.
   *                    - 'title' (optional): The header of the alert.
   *                    - 'subject': The subject of the alert.
   *                    - 'text': The main text of the alert.
   *                    - 'help' (optional): Additional help text to display in the alert.
   *
   * @return string The HTML string for the alert box, including a script for auto-closing if applicable.
   *
   * @example
   *  $bs->alert([
   *    'type' => 'info',
   *    'dismissible' => true,
   *    'title' => 'Alert Header',
   *    'subject' => 'Alert Subject',
   *    'text' => 'Alert Text',
   *    'help' => 'Alert Help',
   *  ])
   */
  public function alert($data): string {
    $type = $data['type'];
    $title = $data['title'];
    $subject = $data['subject'];
    $text = $data['text'];
    $help = $data['help'];
    $dismissible = $data['dismissible'];

    $alert_icon = '';
    switch ($type) {
      case 'warning':
        $alert_icon = '<svg class="bi flex-shrink-0 me-2 float-start" width="20" height="20" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle"/></svg>';
        break;
      case 'success':
        $alert_icon = '<svg class="bi flex-shrink-0 me-2 float-start" width="20" height="20" role="img" aria-label="Success:"><use xlink:href="#check-circle"/></svg>';
        break;
      case 'error':
      case 'danger':
        $alert_icon = '<svg class="bi flex-shrink-0 me-2 float-start" width="20" height="20" role="img" aria-label="Danger:"><use xlink:href="#exclamation-octagon"/></svg>';
        break;
      default:
        $alert_icon = '<svg class="bi flex-shrink-0 me-2 float-start" width="20" height="20" role="img" aria-label="Info:"><use xlink:href="#info-circle"/></svg>';
        break;
    }

    $alert_dismissible = '';
    if ($dismissible) {
      $alert_dismissible = 'alert-dismissible alert-' . $type . '-dismissible fade show ';
    }

    $html = '
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
          <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
        </symbol>
        <symbol id="info-circle" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
          <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
        </symbol>
        <symbol id="exclamation-triangle" fill="currentColor" viewBox="0 0 16 16">
          <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
          <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
        </symbol>
        <symbol id="exclamation-octagon" fill="currentColor" viewBox="0 0 16 16">
          <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1z"/>
          <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
        </symbol>
      </svg>
      <div class="alert ' . $alert_dismissible . ' alert-' . $type . '" role="alert">';

    $html .= "\n" . $alert_icon;

    if ($dismissible) {
      $html .= '
        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close" title="' . lang('Auth.btn.close') . '"></button>';
    }

    if (strlen($title)) {
      $html .= '
        <h5 class="alert-heading">' . $title . '</h5>
        <hr>';
    }

    if (strlen($subject)) {
      $html .= '<div class="fw-bold">' . $subject . '</div>';
    }

    $html .= '<div>' . $text . '</div>';

    if (strlen($help)) {
      $html .= '
        <hr>
        <p class="fs-6 fst-italic fw-lighter">' . $help . '</p>';
    }

    $html .= '</div>';

    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Alert Small
   * --------------------------------------------------------------------------
   *
   * Creates a small Bootstrap 5 alert with the specified style and text.
   *
   * @param array $data An associative array containing the alert data:
   *                    - 'type': The type of alert ('danger', 'dark', 'info', 'light', 'primary', 'secondary', 'success', 'warning').
   *                    - 'dismissible' (optional): A boolean indicating if the alert is dismissible.
   *                    - 'icon' (optional): The icon for the alert.
   *                    - 'title' (optional): The header of the alert.
   *                    - 'subject': The subject of the alert.
   *                    - 'text': The main text of the alert.
   *                    - 'help' (optional): Additional help text to display in the alert.
   *
   * @return string The HTML string for the alert box, including a script for auto-closing if applicable.
   *
   * @example
   *   $bs->alert([
   *     'type' => 'info',
   *     'dismissible' => true,
   *     'icon' => 'bi bi-info-circle',
   *     'title' => 'Alert Header',
   *     'subject' => 'Alert Subject',
   *     'text' => 'Alert Text',
   *     'help' => 'Alert Help',
   *   ])
   */
  public function alertSmall($data): string {
    $html = '
      <div class="alert alert-%type% alert-border-left %dismissible%" role="alert">
        <i class="%icon% me-2 align-middle fs-16 pb-1"></i><strong>%title%</strong> %subject%
        %text%
        %help%
        %button%
      </div>';

    $type = $data['type'];
    $icon = $data['icon'];
    $title = $data['title'];
    $subject = $data['subject'];
    $text = $data['text'];
    $help = $data['help'];
    $dismissible = $data['dismissible'];

    $alert_icon = '';
    switch ($type) {
      case 'success':
      case 'check':
        $alert_icon = 'bi bi-check-circle';
        break;
      case 'warning':
      case 'exclamation':
        $alert_icon = 'bi bi-exclamation-triangle';
        break;
      case 'danger':
      case 'error':
        $alert_icon = 'bi bi-radioactive';
        break;
      default:
        $alert_icon = 'bi bi-info-circle';
        break;
    }

    if (strlen($icon)) {
      $alert_icon = $icon;
    }

    $html = str_replace("%type%", $type, $html);
    $html = str_replace("%icon%", $alert_icon, $html);

    if ($dismissible) {
      $html = str_replace("%dismissible%", 'alert-dismissible fade show', $html);
      $html = str_replace("%button%", '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>', $html);
    } else {
      $html = str_replace("%dismissible%", '', $html);
      $html = str_replace("%button%", '', $html);
    }

    if (strlen($title)) {
      $html = str_replace("%title%", $title, $html);
    } else {
      $html = str_replace("%title%", '', $html);
    }

    if (strlen($subject)) {
      $html = str_replace("%subject%", "- " . $subject, $html);
    } else {
      $html = str_replace("%subject%", '', $html);
    }

    if (strlen($text)) {
      $html = str_replace("%text%", '<p class="mt-2">' . $text . "</p>", $html);
    } else {
      $html = str_replace("%text%", '', $html);
    }

    if (strlen($help)) {
      $html = str_replace("%help%", '<hr><p class="fs-6 fst-italic fw-lighter">' . $help . '</p>', $html);
    } else {
      $html = str_replace("%help%", '', $html);
    }

    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Badge
   * --------------------------------------------------------------------------
   *
   * Creates a Bootstrap 5 badge with the specified style and text.
   *
   * @param string $style  The type of the badge ('danger', 'dark', 'info', 'light', 'primary', 'secondary', 'success', 'warning').
   * @param string $text   The text to display in the badge.
   * @param bool   $rounded A boolean indicating if the badge should be rounded.
   *
   * @return string
   *
   * @example
   *   $bs->badge('danger', 'My Badge', true)
   */
  public function badge($style, $text, $rounded = false): string {
    if ($rounded) {
      return '<span class="badge text-bg-' . $style . ' rounded-pill">' . $text . '</span>';
    } else {
      return '<span class="badge text-bg-' . $style . '">' . $text . '</span>';
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Car Header
   * --------------------------------------------------------------------------
   *
   * Creates a card header for the main card on a page.
   *
   * @param array $data The data for the card header
   *                    - 'color': The color of the card header ('danger', 'dark', 'info', 'light', 'primary', 'secondary', 'success', 'warning').
   *                    - 'icon': The icon for the card header.
   *                    - 'title': The title for the card header.
   *                    - 'help': The help link for the card header.
   *
   * @return string
   *
   * @example
   * $bs->cardHeader([
   *   'icon' => 'bi-question-circle-fill',
   *   'title' => lang('App.about.about') . ' ' . config('AppInfo')->name,
   *   'help' => getPageHelpUrl(uri_string())
   * ])
   */
  public function cardHeader($data): string {
    $colorClass = '';
    if (isset($data['color'])) {
      $colorClass = 'text-bg-' . $data['color'];
    }
    return '
      <!-- Card Header: ' . $data['title'] . ' -->
      <div class="card-header ' . $colorClass . '">
        <i class="' . $data['icon'] . ' me-2"></i><strong>' . $data['title'] . '</strong>
        <a href="' . $data['help'] . '" target="_blank" class="float-end ' . $colorClass . '" title="' . lang('Auth.getHelpForPage') . '"><i class="bi-question-circle"></i></a>
      </div>';
  }

  /**
   * --------------------------------------------------------------------------
   * Figure
   * --------------------------------------------------------------------------
   *
   * Creates a Bootstrap 5 Figure
   *
   * @param string $imgsrc  Source link to the image
   * @param string $caption Figure caption text
   * @param string $alt     Optional alt text for the image tag (default empty)
   * @param string $width   Optional width for the image tag (default 100%)
   *
   * @return string
   */
  public function figure($imgsrc, $caption, $alt = '', $width = '100%'): string {
    return '
      <figure class="figure">
        <img src="' . $imgsrc . '" class="figure-img img-fluid rounded" alt="' . $alt . '" style="width: ' . $width . '">
        <figcaption class="figure-caption">' . $caption . '</figcaption>
      </figure>';
  }

  /**
   * --------------------------------------------------------------------------
   * Form Row
   * --------------------------------------------------------------------------
   *
   * Creates a form row with various input types based on the provided data. It
   * call class functions for each type of input type.
   *
   * @param array $data An associative array containing the form group data:
   *
   * @return string The HTML string for the form group.
   *
   */
  public function formRow($data) {
    $leftColumnSize = 7; // Will make right column size 12 - 7 = 5
    $rightColumnSize = 12 - $leftColumnSize;

    $formRowTop = '
      <!-- Form Row: ' . $data['name'] . ' -->
      <div class="row">
        <label class="col-' . $leftColumnSize . ' mb-2" for="' . $data['name'] . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . $data['title'] . '</strong><br>
          <span>' . $data['desc'] . '</span>
        </label>
        <div class="col-' . $rightColumnSize . '">';

    $formRowBottom = '
        ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
        </div>
      </div>';

    $formRowTopWide = '
      <!-- Form Row: ' . $data['name'] . ' -->
      <div class="row">
        <label class="col mb-2" for="' . $data['name'] . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . $data['title'] . '</strong><br>
          <span>' . $data['desc'] . '</span>
        </label><br>';

    $formRowBottomWide = '
        ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
      </div>';

    if (!isset($data['disabled'])) {
      $data['disabled'] = false;
    }

    switch ($data['type']) {

      case 'bscolor':
        $html = $formRowTop . $this->inputRadioBsColor($data) . $formRowBottom;
        break;

      case 'check':
      case 'checkbox':
        $html = $formRowTop . $this->inputCheckbox($data) . $formRowBottom;
        break;

      case 'color':
        $html = $formRowTop . $this->inputColor($data) . $formRowBottom;
        break;

      case 'date':
        $html = $formRowTop . $this->inputDate($data) . $formRowBottom;
        break;

      case 'datetime':
        $html = $formRowTop . $this->inputDateTime($data) . $formRowBottom;
        break;

      case 'email':
      case 'text':
        $html = $formRowTop . $this->inputText($data) . $formRowBottom;
        break;

      case 'file':
        $html = $formRowTop . $this->inputFile($data) . $formRowBottom;
        break;

      case 'info':
        $html = $this->formRowInfo($data, $leftColumnSize);
        break;

      case 'infowide':
        $html = $this->formRowInfoWide($data);
        break;

      case 'number':
        $html = $formRowTop . $this->inputNumber($data) . $formRowBottom;
        break;

      case 'password':
        $html = $formRowTop . $this->inputPassword($data) . $formRowBottom;
        break;

      case 'radio':
        $html = $formRowTop . $this->inputRadio($data) . $formRowBottom;
        break;

      case 'range':
        $html = $formRowTop . $this->inputRange($data) . $formRowBottom;
        break;

      case 'select':
        $html = $formRowTop . $this->inputSelect($data) . $formRowBottom;
        break;

      case 'switch':
        $html = $formRowTop . $this->inputSwitch($data) . $formRowBottom;
        break;

      case 'textarea':
        $html = $formRowTop . $this->inputTextarea($data) . $formRowBottom;
        break;

      case 'textareawide':
        $html = $formRowTopWide . $this->inputTextarea($data) . $formRowBottomWide;
        break;

      case 'tinymce':
        $html = $formRowTopWide . $this->inputTinyMCE($data) . $formRowBottomWide;
        break;

      default:
        //
        // Unknown form type
        //
        $html = '
          <!-- Form Row: ' . $data['name'] . ' -->
          <div class="row">
            <label class="col-' . $leftColumnSize . '" for="' . $data['name'] . '">
              <strong id="' . $data['name'] . '">' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . $data['title'] . '</strong><br>
              <span>' . $data['desc'] . '</span>
            </label>
            <div class="col-' . (12 - $leftColumnSize) . '">
              Unknown form type
            </div>
          </div>
          ';
        break;
    }

    if (!isset($data['ruler']) || $data['ruler']) {
      $html .= '<hr class="my-4">';
    }

    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Form Row Info
   * --------------------------------------------------------------------------
   *
   * Creates a form row with informational text.
   *
   * This function generates a form row that displays informational text.
   *
   * @param array $data           The data for the form row
   *                              - 'desc' (string): Description of the element on the form
   *                              - 'mandatory' (bool): Whether the element is mandatory (adds a red star to the title)
   *                              - 'name' (string): Name of the element to access it by in the controller
   *                              - 'title' (string): Title of the element on the form
   *                              - 'value' (string): Information to display in the form row
   * @param int   $leftColumnSize The size of the left column in the form row
   *
   * @return string The HTML for the form row with informational text
   */
  public function formRowInfo($data, $leftColumnSize): string {
    return '
      <!-- Form Row: ' . $data['name'] . ' -->
      <div class="row">
        <label class="col-' . $leftColumnSize . '" for="' . $data['name'] . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . $data['title'] . '</strong><br>
          <span>' . $data['desc'] . '</span>
        </label>
        <div class="col-' . (12 - $leftColumnSize) . ' m-auto" id="' . $data['name'] . '">' . $data['value'] . '</div>
      </div>
      ';
  }

  /**
   * --------------------------------------------------------------------------
   * Form Row Info Wide
   * --------------------------------------------------------------------------
   *
   * Creates a form row with informational text over both columns.
   *
   * @param array $data           The data for the form row
   *                              - 'desc' (string): Description of the element on the form
   *                              - 'mandatory' (bool): Whether the element is mandatory (adds a red star to the title)
   *                              - 'name' (string): Name of the element to access it by in the controller
   *                              - 'title' (string): Title of the element on the form
   *                              - 'value' (string): Information to display in the form row
   *
   * @return string The HTML for the form row with informational text
   */
  public function formRowInfoWide($data): string {
    return '
      <!-- Form Row: ' . $data['name'] . ' -->
      <div class="row">
        <label class="col" for="' . $data['name'] . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . $data['title'] . '</strong><br>
          <span>' . $data['desc'] . '</span>
        </label>
      </div>
      ';
  }

  /**
   * --------------------------------------------------------------------------
   * Form Row Switch
   * --------------------------------------------------------------------------
   *
   * Creates a form row with a switch input.
   *
   * This function generates a form row that includes a switch input field.
   *
   * @param array $data           The data for the form row
   *                              - 'desc' (string): Description of the element on the form
   *                              - 'disabled' (bool): Whether the element is disabled
   *                              - 'errors' (string): Possible errors from the last post
   *                              - 'mandatory' (bool): Whether the element is mandatory (adds a red star to the title)
   *                              - 'name' (string): Name of the element to access it by in the controller
   *                              - 'title' (string): Title of the element on the form
   *                              - 'type' (string): Type of the element ('switch')
   *                              - 'value' (bool): Initial value of the switch input
   * @param int   $leftColumnSize The size of the left column in the form row
   *
   * @return string The HTML for the form row with a switch input
   */
  public function formRowSwitch($data, $leftColumnSize): string {
    return '
      <!-- Form Row: ' . $data['name'] . ' -->
      <div class="row">
        <label class="col-' . $leftColumnSize . '" for="' . $data['name'] . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . $data['title'] . '</strong><br>
          <span>' . $data['desc'] . '</span>
        </label>
          <div class="col-' . (12 - $leftColumnSize) . '">
            <div class="form-check form-switch">
              <input
                type="checkbox"
                class="form-check-input"
                id="' . $data['name'] . '"
                name="' . $data['name'] . '"
                value="' . $data['name'] . '"' . ((intval($data['value'])) ? " checked" : "") . ($data['disabled'] ? ' disabled' : '') . '
              >
              <label class="form-check-label" for="' . $data['name'] . '">' . $data['title'] . '</label>
              ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
            </div>
          </div>
      </div>
      ';
  }

  /**
   * --------------------------------------------------------------------------
   * Form Row Text
   * --------------------------------------------------------------------------
   *
   * Creates a form row with a text input.
   *
   * This function generates a form row that includes a text input field.
   *
   * @param array $data           The data for the form row
   *                              - 'desc' (string): Description of the element on the form
   *                              - 'disabled' (bool): Whether the element is disabled
   *                              - 'errors' (string): Possible errors from the last post
   *                              - 'mandatory' (bool): Whether the element is mandatory (adds a red star to the title)
   *                              - 'name' (string): Name of the element to access it by in the controller
   *                              - 'title' (string): Title of the element on the form
   *                              - 'type' (string): Type of the element ('text')
   *                              - 'value' (string): Initial value of the text input
   *                              - 'placeholder' (string): Placeholder text for the input
   *                              - 'minlength' (int): Minimum length of the input
   *                              - 'maxlength' (int): Maximum length of the input
   * @param int   $leftColumnSize The size of the left column in the form row
   *
   * @return string The HTML for the form row with a text input
   */
  public function formRowText($data, $leftColumnSize): string {
    if (!array_key_exists('placeholder', $data)) {
      $data['placeholder'] = '';
    }
    if (!array_key_exists('minlength', $data)) {
      $data['minlength'] = '';
    }
    if (!array_key_exists('maxlength', $data)) {
      $data['maxlength'] = '';
    }
    return '
      <!-- Form Row: ' . $data['name'] . ' -->
      <div class="row">
        <label class="col-' . $leftColumnSize . '" for="' . $data['name'] . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . $data['title'] . '</strong><br>
          <span>' . $data['desc'] . '</span>
        </label>
        <div class="col-' . (12 - $leftColumnSize) . '">
          <input
            type="' . $data['type'] . '"
            class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
            name="' . $data['name'] . '"
            id="' . $data['name'] . '"
            value="' . $data['value'] . '"
            minlength="' . $data['minlength'] . '"
            maxlength="' . $data['maxlength'] . '"
            placeholder="' . $data['placeholder'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
          >
          ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
        </div>
      </div>
      ';
  }

  /**
   * --------------------------------------------------------------------------
   * Input Checkbox
   * --------------------------------------------------------------------------
   *
   * Generates an HTML checkbox input element with the specified data.
   *
   * This function creates a checkbox input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the checkbox.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the checkbox.
   *                    - 'title': The label text for the checkbox.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the checkbox should be disabled.
   *
   * @return string The HTML string for the checkbox input element.
   */
  public function inputCheckbox($data): string {
    return '
    <div class="form-check">
      <input
        type="checkbox"
        class="form-check-input' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        id="' . $data['name'] . '"
        name="' . $data['name'] . '"
        value="' . $data['name'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      <label class="form-check-label" for="' . $data['name'] . '">' . $data['title'] . '</label>
    </div>
    ';
  }

  /**
   * --------------------------------------------------------------------------
   * Input Color
   * --------------------------------------------------------------------------
   *
   * Generates an HTML input element for color selection with the specified data.
   *
   * This function creates a color input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   * The Coloris JavaScript library is used for the color picker functionality.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the input.
   *                    - 'value': The initial value of the input.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the input should be disabled.
   *
   * @return string The HTML string for the color input element.
   */
  public function inputColor($data): string {
    return '
    <div class="input-group mb-3">
      <span class="input-group-text"><i id="sample-' . $data['name'] . '" class="bi-square-fill" style="color: ' . $data['value'] . '"></i></span>
      <input
        id="' . $data['name'] . '"
        type="text"
        class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        name="' . $data['name'] . '"
        value="' . $data['value'] . '"
        maxlength="9"' . ($data['disabled'] ? ' disabled' : '') . '
      >
    </div >
    ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
    <script >
      Coloris({
        el: "#' . $data['name'] . '",
        wrap: false,
        theme: "polaroid",
        themeMode: "dark",
        alpha: true,
        format: "hex",
        onChange: function (color, input) {
          var sample = input.previousElementSibling; // This is the span.input-group-text
          if (sample && sample.firstElementChild) {
            sample.firstElementChild.style.color = color;
          }
        }
      });
    </script>
    ';
  }

  /**
   * --------------------------------------------------------------------------
   * Input Date
   * --------------------------------------------------------------------------
   *
   * Generates an HTML input element for date selection with the specified data.
   *
   * This function creates a date input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   * The jQuery UI library is used for the date picker functionality.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the input.
   *                    - 'value': The initial value of the input.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the input should be disabled.
   *
   * @return string The HTML string for the date input element.
   */
  public function inputDate($data): string {
    return '
    <div class="input-group mb-3">
      <span class="input-group-text"><i class="bi-calendar-date"></i></span>
      <input
        id="' . $data['name'] . '"
        type="text"
        class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        name="' . $data['name'] . '"
        value="' . $data['value'] . '"
        maxlength="10"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
    </div>
    <script>$(function() { $( "#' . $data['name'] . '" ).datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd" }); });</script>
    ';
  }

  /**
   * --------------------------------------------------------------------------
   * Input DateTime
   * --------------------------------------------------------------------------
   *
   * Generates an HTML input element for date and time selection with the specified data.
   *
   * This function creates a date and time input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   * The jQuery DateTimePicker library is used for the date and time picker functionality.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the input.
   *                    - 'value': The initial value of the input.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the input should be disabled.
   *
   * @return string The HTML string for the date and time input element.
   */
  public function inputDateTime($data): string {
    return '
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="far fa-clock fa-lg"></i></span>
        <input
          id="' . $data['name'] . '"
          type="text"
          class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
          name="txt_' . $data['name'] . '"
          value="' . $data['value'] . '"
          maxlength="16"
          ' . ($data['disabled'] ? ' disabled' : '') . '
          >
        ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
      </div>
      <script>$("#' . $data['name'] . '").datetimepicker({format: \'Y-m-d H:i\'});</script>
    ';
  }

  /**
   * --------------------------------------------------------------------------
   * Input File
   * --------------------------------------------------------------------------
   *
   * Generates an HTML input element for file selection with the specified data.
   *
   * This function creates a file input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'type': The type attribute for the input (should be 'file').
   *                    - 'name': The name attribute for the input.
   *                    - 'accept': The accepted file types for the input.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the input should be disabled.
   *                    - 'multiple' (optional): A boolean allowing multiple files for upload.
   *
   * @return string The HTML string for the file input element.
   */
  public function inputFile($data): string {
    return '
    <input
      id="' . $data['name'] . '"
      type="file"
      class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
      name="' . $data['name'] . '"
      accept="' . $data['accept'] . '"' . ($data['disabled'] ? ' disabled' : '') . ($data['multiple'] ? ' multiple' : '') . '
    >
    ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '');
  }

  /**
   * --------------------------------------------------------------------------
   * Input Number
   * --------------------------------------------------------------------------
   *
   * Generates an HTML input element of type number with the specified data.
   *
   * This function creates a number input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the input.
   *                    - 'id': The id attribute for the input.
   *                    - 'min': The minimum value for the input.
   *                    - 'max': The maximum value for the input.
   *                    - 'step': The step value for the input.
   *                    - 'value': The initial value of the input.
   *                    - 'placeholder' (optional): The placeholder text for the input.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the input should be disabled.
   *                    - 'class' (optional): Additional CSS classes for the input.
   *
   * @return string The HTML string for the number input element.
   */
  public function inputNumber($data): string {
    if (!array_key_exists('placeholder', $data)) {
      $data['placeholder'] = '';
    }
    if (!array_key_exists('step', $data)) {
      $data['step'] = 1;
    }
    return '
      <input
        id="' . $data['name'] . '"
        type="number"
        class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        step="' . $data['step'] . '"
        name="' . $data['name'] . '"
        min="' . $data['min'] . '"
        max="' . $data['max'] . '"
        value="' . $data['value'] . '"
        placeholder="' . $data['placeholder'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
    ';
  }

  /**
   * --------------------------------------------------------------------------
   * Input Password
   * --------------------------------------------------------------------------
   *
   * Generates an HTML password input element with the specified data.
   *
   * This function creates a password input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the input.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the input should be disabled.
   *
   * @return string The HTML string for the password input element.
   */
  public function inputPassword($data): string {
    return '
      <input
        type="password"
        class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        name="' . $data['name'] . '"
        id="' . $data['name'] . '"
        autocomplete=off
        readonly
        onfocus="this.removeAttribute(\'readonly\');"
        onblur="this.setAttribute(\'readonly\',\'\');"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
    ';
  }

  /**
   * --------------------------------------------------------------------------
   * Input Radio
   * --------------------------------------------------------------------------
   *
   * Generates a set of radio buttons based on the provided data.
   *
   * This function creates a series of radio button inputs, each representing a value from the provided data.
   * It includes error handling and marks the selected radio button as checked.
   *
   * @param array $data   An associative array containing the input data:
   *                      - 'name': The name attribute for the radio buttons.
   *                      - 'value': An array of radio button values and labels.
   *                      - 'value': The value attribute for the radio button.
   *                      - 'label': The label text for the radio button.
   *                      - 'checked' (optional): A boolean indicating if the radio button should be checked.
   *
   * @return string The HTML string for the radio buttons.
   */
  public function inputRadio($data): string {
    $html = '';
    $i = 1;
    foreach ($data['items'] as $val) {
      $html .= '
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          name="' . $data['name'] . '"
          id="' . $data['name'] . $i . '"
          value="' . $val['value'] . '"' . ($val['checked'] ? ' checked' : '') . '
        >
        <label class="form-check-label" for="' . $data['name'] . $i . '">' . $val['label'] . '</label>
      </div>';
      $i++;
    }
    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Input Radio Bootstrap Color
   * --------------------------------------------------------------------------
   *
   * Generates a set of radio buttons for selecting Bootstrap colors.
   *
   * This function creates a series of radio button inputs, each representing a Bootstrap color.
   * It includes an icon for each color and marks the selected color as checked.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the radio buttons.
   *                    - 'checked': The color to be checked.
   *                    - 'icon' (optional): The icon to show in the Bootstrap color (default is 'bi bi-square-fill').
   *
   * @return string The HTML string for the radio buttons.
   */
  public function inputRadioBsColor($data) {
    if (!array_key_exists('icon', $data)) {
      $data['icon'] = 'bi bi-square-fill';
    }
    $html = '';
    $i = 1;
    foreach ($this->color as $key => $value) {
      $html .= '
        <div class="form-check">
          <input
            class="form-check-input"
            type="radio"
            name="' . $data['name'] . '"
            id="' . $data['name'] . $i . '"
            value="' . $key . '"' . (($data['checked'] === $key) ? ' checked' : '') . '
          >
          <label class="form-check-label" for="' . $data['name'] . $i . '"><i class="' . $data['icon'] . ' text-' . $key . '"></i></label>
        </div>';
      $i++;
    }
    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Input Range
   * --------------------------------------------------------------------------
   *
   * Generates an HTML input element of type range with the specified data.
   *
   * This function creates a range input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the input.
   *                    - 'value': The initial value of the input.
   *                    - 'min': The minimum value for the input.
   *                    - 'max': The maximum value for the input.
   *                    - 'step': The step value for the input.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the input should be disabled.
   *
   * @return string The HTML string for the range input element.
   */
  public function inputRange($data): string {
    return '
      <input
        type="range"
        class="form-range"
        value="' . $data['value'] . '"
        min="' . $data['min'] . '"
        max="' . $data['max'] . '"
        step="' . $data['step'] . '"
        id="' . $data['name'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
    ';
  }

  /**
   * --------------------------------------------------------------------------
   * Input Select
   * --------------------------------------------------------------------------
   *
   * Generates an HTML select element with the specified data.
   *
   * This function creates a select input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   *
   * @param array $data   An associative array containing the input data:
   *                      - 'name': The name attribute for the select element.
   *                      - 'subtype' (optional): The subtype of the select element ('multi' for multiple selection).
   *                      - 'size' (optional): The size attribute for the select element (number of visible options).
   *                      - 'items': An array of items for the select element, each item should be an associative array with:
   *                      - 'value': The value attribute for the option element.
   *                      - 'title': The display text for the option element.
   *                      - 'selected' (optional): A boolean indicating if the option should be selected.
   *                      - 'disabled' (optional): A boolean indicating if the select element should be disabled.
   *                      - 'errors' (optional): Any validation errors to display.
   *
   * @return string The HTML string for the select element.
   */
  public function inputSelect($data): string {
    $multiple = '';
    $size = '';
    if (!isset($data['items'])) {
      $data['items'] = array();
    }

    if ($data['subtype'] == 'multi') {
      $multiple = ' multiple';
      if (isset($data['size'])) {
        $size = ' size="' . $data['size'] . '"';
      } else {
        $size = ' size="8"';
      }
      $data['name'] .= "[]";
    }

    $html = '
    <select class="form-select"' . $multiple . $size . ' name="' . $data['name'] . '" id="' . $data['name'] . '"' . ($data['disabled'] ? ' disabled' : '') . '>';

    foreach ($data['items'] as $item) {
      if ($item['selected']) {
        $selected = ' selected';
      } else {
        $selected = '';
      }
      $html .= '<option' . $selected . ' value="' . $item['value'] . '">' . $item['title'] . '</option>';
    }

    $html .= '
      </select>
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
    ';
    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Input Switch
   * --------------------------------------------------------------------------
   *
   * Generates an HTML switch input element with the specified data.
   *
   * This function creates a switch input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the input.
   *                    - 'title': The label text for the input.
   *                    - 'value': The initial value of the input (1 for checked, 0 for unchecked).
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the input should be disabled.
   *
   * @return string The HTML string for the switch input element.
   */
  public function inputSwitch($data): string {
    return '
      <div class="form-check form-switch">
        <input
          type="checkbox"
          class="form-check-input"
          id="' . $data['name'] . '"
          name="' . $data['name'] . '"
          value="' . $data['name'] . '"' . ((intval($data['value'])) ? " checked" : "") . ($data['disabled'] ? ' disabled' : '') . '
        >
        <label class="form-check-label" for="' . $data['name'] . '">' . $data['title'] . '</label>
        ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . $data['errors'] . '</div>' : '') . '
      </div>
    ';
  }

  /**
   * --------------------------------------------------------------------------
   * Input Text
   * --------------------------------------------------------------------------
   *
   * Generates an HTML input element of type text with the specified data.
   *
   * This function creates a text input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the input.
   *
   * @param array $data An associative array containing the input data:
   *                    - 'name': The name attribute for the input.
   *                    - 'id': The id attribute for the input.
   *                    - 'value': The initial value of the input.
   *                    - 'placeholder' (optional): The placeholder text for the input.
   *                    - 'minlength' (optional): The minimum length for the input.
   *                    - 'maxlength' (optional): The maximum length for the input.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the input should be disabled.
   *                    - 'class' (optional): Additional CSS classes for the input.
   *
   * @return string The HTML string for the text input element.
   */
  public function inputText($data): string {
    if (!array_key_exists('class', $data)) {
      $data['class'] = '';
    }
    if (!array_key_exists('placeholder', $data)) {
      $data['placeholder'] = '';
    }
    if (!array_key_exists('minlength', $data)) {
      $data['minlength'] = '';
    }
    if (!array_key_exists('maxlength', $data)) {
      $data['maxlength'] = '';
    }
    return '
    <input
      type="text"
      class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . ' ' . $data['class'] . '"
      name="' . $data['name'] . '"
      id="' . $data['name'] . '"
      value="' . $data['value'] . '"
      minlength="' . $data['minlength'] . '"
      maxlength="' . $data['maxlength'] . '"
      placeholder="' . $data['placeholder'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
    >';
  }

  /**
   * --------------------------------------------------------------------------
   * Textarea
   * --------------------------------------------------------------------------
   *
   * Generates a textarea HTML element with the specified data.
   *
   * This function creates a textarea input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the textarea.
   *
   * @param array $data An associative array containing the textarea data:
   *                    - 'name': The name attribute for the textarea.
   *                    - 'id': The id attribute for the textarea.
   *                    - 'rows': The number of rows for the textarea.
   *                    - 'value': The initial value of the textarea.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the textarea should be disabled.
   *
   * @return string The HTML string for the textarea element.
   */
  public function inputTextarea($data): string {
    return '
    <textarea
      class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
      name="' . $data['name'] . '"
      id="' . $data['name'] . '"
      rows="' . $data['rows'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
    >' . $data['value'] . '</textarea>';
  }

  /**
   * --------------------------------------------------------------------------
   * TinyMCE
   * --------------------------------------------------------------------------
   *
   * Generates a wisywig text editor based on TinyMCE.
   *
   * This function creates a textarea input field with various attributes based on the provided data.
   * It includes error handling and optional disabling of the textarea.
   *
   * @param array $data An associative array containing the textarea data:
   *                    - 'name': The name attribute for the textarea.
   *                    - 'id': The id attribute for the textarea.
   *                    - 'rows': The number of rows for the textarea.
   *                    - 'value': The initial value of the textarea.
   *                    - 'errors' (optional): Any validation errors to display.
   *                    - 'disabled' (optional): A boolean indicating if the textarea should be disabled.
   *                    - 'darkmode' (optional): A boolean indicating dark mode or not.
   *
   * @return string The HTML string for the textarea element.
   */
  public function inputTinyMCE($data): string {
    return '
    <textarea
      class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
      name="' . $data['name'] . '"
      id="' . $data['name'] . '"
      rows="' . $data['rows'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
    >' . $data['value'] . '</textarea>
    <script>
    tinymce.init({
      selector: \'#' . $data['name'] . '\', // Only applies to this textarea
      ' . (isset($data['darkmode']) && $data['darkmode'] ? 'skin: \'oxide-dark\', content_css: \'dark\',' : '') . '
      menubar: false,
      plugins: \'lists link image\',
      toolbar: \'undo redo | bold italic | bullist numlist | link image\'
    });
    </script>';
  }

  /**
   * --------------------------------------------------------------------------
   * Modal Dialog
   * --------------------------------------------------------------------------
   *
   * Creates a modal dialog
   *
   * @param array $data The data for the modal dialog
   *
   * @return string
   */
  public function modal($data): string {
    $id = $data['id'];
    $header = $data['header'];
    $body = $data['body'];
    $btnColor = $data['btn_color'];
    $btnName = $data['btn_name'];
    $btnText = $data['btn_text'];
    if (isset($data['size'])) {
      $size = $data['size'];
    } else {
      $size = '';
    }

    switch ($size) {
      case 'sm':
        $size = 'modal-sm';
        break;
      case 'lg':
        $size = 'modal-lg';
        break;
      case 'xl':
        $size = 'modal-xl';
        break;
      default:
        $size = '';
    }

    return '
      <!-- Modal: ' . $id . ' -->
      <div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'Label" aria-hidden="true">
        <div class="modal-dialog ' . $size . '" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="' . $id . 'Label">' . $header . '</h5>
              <button id="' . $id . 'Label" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
              ' . $body . '
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-sm btn-' . $btnColor . '" name="' . $btnName . '">' . $btnText . '</button>
              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      ';
  }

  /**
   * --------------------------------------------------------------------------
   * Modal Dialog Top part
   * --------------------------------------------------------------------------
   *
   * Creates the top part of a modal dialog
   *
   * @param string $id    ID of the modal dialog
   * @param string $title Title of the modal dialog
   *
   * @return string
   */
  public function modalTop($id, $title, $size = ''): string {
    switch ($size) {
      case 'sm':
        $size = 'modal-sm';
        break;
      case 'lg':
        $size = 'modal-lg';
        break;
      case 'xl':
        $size = 'modal-xl';
        break;
      default:
        $size = '';
    }
    return '
    <div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'Label" aria-hidden="true">
      <div class="modal-dialog ' . $size . '" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">' . $title . '</h5>
          <button id="' . $id . 'Label" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">';
  }

  /**
   * --------------------------------------------------------------------------
   * Modal Dialog Bottom part
   * --------------------------------------------------------------------------
   *
   * Creates the bottom part of a modal dialog
   *
   * @param string $buttonID    ID of the button
   * @param string $buttonColor Color of the button
   * @param string $buttonText  Text of the button
   *
   * @return string
   */
  public function modalBottom($buttonID = '', $buttonColor = '', $buttonText = ''): string {
    $modalbottom = '
    </div>
    <div class="modal-footer">';

    if (strlen($buttonID)) {
      $modalbottom .= '        <button type="submit" class="btn btn-' . $buttonColor . '" name="' . $buttonID . '" style="margin-top: 4px;">' . $buttonText . '</button>';
    }
    $modalbottom .= '        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . lang('Auth.btn.cancel') . '</button>
        </div>
      </div>
      </div>
    </div>';
    return $modalbottom;
  }

  /**
   * --------------------------------------------------------------------------
   * Navbar Item
   * --------------------------------------------------------------------------
   *
   * Generates a navbar item with a dropdown menu.
   *
   * This function creates a navbar item with a link and a dropdown menu.
   * It includes the main link and iterates over the dropdown items to create sublinks.
   *
   * @param array $data  An associative array containing the navbar item data:
   *                     - 'link': An associative array with the main link data.
   *                     - 'dropdown': An array of sublink data for the dropdown menu.
   * @param bool  $right (optional) A boolean indicating if the dropdown menu should be aligned to the right.
   *
   * @return string The HTML string for the navbar item with the dropdown menu.
   */
  public function navbarItem($data, $right = false): string {
    $html = '<li class="nav-item dropdown me-2 mt-2">';
    $html .= $this->navbarLink($data['link']);
    $html .= '<ul class="dropdown-menu' . ($right ? ' dropdown-menu-end' : '') . '" aria-labelledby="' . $data['link']['target'] . '">';
    foreach ($data['dropdown'] as $sublink) {
      $html .= $this->navbarSublink($sublink);
    }
    $html .= '</ul></li>';
    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Navbar Link
   * --------------------------------------------------------------------------
   *
   * Generates a navbar link HTML element.
   *
   * This function creates a navbar link with the specified data.
   * It includes attributes for Bootstrap dropdown functionality.
   *
   * @param array $data An associative array containing the navbar link data:
   *                    - 'target': The target ID for the dropdown.
   *                    - 'label': The label text for the link.
   *
   * @return string The HTML string for the navbar link element.
   */
  public function navbarLink($data): string {
    return '
    <a href="#" class="nav-link dropdown-toggle text-light" id="' . $data['target'] . '" data-bs-toggle="dropdown" aria-expanded="false">
      <span>' . $data['label'] . '</span>
    </a>';
  }

  /**
   * --------------------------------------------------------------------------
   * Navbar Sublink
   * --------------------------------------------------------------------------
   *
   * Generates a navbar sublink item HTML element.
   *
   * This function creates a navbar sublink item with the specified data.
   * It includes a check for permission and handles the special case of a divider.
   *
   * @param array $data An associative array containing the navbar sublink data:
   *                    - 'url': The URL for the navbar sublink.
   *                    - 'icon': The icon class for the navbar sublink.
   *                    - 'label': The label text for the navbar sublink.
   *                    - 'permitted': A boolean indicating if the sublink is permitted.
   *
   * @return string The HTML string for the navbar sublink item.
   */
  public function navbarSublink($data): string {
    if (!$data['permitted']) {
      return '';
    }
    if ($data['url'] === 'divider') {
      return '<li><hr class="dropdown-divider"></li>';
    }
    return '
  <li>
    <a href="' . $data['url'] . '" class="dropdown-item"><i class="' . $data['icon'] . ' menu-icon"></i>' . $data['label'] . '</a>
  </li>';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates HTML for Bootstrap navigation tabs.
   *
   * This function creates a set of Bootstrap navigation tabs based on the provided data.
   *
   * @param array $tabs An array of associative arrays, each containing the tab data:
   *                    - 'active': A boolean indicating if the tab is active.
   *                    - 'href': The URL or anchor link for the tab.
   *                    - 'label': The label text for the tab.
   *
   * @return string The HTML string for the navigation tabs.
   */
  public function navTabs($tabs): string {
    $tabsHtml = '<ul class="nav nav-tabs card-header-tabs" id="dialogTabs" role="tablist">';
    foreach ($tabs as $tab) {
      if ($tab['active']) {
        $tabsHtml .= '<li class="nav-item" role="presentation"><a class="nav-link active" id="solid-tab" href="' . $tab['href'] . '" data-bs-toggle="tab" role="tab" aria-controls="solid" aria-selected="true">' . $tab['label'] . '</a></li>';
      } else {
        $tabsHtml .= '<li class="nav-item" role="presentation"><a class="nav-link" id="solid-tab" href="' . $tab['href'] . '" data-bs-toggle="tab" role="tab" aria-controls="solid" aria-selected="false">' . $tab['label'] . '</a></li>';
      }
    }
    $tabsHtml .= '</ul>';
    return $tabsHtml;
  }

  //---------------------------------------------------------------------------
  /**
   * Retrieves and formats PHP configuration information.
   *
   * This method captures the output of the `phpinfo()` function, parses it, and formats it into HTML.
   * It handles different sections and keys, and applies some HTML fixes to the output.
   *
   * @return string The formatted HTML string containing the PHP configuration information.
   */
  public function phpInfo(): string {
    $output = '';
    $rowstart = "<div class='row' style='border-bottom: 1px dotted; margin-bottom: 10px; padding-bottom: 10px;'>\n";
    $rowend = "</div>\n";
    ob_start();
    phpinfo(11);
    $phpinfo = array();

    /*    if (preg_match_all('#(?:<h2>(?:<a>)?(.*?)(?:</a>)?</h2>)|<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>#s', ob_get_clean(), $matches, PREG_SET_ORDER)) {*/
    if (preg_match_all('#<h2>(?:<a>)?(.*?)(?:</a>)?</h2>|<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>#s', ob_get_clean(), $matches, PREG_SET_ORDER)) {
      foreach ($matches as $match) {
        if (strlen($match[1])) {
          $phpinfo[$match[1]] = array();
        } elseif (isset($match[3])) {
          $keys1 = array_keys($phpinfo);
          $phpinfo[end($keys1)][$match[2]] = isset($match[4]) ? array( $match[3], $match[4] ) : $match[3];
        } else {
          $keys1 = array_keys($phpinfo);
          $phpinfo[end($keys1)][] = $match[2];
        }
      }
    }

    if (!empty($phpinfo)) {
      foreach ($phpinfo as $section) {
        foreach ($section as $key => $val) {
          $output .= $rowstart;
          if (is_array($val)) {
            $output .= "<div class='col-lg-4 text-bold'>" . $key . "</div>\n<div class='col-lg-4'>" . $val[0] . "</div>\n<div class='col-lg-4'>" . $val[1] . "</div>\n";
          } elseif (is_string($key)) {
            $output .= "<div class='col-lg-4 text-bold'>" . $key . "</div>\n<div class='col-lg-8'>" . $val . "</div>\n";
          } else {
            $output .= "<div class='col-lg-12'>" . $val . "</div>\n";
          }
          $output .= $rowend;
        }
      }
    } else {
      $output .= '<p>An error occurred executing the phpinfo() function. It may not be accessible or disabled. <a href="https://php.net/manual/en/function.phpinfo.php">See the documentation.</a></p>';
    }
    //
    // Some HTML fixes
    //
    $output = str_replace('border="0"', 'style="border: 0px;"', $output);
    $output = str_replace("<font ", "<span ", $output);
    $output = str_replace("</font>", "</span>", $output);
    return $output;
  }

  //---------------------------------------------------------------------------
  /**
   * Create a Bootstrap progress bar.
   *
   * @param string $style    BS color of the progress bar
   * @param string $progress Value between 0 and 100
   * @param string $label    Label to show on the bar
   * @param bool   $striped  Show striped bar
   * @param bool   $animated Show animated (only in combination with striped bar)
   * @param string $height   Custom height of the bar
   *
   * @return string HTML snippet
   */
  public function progressBar($style, $progress, $label = '', $striped = false, $animated = false, $height = '', $update = 0): string {
    $alphanum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $randid = substr(str_shuffle($alphanum), 0, 32);

    switch ($style) {
      case 'danger':
        $pstyle = 'bg-danger';
        break;
      case 'info':
        $pstyle = 'bg-info';
        break;
      case 'success':
        $pstyle = 'bg-success';
        break;
      case 'warning':
        $pstyle = 'bg-warning';
        break;
      default:
        $pstyle = '';
        break;
    }

    if ($striped) {
      $pstriped = 'progress-bar-striped';
    } else {
      $pstriped = '';
    }
    if ($animated) {
      $panimated = 'progress-bar-animated';
    } else {
      $panimated = '';
    }
    if (strlen($height)) {
      $pheight = ' style="height:' . $height . '"';
    } else {
      $pheight = '';
    }
    if (strlen($label)) {
      $plabel = $label;
    } else {
      $plabel = '';
    }

    $html = '
      <div class="progress"' . $pheight . '>
        <div id="' . $randid . '" class="progress-bar ' . $pstriped . ' ' . $panimated . ' ' . $pstyle . '" role="progressbar" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $progress . '%">' . $plabel . '</div>
      </div>';

    if ($update) {
      //
      // Update requested. The $update value is the amount of seconds until the progress bar shall show 100%.
      // This will add the jQuery code to update the progress bar every second accordingly.
      //
      $html .= '
        <script>
        var step = 100/' . $update . ';
        $(function() {
          var current_progress = 0;
          var interval = setInterval(function() {
          current_progress += step;
          $("#' . $randid . '")
          .css("width", current_progress + "%")
          .attr("aria-valuenow", current_progress)
          .text(current_progress + "% Complete");
          if (current_progress >= 100)
            clearInterval(interval);
          }, 1000);
        });
        </script>';
    }

    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Random Color.
   * --------------------------------------------------------------------------
   *
   * Returns a random Bootstrap color array object.
   *
   * @return string
   */
  public function randomColor(): string {
    return array_rand($this->color);
  }

  /**
   * --------------------------------------------------------------------------
   * Search Form
   * --------------------------------------------------------------------------
   *
   * Creates a search form to be used on list pages.
   *
   * @param string $action Form action
   * @param string $search Search string
   *
   * @return   string
   */
  public function searchForm($action, $search): string {
    helper('form');

    $value = '';
    $disabled = ' disabled';

    if ($search) {
      $value = $search;
      $disabled = '';
    }

    return '
      <!-- Search Form -->
      ' . form_open($action, [ 'csrf_id' => 'csrfForm', 'id' => 'data-form', 'class' => 'input-group form-validate', 'name' => 'form_search' ]) . '
      <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="' . lang('Auth.btn.search') . '..." aria-label="search" aria-describedby="btn_search" value="' . $value . '">
        <button class="input-group-text" type="submit" name="btn_reset" id="btn_reset" title="' . lang('Auth.btn.reset') . '..."' . $disabled . '><i class="bi-backspace-fill text-danger"></i></button>
        <button class="input-group-text" type="submit" name="btn_search" id="btn_search" title="' . lang('Auth.btn.search') . '..."><i class="bi-search text-primary"></i></button>
      </div>' .
      form_close();
  }

  //---------------------------------------------------------------------------
  /**
   * Create a Bootstrap spinner.
   *
   * @param string $type  Spinner type (border or grow)
   * @param string $style BS color of the progress bar
   * @param string $label Label to show on the bar
   * @param bool   $small Show small spinner
   *
   * @return string
   */
  public function spinner($type, $style, $small = false, $label = ''): string {
    if (strlen($type) && in_array($type, array( 'border', 'grow' ))) {
      $stype = 'spinner-' . $type;
    } else {
      $stype = 'spinner-border';
    }
    if (strlen($style) && array_key_exists($style, $this->color)) {
      $sstyle = 'text-' . $style;
    } else {
      $sstyle = '';
    }
    if ($small) {
      $ssmall = $stype . '-sm';
    } else {
      $ssmall = '';
    }

    return '
      <i class="' . $stype . ' ' . $ssmall . ' ' . $sstyle . '" role="status"></i>';
  }

  /**
   * --------------------------------------------------------------------------
   * Sidebar Item
   * --------------------------------------------------------------------------
   *
   * Generates a sidebar item with a dropdown menu.
   *
   * This function creates a sidebar item with a link and a dropdown menu.
   * It includes the main link and iterates over the dropdown items to create sublinks.
   *
   * @param array $data   An associative array containing the sidebar item data:
   *                      - 'link': An associative array with the main link data:
   *                      - 'target': The target ID for the dropdown.
   *                      - 'dropdown': An array of sublink data for the dropdown menu.
   *
   * @return string The HTML string for the sidebar item with the dropdown menu.
   */
  public function sidebarItem($data): string {
    $html = '<li class="sidebar-item">';
    $html .= $this->sidebarLink($data['link']);
    $html .= '<ul id="' . $data['link']['target'] . '" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">';
    foreach ($data['dropdown'] as $sublink) {
      $html .= $this->sidebarSublink($sublink);
    }
    $html .= '</ul></li>';
    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Sidebar Link
   * --------------------------------------------------------------------------
   *
   * Generates a sidebar-link item HTML element.
   *
   * This function creates a sidebar item with the specified data.
   *
   * @param array $data An associative array containing the sidebar item data:
   *                    - 'url': The URL for the sidebar link.
   *                    - 'icon': The icon class for the sidebar link.
   *                    - 'label': The label text for the sidebar link.
   *                    - 'suffix' (optional): Additional text to append to the label.
   *
   * @return string The HTML string for the sidebar item.
   */
  public function sidebarLink($data): string {
    return '
      <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#' . $data['target'] . '" aria-expanded="false" aria-controls="' . $data['target'] . '">
        <i class="' . $data['icon'] . '"></i>
        <span>' . $data['label'] . '</span>
      </a>';
  }

  /**
   * --------------------------------------------------------------------------
   * Sidebar Sublink
   * --------------------------------------------------------------------------
   *
   * Generates a sidebar-sublink item HTML element.
   *
   * This function creates a sidebar item with the specified data.
   *
   * @param array $data An associative array containing the sidebar item data:
   *                    - 'url': The URL for the sidebar link.
   *                    - 'icon': The icon class for the sidebar link.
   *                    - 'label': The label text for the sidebar link.
   *                    - 'suffix' (optional): Additional text to append to the label.
   *
   * @return string The HTML string for the sidebar item.
   */
  public function sidebarSublink($data): string {
    if (!$data['permitted']) {
      return '';
    }
    return '
    <li class="sidebar-item">
      <a href="' . $data['url'] . '" class="sidebar-link sidebar-sublink"><i class="' . $data['icon'] . ' menu-icon"></i>' . $data['label'] . '</a>
    </li>';
  }

  /**
   * --------------------------------------------------------------------------
   * Toast
   * --------------------------------------------------------------------------
   *
   * Generates a Bootstrap toast notification.
   *
   * This method creates a Bootstrap toast notification with the specified data.
   * It sets the header color, body color, icon, time, and delay based on the provided data.
   *
   * @param array $data An associative array containing the toast data:
   *                    - 'id': The ID of the toast element.
   *                    - 'style' (optional): The style of the toast (e.g., 'danger', 'success', 'warning', 'info').
   *                    - 'icon' (optional): The icon class for the toast.
   *                    - 'title': The title of the toast.
   *                    - 'message': The message to display in the toast.
   *                    - 'time' (optional): The time to display in the toast header.
   *                    - 'delay' (optional): The delay before the toast auto-hides (in milliseconds).
   *
   * Usage on page with PHP ($toasts is an array of toast data):
   * <php
   * if (isset($toasts) && count($toasts)) {
   *   echo '
   *   <!-- Toast Messages -->
   *   <div aria-live="polite" aria-atomic="true" class="position-relative">
   *     <div class="toast-container top-0 end-0 p-3">';
   *   foreach ($toasts as $toast) {
   *     echo $bootstrapService->toast($toast);
   *   }
   *   echo "</div>
   *   </div>
   *   < script >
   *     setTimeout(() => {
   *       const toastElList = document.querySelectorAll('.toast')
   *       toastElList.forEach((ele, index) => {
   *         setTimeout(() => {
   *           const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ele);
   *           toastBootstrap.show();
   *         }, index * 500);
   *       });
   *     }, 500);
   *   < /script >
   *   ";
   *   unset($toasts);
   * }
   * php>
   *
   * @return string The HTML string for the toast notification.
   */
  public function toast($data): string {
    $headerColor = '';
    $bodyColor = '';
    $icon = 'bi bi-question-circle';
    if (isset($data['style']) && strlen($data['style'])) {
      $headerColor = 'text-bg-' . $data['style'];
      $bodyColor = 'bg-' . $data['style'] . '-subtle';
      if (!isset($data['icon']) || !strlen($data['icon'])) {
        switch ($data['style']) {
          case 'danger':
            $icon = 'bi bi-exclamation-octagon';
            break;
          case 'success':
            $icon = 'bi bi-check-circle';
            break;
          case 'warning':
            $icon = 'bi bi-exclamation-triangle';
            break;
          case 'info':
          default:
            $icon = 'bi bi-info-circle';
            break;
        }
      }
    }

    $time = date("Y-m-d H:i", time());
    if (isset($data['time']) && strlen($data['time'])) {
      $time = $data['time'];
    }

    $delay = 5000;
    if (isset($data['delay']) && strlen($data['delay'])) {
      $delay = $data['delay'];
    }

    return '
      <div id="' . $data['id'] . '" class="toast mb-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="' . $delay . '">
        <div class="toast-header ' . $headerColor . '">
          <i class="' . $icon . ' me-2"></i>
          <strong class="me-auto">' . $data['title'] . '</strong>
          <small>' . $time . '</small>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body ' . $bodyColor . '">
          ' . $data['message'] . '
        </div>
      </div>';
  }

  /**
   * --------------------------------------------------------------------------
   * Tooltip
   * --------------------------------------------------------------------------
   *
   * Return an object with a tooltip.
   *
   * @param string $text     Tooltip text (HTML allowed)
   * @param string $title    Tooltip title (HTML allowed)
   * @param string $position Tooltip position (top,right,bottom,left) (Default: top)
   * @param string $style    BS color code (info,success,warning,danger) (Default: info)
   * @param string $object   Text or DOM object for this tooltip
   *
   * @return string
   */
  public function tooltip($text = 'Tooltip text', $title = 'title', $position = 'top', $style = 'info', $object = 'MyTooltip'): string {
    $ttText = '';
    $alphanum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $randid = substr(str_shuffle($alphanum), 0, 32);
    if (strlen($title)) {
      $ttText .= "<span class='text-bold fs-6' style='padding-top: 4px; padding-bottom: 4px'>" . $title . "</span><br>";
    }
    $ttText .= "<span>" . $text . "</span>";
    return '
      <span class="' . $randid . '">
        <span data-bs-custom-class="tooltip-' . $style . '" data-bs-placement="' . $position . '" data-bs-toggle="tooltip" data-bs-html="true" data-container="' . $randid . '" title="' . $ttText . '">
          ' . $object . '
        </span>
      </span>
      ';
  }

  /**
   * --------------------------------------------------------------------------
   * Tooltip Icon
   * --------------------------------------------------------------------------
   *
   * Return a Font Awesome icon with a tooltip.
   *
   * @param string $text     Tooltip text (HTML allowed)
   * @param string $title    Tooltip title (HTML allowed)
   * @param string $position Tooltip position (top,right,bottom,left) (Default: top)
   * @param string $style    BS color code (info,success,warning,danger) (Default: info)
   * @param string $icon     Font Awesome icon to use (Default: question-circle)
   *
   * @return string
   */
  public function tooltipIcon($text = 'Tooltip text', $title = '', $position = 'top', $style = '', $icon = 'bi bi-question-circle'): string {
    $ttContainer = '';
    $ttText = '';
    $alphanum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $randid = substr(str_shuffle($alphanum), 0, 32);
    if (strlen($title)) {
      $ttText .= "<div class='text-bold fs-6 mb-2'>" . $title . "</div>";
    }
    $ttText .= "<span>" . htmlentities($text) . "</span>";
    if (strlen($style)) {
      $ttContainer = ' data-container=".' . $randid . '"';
    }
    $html = '<span data-bs-custom-class="tooltip-' . $style . '" data-bs-placement="' . $position . '" class ="ms-1 ' . $icon . '" data-bs-toggle="tooltip" data-bs-html="true" title="' . $ttText . '"' . $ttContainer . '></span>';
    if (strlen($style)) {
      $html = '<span class="' . $randid . '">' . $html . '</span>';
    }
    return $html;
  }
}
