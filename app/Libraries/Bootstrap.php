<?php

declare(strict_types=1);

namespace App\Libraries;

/**
 * ============================================================================
 * Bootstrap Library for CodeIgniter
 *
 * This library provides a set of functions to generate Bootstrap 5 components.
 * The components are based on Bootstrap 5.3
 *
 * @author  George Lewe <george@lewe.com>
 * @year    2024
 * @link    https://github.com/glewe/bootstrap-codeigniter
 * @version 1.0.0
 * @license The MIT License (MIT)
 * @link    http://opensource.org/licenses/MIT
 * ============================================================================
 */
class Bootstrap
{
  public array $color;

  //---------------------------------------------------------------------------
  /**
   * Constructor
   *
   * This function initializes the Bootstrap library.
   * It sets up various color properties required for the library to function correctly.
   */
  public function __construct()
  {
    $this->color = [
      'danger' => [
        'default'       => '#dc3545',
        'text-emphasis' => '#58151c',
        'bg-subtle'     => '#f8d7da',
        'border-subtle' => '#f1aeb5',
      ],
      'dark' => [
        'default'       => '#212529',
        'text-emphasis' => '#495057',
        'bg-subtle'     => '#ced4da',
        'border-subtle' => '#adb5bd',
      ],
      'info' => [
        'default'       => '#0dcaf0',
        'text-emphasis' => '#055160',
        'bg-subtle'     => '#cff4fc',
        'border-subtle' => '#9eeaf9',
      ],
      'light' => [
        'default'       => '#f8f9fa',
        'text-emphasis' => '#495057',
        'bg-subtle'     => '#fcfcfd',
        'border-subtle' => '#e9ecef',
      ],
      'primary' => [
        'default'       => '#0d6efd',
        'text-emphasis' => '#052c65',
        'bg-subtle'     => '#cfe2ff',
        'border-subtle' => '#9ec5fe',
      ],
      'secondary' => [
        'default'       => '#6c757d',
        'text-emphasis' => '#2b2f32',
        'bg-subtle'     => '#e2e3e5',
        'border-subtle' => '#c4c8cb',
      ],
      'success' => [
        'default'       => '#198754',
        'text-emphasis' => '#0a3622',
        'bg-subtle'     => '#d1e7dd',
        'border-subtle' => '#a3cfbb',
      ],
      'warning' => [
        'default'       => '#ffc107',
        'text-emphasis' => '#664d03',
        'bg-subtle'     => '#fff3cd',
        'border-subtle' => '#ffe69c',
      ],
    ];
  }

  //---------------------------------------------------------------------------
  /**
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
   * @return string The HTML string for the alert box.
   */
  public function alert(array $data): string
  {
    $type        = $data['type'];
    $title       = $data['title'];
    $subject     = $data['subject'];
    $text        = $data['text'];
    $help        = $data['help'] ?? '';
    $dismissible = $data['dismissible'] ?? false;

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

    if (strlen((string)$title)) {
      $html .= '
        <h5 class="alert-heading">' . (string)$title . '</h5>
        <hr>';
    }

    if (strlen((string)$subject)) {
      $html .= '<div class="fw-bold">' . (string)$subject . '</div>';
    }

    $html .= '<div>' . (string)$text . '</div>';

    if (strlen((string)$help)) {
      $html .= '
        <hr>
        <p class="fs-6 fst-italic fw-lighter">' . (string)$help . '</p>';
    }

    $html .= '</div>';

    return $html;
  }

  //---------------------------------------------------------------------------
  /**
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
   * @return string The HTML string for the alert box.
   */
  public function alertSmall(array $data): string
  {
    $html = '
      <div class="alert alert-%type% alert-border-left %dismissible%" role="alert">
        <i class="%icon% me-2 align-middle fs-16 pb-1"></i><strong>%title%</strong> %subject%
        %text%
        %help%
        %button%
      </div>';

    $type        = $data['type'];
    $icon        = $data['icon'] ?? '';
    $title       = $data['title'] ?? '';
    $subject     = $data['subject'] ?? '';
    $text        = $data['text'] ?? '';
    $help        = $data['help'] ?? '';
    $dismissible = $data['dismissible'] ?? false;

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

    if (strlen((string)$icon)) {
      $alert_icon = (string)$icon;
    }

    $html = str_replace('%type%', (string)$type, $html);
    $html = str_replace('%icon%', $alert_icon, $html);

    if ($dismissible) {
      $html = str_replace('%dismissible%', 'alert-dismissible fade show', $html);
      $html = str_replace('%button%', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>', $html);
    } else {
      $html = str_replace('%dismissible%', '', $html);
      $html = str_replace('%button%', '', $html);
    }

    if (strlen((string)$title)) {
      $html = str_replace('%title%', (string)$title, $html);
    } else {
      $html = str_replace('%title%', '', $html);
    }

    if (strlen((string)$subject)) {
      $html = str_replace('%subject%', '- ' . (string)$subject, $html);
    } else {
      $html = str_replace('%subject%', '', $html);
    }

    if (strlen((string)$text)) {
      $html = str_replace('%text%', '<p class="mt-2">' . (string)$text . '</p>', $html);
    } else {
      $html = str_replace('%text%', '', $html);
    }

    if (strlen((string)$help)) {
      $html = str_replace('%help%', '<hr><p class="fs-6 fst-italic fw-lighter">' . (string)$help . '</p>', $html);
    } else {
      $html = str_replace('%help%', '', $html);
    }

    return $html;
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a Bootstrap 5 badge with the specified style and text.
   *
   * @param string $style   The type of the badge ('danger', 'dark', 'info', 'light', 'primary', 'secondary', 'success', 'warning').
   * @param string $text    The text to display in the badge.
   * @param bool   $rounded A boolean indicating if the badge should be rounded.
   *
   * @return string HTML for the badge.
   */
  public function badge(string $style, string $text, bool $rounded = false): string
  {
    if ($rounded) {
      return '<span class="badge text-bg-' . $style . ' rounded-pill">' . $text . '</span>';
    }

    return '<span class="badge text-bg-' . $style . '">' . $text . '</span>';
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a card header for the main card on a page.
   *
   * @param array $data The data for the card header
   *                    - 'color': The color of the card header ('danger', 'dark', 'info', 'light', 'primary', 'secondary', 'success', 'warning').
   *                    - 'icon': The icon for the card header.
   *                    - 'title': The title for the card header.
   *                    - 'help': The help link for the card header.
   *
   * @return string HTML for the card header.
   */
  public function cardHeader(array $data): string
  {
    $colorClass = '';

    if (isset($data['color'])) {
      $colorClass = 'text-bg-' . (string)$data['color'];
    }

    return '
      <!-- Card Header: ' . (string)$data['title'] . ' -->
      <div class="card-header ' . $colorClass . '">
        <i class="' . (string)$data['icon'] . ' me-2"></i><strong>' . (string)$data['title'] . '</strong>
        <a href="' . (string)$data['help'] . '" target="_blank" class="float-end ' . $colorClass . '" title="' . lang('Auth.getHelpForPage') . '"><i class="bi-question-circle"></i></a>
      </div>';
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a Bootstrap 5 Figure
   *
   * @param string $imgsrc  Source link to the image
   * @param string $caption Figure caption text
   * @param string $alt     Optional alt text for the image tag (default empty)
   * @param string $width   Optional width for the image tag (default 100%)
   *
   * @return string HTML for the figure.
   */
  public function figure(string $imgsrc, string $caption, string $alt = '', string $width = '100%'): string
  {
    return '
      <figure class="figure">
        <img src="' . $imgsrc . '" class="figure-img img-fluid rounded" alt="' . $alt . '" style="width: ' . $width . '">
        <figcaption class="figure-caption">' . $caption . '</figcaption>
      </figure>';
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a form row with various input types based on the provided data.
   *
   * @param array $data An associative array containing the form group data.
   *
   * @return string The HTML string for the form group.
   */
  public function formRow(array $data): string
  {
    $leftColumnSize  = 7; // Will make right column size 12 - 7 = 5
    $rightColumnSize = 12 - $leftColumnSize;

    $formRowTop = '
      <!-- Form Row: ' . (string)$data['name'] . ' -->
      <div class="row">
        <label class="col-' . $leftColumnSize . ' mb-2" for="' . (string)$data['name'] . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . (string)$data['title'] . '</strong><br>
          <span>' . (string)$data['desc'] . '</span>
        </label>
        <div class="col-' . $rightColumnSize . '">';

    $formRowBottom = '
        ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
        </div>
      </div>';

    $formRowTopWide = '
      <!-- Form Row: ' . (string)$data['name'] . ' -->
      <div class="row">
        <label class="col mb-2" for="' . (string)$data['name'] . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . (string)$data['title'] . '</strong><br>
          <span>' . (string)$data['desc'] . '</span>
        </label><br>';

    $formRowBottomWide = '
        ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
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
          <!-- Form Row: ' . (string)$data['name'] . ' -->
          <div class="row">
            <label class="col-' . $leftColumnSize . '" for="' . (string)$data['name'] . '">
              <strong id="' . (string)$data['name'] . '">' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . (string)$data['title'] . '</strong><br>
              <span>' . (string)$data['desc'] . '</span>
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


  //---------------------------------------------------------------------------
  /**
   * Creates a form row with informational text.
   *
   * @param array $data           The data for the form row.
   * @param int   $leftColumnSize The size of the left column.
   *
   * @return string HTML for the form row.
   */
  public function formRowInfo(array $data, int $leftColumnSize): string
  {
    return '
      <!-- Form Row: ' . (string)($data['name'] ?? '') . ' -->
      <div class="row">
        <label class="col-' . $leftColumnSize . '" for="' . (string)($data['name'] ?? '') . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . (string)($data['title'] ?? '') . '</strong><br>
          <span>' . (string)($data['desc'] ?? '') . '</span>
        </label>
        <div class="col-' . (12 - $leftColumnSize) . ' m-auto" id="' . (string)($data['name'] ?? '') . '">' . (string)($data['value'] ?? '') . '</div>
      </div>
      ';
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a form row with informational text over both columns.
   *
   * @param array $data The data for the form row.
   *
   * @return string HTML for the form row.
   */
  public function formRowInfoWide(array $data): string
  {
    return '
      <!-- Form Row: ' . (string)($data['name'] ?? '') . ' -->
      <div class="row">
        <label class="col" for="' . (string)($data['name'] ?? '') . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . (string)($data['title'] ?? '') . '</strong><br>
          <span>' . (string)($data['desc'] ?? '') . '</span>
        </label>
      </div>
      ';
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a form row with a switch input.
   *
   * @param array $data           The data for the form row.
   * @param int   $leftColumnSize The size of the left column.
   *
   * @return string HTML for the form row.
   */
  public function formRowSwitch(array $data, int $leftColumnSize): string
  {
    return '
      <!-- Form Row: ' . (string)($data['name'] ?? '') . ' -->
      <div class="row">
        <label class="col-' . $leftColumnSize . '" for="' . (string)($data['name'] ?? '') . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . (string)($data['title'] ?? '') . '</strong><br>
          <span>' . (string)($data['desc'] ?? '') . '</span>
        </label>
          <div class="col-' . (12 - $leftColumnSize) . '">
            <div class="form-check form-switch">
              <input
                type="checkbox"
                class="form-check-input"
                id="' . (string)($data['name'] ?? '') . '"
                name="' . (string)($data['name'] ?? '') . '"
                value="' . (string)($data['name'] ?? '') . '"' . ((intval($data['value'] ?? 0)) ? ' checked' : '') . ($data['disabled'] ? ' disabled' : '') . '
              >
              <label class="form-check-label" for="' . (string)($data['name'] ?? '') . '">' . (string)($data['title'] ?? '') . '</label>
              ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
            </div>
          </div>
      </div>
      ';
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a form row with a text input.
   *
   * @param array $data           The data for the form row.
   * @param int   $leftColumnSize The size of the left column.
   *
   * @return string HTML for the form row.
   */
  public function formRowText(array $data, int $leftColumnSize): string
  {
    $data['placeholder'] = (string)($data['placeholder'] ?? '');
    $data['minlength']   = (string)($data['minlength'] ?? '');
    $data['maxlength']   = (string)($data['maxlength'] ?? '');

    return '
      <!-- Form Row: ' . (string)($data['name'] ?? '') . ' -->
      <div class="row">
        <label class="col-' . $leftColumnSize . '" for="' . (string)($data['name'] ?? '') . '">
          <strong>' . (isset($data['mandatory']) && $data['mandatory'] ? '<i class="text-danger">* </i>' : '') . (string)($data['title'] ?? '') . '</strong><br>
          <span>' . (string)($data['desc'] ?? '') . '</span>
        </label>
        <div class="col-' . (12 - $leftColumnSize) . '">
          <input
            type="' . (string)($data['type'] ?? 'text') . '"
            class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
            name="' . (string)($data['name'] ?? '') . '"
            id="' . (string)($data['name'] ?? '') . '"
            value="' . (string)($data['value'] ?? '') . '"
            minlength="' . $data['minlength'] . '"
            maxlength="' . $data['maxlength'] . '"
            placeholder="' . $data['placeholder'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
          >
          ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
        </div>
      </div>
      ';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML checkbox input element with the specified data.
   *
   * @param array $data The data for the checkbox.
   *
   * @return string HTML for the checkbox.
   */
  public function inputCheckbox(array $data): string
  {
    return '
    <div class="form-check">
      <input
        type="checkbox"
        class="form-check-input' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        id="' . (string)($data['name'] ?? '') . '"
        name="' . (string)($data['name'] ?? '') . '"
        value="' . (string)($data['name'] ?? '') . '"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      <label class="form-check-label" for="' . (string)($data['name'] ?? '') . '">' . (string)($data['title'] ?? '') . '</label>
    </div>
    ';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML input element for color selection with the specified data.
   *
   * @param array $data The data for the color input.
   *
   * @return string HTML for the color input.
   */
  public function inputColor(array $data): string
  {
    return '
    <div class="input-group mb-3">
      <span class="input-group-text"><i id="sample-' . (string)($data['name'] ?? '') . '" class="bi-square-fill" style="color: ' . (string)($data['value'] ?? '') . '"></i></span>
      <input
        id="' . (string)($data['name'] ?? '') . '"
        type="text"
        class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        name="' . (string)($data['name'] ?? '') . '"
        value="' . (string)($data['value'] ?? '') . '"
        maxlength="9"' . ($data['disabled'] ? ' disabled' : '') . '
      >
    </div >
    ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
    <script >
      Coloris({
        el: "#' . (string)($data['name'] ?? '') . '",
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

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML input element for date selection with the specified data.
   *
   * @param array $data The data for the date input.
   *
   * @return string HTML for the date input.
   */
  public function inputDate(array $data): string
  {
    return '
    <div class="input-group mb-3">
      <span class="input-group-text"><i class="bi-calendar-date"></i></span>
      <input
        id="' . (string)($data['name'] ?? '') . '"
        type="text"
        class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        name="' . (string)($data['name'] ?? '') . '"
        value="' . (string)($data['value'] ?? '') . '"
        maxlength="10"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
    </div>
    <script>$(function() { $( "#' . (string)($data['name'] ?? '') . '" ).datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd" }); });</script>
    ';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML input element for date and time selection.
   *
   * @param array $data The data for the datetime input.
   *
   * @return string HTML for the datetime input.
   */
  public function inputDateTime(array $data): string
  {
    return '
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="far fa-clock fa-lg"></i></span>
        <input
          id="' . (string)($data['name'] ?? '') . '"
          type="text"
          class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
          name="txt_' . (string)($data['name'] ?? '') . '"
          value="' . (string)($data['value'] ?? '') . '"
          maxlength="16"
          ' . ($data['disabled'] ? ' disabled' : '') . '
          >
        ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
      </div>
      <script>$("#' . (string)($data['name'] ?? '') . '").datetimepicker({format: \'Y-m-d H:i\'});</script>
    ';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML input element for file selection.
   *
   * @param array $data The data for the file input.
   *
   * @return string HTML for the file input.
   */
  public function inputFile(array $data): string
  {
    return '
    <input
      id="' . (string)($data['name'] ?? '') . '"
      type="file"
      class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
      name="' . (string)($data['name'] ?? '') . '"
      accept="' . (string)($data['accept'] ?? '') . '"' . ($data['disabled'] ? ' disabled' : '') . ($data['multiple'] ? ' multiple' : '') . '
    >
    ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '');
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML input element of type number.
   *
   * @param array $data The data for the number input.
   *
   * @return string HTML for the number input.
   */
  public function inputNumber(array $data): string
  {
    $data['placeholder'] = (string)($data['placeholder'] ?? '');
    $data['step']        = (string)($data['step'] ?? '1');

    return '
      <input
        id="' . (string)($data['name'] ?? '') . '"
        type="number"
        class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        step="' . $data['step'] . '"
        name="' . (string)($data['name'] ?? '') . '"
        min="' . (string)($data['min'] ?? '') . '"
        max="' . (string)($data['max'] ?? '') . '"
        value="' . (string)($data['value'] ?? '') . '"
        placeholder="' . $data['placeholder'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
    ';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML password input element.
   *
   * @param array $data The data for the password input.
   *
   * @return string HTML for the password input.
   */
  public function inputPassword(array $data): string
  {
    return '
      <input
        type="password"
        class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
        name="' . (string)($data['name'] ?? '') . '"
        id="' . (string)($data['name'] ?? '') . '"
        autocomplete=off
        readonly
        onfocus="this.removeAttribute(\'readonly\');"
        onblur="this.setAttribute(\'readonly\',\'\');"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
    ';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a set of radio buttons based on the provided data.
   *
   * @param array $data The data for the radio buttons.
   *
   * @return string HTML for the radio buttons.
   */
  public function inputRadio(array $data): string
  {
    $html = '';
    $i    = 1;

    foreach ($data['items'] as $val) {
      $html .= '
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          name="' . (string)($data['name'] ?? '') . '"
          id="' . (string)($data['name'] ?? '') . $i . '"
          value="' . (string)$val['value'] . '"' . ($val['checked'] ? ' checked' : '') . '
        >
        <label class="form-check-label" for="' . (string)($data['name'] ?? '') . $i . '">' . (string)$val['label'] . '</label>
      </div>';
      $i++;
    }

    return $html;
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a set of radio buttons for selecting Bootstrap colors.
   *
   * @param array $data The data for the colors.
   *
   * @return string HTML for the radio buttons.
   */
  public function inputRadioBsColor(array $data): string
  {
    if (!array_key_exists('icon', $data)) {
      $data['icon'] = 'bi bi-square-fill';
    }

    $html = '';
    $i    = 1;

    foreach ($this->color as $key => $value) {
      $html .= '
        <div class="form-check">
          <input
            class="form-check-input"
            type="radio"
            name="' . (string)($data['name'] ?? '') . '"
            id="' . (string)($data['name'] ?? '') . $i . '"
            value="' . (string)$key . '"' . (($data['checked'] === $key) ? ' checked' : '') . '
          >
          <label class="form-check-label" for="' . (string)($data['name'] ?? '') . $i . '"><i class="' . (string)$data['icon'] . ' text-' . (string)$key . '"></i></label>
        </div>';
      $i++;
    }

    return $html;
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML input element of type range.
   *
   * @param array $data The data for the range input.
   *
   * @return string HTML for the range input.
   */
  public function inputRange(array $data): string
  {
    return '
      <input
        type="range"
        class="form-range"
        value="' . (string)($data['value'] ?? '') . '"
        min="' . (string)($data['min'] ?? '') . '"
        max="' . (string)($data['max'] ?? '') . '"
        step="' . (string)($data['step'] ?? '') . '"
        id="' . (string)($data['name'] ?? '') . '"' . ($data['disabled'] ? ' disabled' : '') . '
      >
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
    ';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML select element with the specified data.
   *
   * @param array $data The data for the select element.
   *
   * @return string HTML for the select element.
   */
  public function inputSelect(array $data): string
  {
    $multiple = '';
    $size     = '';

    if (!isset($data['items'])) {
      $data['items'] = [];
    }

    if (($data['subtype'] ?? '') === 'multi') {
      $multiple = ' multiple';

      if (isset($data['size'])) {
        $size = ' size="' . (string)$data['size'] . '"';
      } else {
        $size = ' size="8"';
      }

      $data['name'] .= '[]';
    }

    $html = '
    <select class="form-select"' . $multiple . $size . ' name="' . (string)($data['name'] ?? '') . '" id="' . (string)($data['name'] ?? '') . '"' . ($data['disabled'] ? ' disabled' : '') . '>';

    foreach ($data['items'] as $item) {
      if ($item['selected']) {
        $selected = ' selected';
      } else {
        $selected = '';
      }

      $html .= '<option' . $selected . ' value="' . (string)$item['value'] . '">' . (string)$item['title'] . '</option>';
    }

    $html .= '
      </select>
      ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
    ';

    return $html;
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML switch input element with the specified data.
   *
   * @param array $data The data for the switch input.
   *
   * @return string HTML for the switch input.
   */
  public function inputSwitch(array $data): string
  {
    return '
      <div class="form-check form-switch">
        <input
          type="checkbox"
          class="form-check-input"
          id="' . (string)($data['name'] ?? '') . '"
          name="' . (string)($data['name'] ?? '') . '"
          value="' . (string)($data['name'] ?? '') . '"' . ((intval($data['value'] ?? 0)) ? ' checked' : '') . ($data['disabled'] ? ' disabled' : '') . '
        >
        <label class="form-check-label" for="' . (string)($data['name'] ?? '') . '">' . (string)($data['title'] ?? '') . '</label>
        ' . (isset($data['errors']) ? '<div class="invalid-feedback">' . (string)$data['errors'] . '</div>' : '') . '
      </div>
    ';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates an HTML input element of type text.
   *
   * @param array $data The data for the text input.
   *
   * @return string HTML for the text input.
   */
  public function inputText(array $data): string
  {
    $data['class']       = (string)($data['class'] ?? '');
    $data['placeholder'] = (string)($data['placeholder'] ?? '');
    $data['minlength']   = (string)($data['minlength'] ?? '');
    $data['maxlength']   = (string)($data['maxlength'] ?? '');

    return '
    <input
      type="text"
      class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . ' ' . $data['class'] . '"
      name="' . (string)($data['name'] ?? '') . '"
      id="' . (string)($data['name'] ?? '') . '"
      value="' . (string)($data['value'] ?? '') . '"
      minlength="' . $data['minlength'] . '"
      maxlength="' . $data['maxlength'] . '"
      placeholder="' . $data['placeholder'] . '"' . ($data['disabled'] ? ' disabled' : '') . '
    >';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a textarea HTML element with the specified data.
   *
   * @param array $data The data for the textarea.
   *
   * @return string HTML for the textarea.
   */
  public function inputTextarea(array $data): string
  {
    return '
    <textarea
      class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
      name="' . (string)($data['name'] ?? '') . '"
      id="' . (string)($data['name'] ?? '') . '"
      rows="' . (string)($data['rows'] ?? '3') . '"' . ($data['disabled'] ? ' disabled' : '') . '
    >' . (string)($data['value'] ?? '') . '</textarea>';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a wisywig text editor based on TinyMCE.
   *
   * @param array $data The data for the textarea.
   *
   * @return string HTML for the textarea.
   */
  public function inputTinyMCE(array $data): string
  {
    return '
    <textarea
      class="form-control' . (isset($data['errors']) ? ' is-invalid' : '') . '"
      name="' . (string)($data['name'] ?? '') . '"
      id="' . (string)($data['name'] ?? '') . '"
      rows="' . (string)($data['rows'] ?? '3') . '"' . ($data['disabled'] ? ' disabled' : '') . '
    >' . (string)($data['value'] ?? '') . '</textarea>
    <script>
    tinymce.init({
      selector: \'#' . (string)($data['name'] ?? '') . '\', // Only applies to this textarea
      ' . (isset($data['darkmode']) && $data['darkmode'] ? 'skin: \'oxide-dark\', content_css: \'dark\',' : '') . '
      menubar: false,
      plugins: \'lists link image\',
      toolbar: \'undo redo | bold italic | bullist numlist | link image\'
    });
    </script>';
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a modal dialog.
   *
   * @param array $data The data for the modal dialog.
   *
   * @return string HTML for the modal.
   */
  public function modal(array $data): string
  {
    $id       = (string)($data['id'] ?? '');
    $header   = (string)($data['header'] ?? '');
    $body     = (string)($data['body'] ?? '');
    $btnColor = (string)($data['btn_color'] ?? 'primary');
    $btnName  = (string)($data['btn_name'] ?? '');
    $btnText  = (string)($data['btn_text'] ?? 'Submit');
    $size     = (string)($data['size'] ?? '');

    switch ($size) {
      case 'sm':
        $sizeClass = 'modal-sm';
        break;

      case 'lg':
        $sizeClass = 'modal-lg';
        break;

      case 'xl':
        $sizeClass = 'modal-xl';
        break;

      default:
        $sizeClass = '';
    }

    return '
      <!-- Modal: ' . $id . ' -->
      <div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'Label" aria-hidden="true">
        <div class="modal-dialog ' . $sizeClass . '" role="document">
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

  //---------------------------------------------------------------------------
  /**
   * Creates the top part of a modal dialog.
   *
   * @param string $id    ID of the modal dialog.
   * @param string $title Title of the modal dialog.
   * @param string $size  Size of the modal dialog.
   *
   * @return string HTML for the modal top.
   */
  public function modalTop(string $id, string $title, string $size = ''): string
  {
    switch ($size) {
      case 'sm':
        $sizeClass = 'modal-sm';
        break;

      case 'lg':
        $sizeClass = 'modal-lg';
        break;

      case 'xl':
        $sizeClass = 'modal-xl';
        break;

      default:
        $sizeClass = '';
    }

    return '
      <!-- Modal: ' . $id . ' -->
      <div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'Label" aria-hidden="true">
        <div class="modal-dialog ' . $sizeClass . '" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="' . $id . 'Label">' . $title . '</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">';
  }

  //---------------------------------------------------------------------------
  /**
   * Creates the bottom part of a modal dialog.
   *
   * @param string $buttonID    ID of the button.
   * @param string $buttonColor Color of the button.
   * @param string $buttonText  Text of the button.
   *
   * @return string HTML for the modal bottom.
   */
  public function modalBottom(string $buttonID = '', string $buttonColor = '', string $buttonText = ''): string
  {
    $html = '
            </div>
            <div class="modal-footer">';

    if ($buttonText !== '') {
      $html .= '
              <button type="submit" class="btn btn-sm btn-' . $buttonColor . '" id="' . $buttonID . '" name="' . $buttonID . '">' . $buttonText . '</button>';
    }

    $html .= '
              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      ';

    return $html;
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a navbar item with a dropdown menu.
   *
   * @param array $data  The navbar item data.
   * @param bool  $right Whether to align the dropdown to the right.
   *
   * @return string HTML for the navbar item.
   */
  public function navbarItem(array $data, bool $right = false): string
  {
    $html = '<li class="nav-item dropdown me-2 mt-2">';
    $html .= $this->navbarLink($data['link']);

    $rightClass = $right ? ' dropdown-menu-end' : '';

    $html .= '<ul class="dropdown-menu' . $rightClass . '" aria-labelledby="' . (string)($data['link']['target'] ?? '') . '">';

    foreach ($data['dropdown'] as $sublink) {
      $html .= $this->navbarSublink($sublink);
    }

    $html .= '</ul></li>';

    return $html;
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a navbar link HTML element.
   *
   * @param array $data The link data.
   *
   * @return string HTML for the navbar link.
   */
  public function navbarLink(array $data): string
  {
    return '
      <a class="nav-link dropdown-toggle text-light" href="#" id="' . (string)($data['target'] ?? '') . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span>' . (string)($data['label'] ?? '') . '</span>
      </a>';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a navbar sublink item HTML element.
   *
   * @param array $data The sublink data.
   *
   * @return string HTML for the navbar sublink.
   */
  public function navbarSublink(array $data): string
  {
    if (isset($data['permitted']) && !$data['permitted']) {
      return '';
    }

    if (($data['url'] ?? '') === 'divider') {
      return '<li><hr class="dropdown-divider"></li>';
    }

    return '
  <li>
    <a href="' . (string)($data['url'] ?? '') . '" class="dropdown-item"><i class="' . (string)($data['icon'] ?? '') . ' menu-icon"></i>' . (string)($data['label'] ?? '') . '</a>
  </li>';
  }


  //---------------------------------------------------------------------------
  /**
   * Generates HTML for Bootstrap navigation tabs.
   *
   * @param array $tabs The tab data.
   *
   * @return string HTML for the navigation tabs.
   */
  public function navTabs(array $tabs): string
  {
    $tabsHtml = '<ul class="nav nav-tabs card-header-tabs" id="dialogTabs" role="tablist">';

    foreach ($tabs as $tab) {
      if ($tab['active']) {
        $tabsHtml .= '<li class="nav-item" role="presentation"><a class="nav-link active" id="solid-tab" href="' . (string)($tab['href'] ?? '#') . '" data-bs-toggle="tab" role="tab" aria-controls="solid" aria-selected="true">' . (string)($tab['label'] ?? '') . '</a></li>';
      } else {
        $tabsHtml .= '<li class="nav-item" role="presentation"><a class="nav-link" id="solid-tab" href="' . (string)($tab['href'] ?? '#') . '" data-bs-toggle="tab" role="tab" aria-controls="solid" aria-selected="false">' . (string)($tab['label'] ?? '') . '</a></li>';
      }
    }

    $tabsHtml .= '</ul>';

    return $tabsHtml;
  }

  //---------------------------------------------------------------------------
  /**
   * Retrieves and formats PHP configuration information.
   *
   * @return string HTML for the PHP info.
   */
  public function phpInfo(): string
  {
    $output  = '';
    $rowstart = "<div class='row' style='border-bottom: 1px dotted; margin-bottom: 10px; padding-bottom: 10px;'>\n";
    $rowend   = "</div>\n";

    ob_start();
    phpinfo(11);
    $phpinfo = [];

    if (preg_match_all('#<h2>(?:<a>)?(.*?)(?:</a>)?</h2>|<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>#s', (string)ob_get_clean(), $matches, PREG_SET_ORDER)) {
      foreach ($matches as $match) {
        if (strlen($match[1])) {
          $phpinfo[$match[1]] = [];
        } elseif (isset($match[3])) {
          $keys1                           = array_keys($phpinfo);
          $phpinfo[end($keys1)][$match[2]] = isset($match[4]) ? [$match[3], $match[4]] : $match[3];
        } else {
          $keys1               = array_keys($phpinfo);
          $phpinfo[end($keys1)][] = $match[2];
        }
      }
    }

    if (!empty($phpinfo)) {
      foreach ($phpinfo as $section) {
        foreach ($section as $key => $val) {
          $output .= $rowstart;

          if (is_array($val)) {
            $output .= "<div class='col-lg-4 text-bold'>" . (string)$key . "</div>\n<div class='col-lg-4'>" . (string)$val[0] . "</div>\n<div class='col-lg-4'>" . (string)$val[1] . "</div>\n";
          } elseif (is_string($key)) {
            $output .= "<div class='col-lg-4 text-bold'>" . (string)$key . "</div>\n<div class='col-lg-8'>" . (string)$val . "</div>\n";
          } else {
            $output .= "<div class='col-lg-12'>" . (string)$val . "</div>\n";
          }

          $output .= $rowend;
        }
      }
    } else {
      $output .= '<p>An error occurred executing the phpinfo() function. It may not be accessible or disabled. <a href="https://php.net/manual/en/function.phpinfo.php">See the documentation.</a></p>';
    }

    $output = str_replace('border="0"', 'style="border: 0px;"', $output);
    $output = str_replace('<font ', '<span ', $output);
    $output = str_replace('</font>', '</span>', $output);

    return $output;
  }

  //---------------------------------------------------------------------------
  /**
   * Create a Bootstrap progress bar.
   *
   * @param string $style    BS color of the progress bar.
   * @param string $progress Value between 0 and 100.
   * @param string $label    Label to show on the bar.
   * @param bool   $striped  Show striped bar.
   * @param bool   $animated Show animated (only in combination with striped bar).
   * @param string $height   Custom height of the bar.
   * @param int    $update   Seconds until 100%.
   *
   * @return string HTML for the progress bar.
   */
  public function progressBar(string $style, string $progress, string $label = '', bool $striped = false, bool $animated = false, string $height = '', int $update = 0): string
  {
    $alphanum = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randid   = substr(str_shuffle($alphanum), 0, 32);

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

    $pstriped  = $striped ? 'progress-bar-striped' : '';
    $panimated = $animated ? 'progress-bar-animated' : '';
    $pheight   = (strlen($height)) ? ' style="height:' . $height . '"' : '';
    $plabel    = (strlen($label)) ? $label : '';

    $html = '
      <div class="progress"' . $pheight . '>
        <div id="' . $randid . '" class="progress-bar ' . $pstriped . ' ' . $panimated . ' ' . $pstyle . '" role="progressbar" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $progress . '%">' . $plabel . '</div>
      </div>';

    if ($update) {
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
          .text(current_progress.toFixed(0) + "% Complete");
          if (current_progress >= 100)
            clearInterval(interval);
          }, 1000);
        });
        </script>';
    }

    return $html;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns a random Bootstrap color key.
   *
   * @return string Random color.
   */
  public function randomColor(): string
  {
    /** @var string $key */
    $key = array_rand($this->color);

    return $key;
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a search form.
   *
   * @param string $action Form action.
   * @param string $search Search string.
   *
   * @return string HTML for the search form.
   */
  public function searchForm(string $action, string $search): string
  {
    helper('form');

    $value    = '';
    $disabled = ' disabled';

    if ($search !== '') {
      $value    = $search;
      $disabled = '';
    }

    return '
      <!-- Search Form -->
      ' . form_open($action, ['csrf_id' => 'csrfForm', 'id' => 'data-form', 'class' => 'input-group form-validate', 'name' => 'form_search']) . '
      <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="' . lang('Auth.btn.search') . '..." aria-label="search" aria-describedby="btn_search" value="' . (string)$value . '">
        <button class="input-group-text" type="submit" name="btn_reset" id="btn_reset" title="' . lang('Auth.btn.reset') . '..."' . $disabled . '><i class="bi-backspace-fill text-danger"></i></button>
        <button class="input-group-text" type="submit" name="btn_search" id="btn_search" title="' . lang('Auth.btn.search') . '..."><i class="bi-search text-primary"></i></button>
      </div>' .
      form_close();
  }

  //---------------------------------------------------------------------------
  /**
   * Create a Bootstrap spinner.
   *
   * @param string $type  Spinner type (border or grow).
   * @param string $style BS color.
   * @param bool   $small Whether to show a small spinner.
   * @param string $label Optional label.
   *
   * @return string HTML for the spinner.
   */
  public function spinner(string $type, string $style, bool $small = false, string $label = ''): string
  {
    if (strlen($type) && in_array($type, ['border', 'grow'])) {
      $stype = 'spinner-' . $type;
    } else {
      $stype = 'spinner-border';
    }

    if (strlen($style) && array_key_exists($style, $this->color)) {
      $sstyle = 'text-' . $style;
    } else {
      $sstyle = '';
    }

    $ssmall = $small ? $stype . '-sm' : '';

    return '
      <i class="' . $stype . ' ' . $ssmall . ' ' . $sstyle . '" role="status"></i>';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a sidebar item with a dropdown menu.
   *
   * @param array $data The sidebar item data.
   *
   * @return string HTML for the sidebar item.
   */
  public function sidebarItem(array $data): string
  {
    $html = '<li class="sidebar-item">';
    $html .= $this->sidebarLink($data['link']);
    $html .= '<ul id="' . (string)($data['link']['target'] ?? '') . '" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">';

    foreach ($data['dropdown'] as $sublink) {
      $html .= $this->sidebarSublink($sublink);
    }

    $html .= '</ul></li>';

    return $html;
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a sidebar link.
   *
   * @param array $data The link data.
   *
   * @return string HTML for the sidebar link.
   */
  public function sidebarLink(array $data): string
  {
    return '
      <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#' . (string)($data['target'] ?? '') . '" aria-expanded="false" aria-controls="' . (string)($data['target'] ?? '') . '">
        <i class="' . (string)($data['icon'] ?? '') . '"></i>
        <span>' . (string)($data['label'] ?? '') . '</span>
      </a>';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a sidebar sublink.
   *
   * @param array $data The sublink data.
   *
   * @return string HTML for the sidebar sublink.
   */
  public function sidebarSublink(array $data): string
  {
    if (isset($data['permitted']) && !$data['permitted']) {
      return '';
    }

    return '
    <li class="sidebar-item">
      <a href="' . (string)($data['url'] ?? '') . '" class="sidebar-link sidebar-sublink"><i class="' . (string)($data['icon'] ?? '') . ' menu-icon"></i>' . (string)($data['label'] ?? '') . '</a>
    </li>';
  }

  //---------------------------------------------------------------------------
  /**
   * Generates a Bootstrap toast notification.
   *
   * @param array $data The toast data.
   *
   * @return string HTML for the toast.
   */
  public function toast(array $data): string
  {
    $headerColor = '';
    $bodyColor   = '';
    $icon        = 'bi bi-question-circle';

    if (isset($data['style']) && strlen((string)$data['style'])) {
      $headerColor = 'text-bg-' . (string)$data['style'];
      $bodyColor   = 'bg-' . (string)$data['style'] . '-subtle';

      if (!isset($data['icon']) || !strlen((string)$data['icon'])) {
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
      } else {
        $icon = (string)$data['icon'];
      }
    }

    $time = date('Y-m-d H:i', time());

    if (isset($data['time']) && strlen((string)$data['time'])) {
      $time = (string)$data['time'];
    }

    $delay = 5000;

    if (isset($data['delay']) && (int)$data['delay'] > 0) {
      $delay = (int)$data['delay'];
    }

    return '
      <div id="' . (string)($data['id'] ?? '') . '" class="toast mb-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="' . $delay . '">
        <div class="toast-header ' . $headerColor . '">
          <i class="' . $icon . ' me-2"></i>
          <strong class="me-auto">' . (string)($data['title'] ?? '') . '</strong>
          <small>' . $time . '</small>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body ' . $bodyColor . '">
          ' . (string)($data['message'] ?? '') . '
        </div>
      </div>';
  }

  //---------------------------------------------------------------------------
  /**
   * Return an object with a tooltip.
   *
   * @param string $text     Tooltip text.
   * @param string $title    Tooltip title.
   * @param string $position Position.
   * @param string $style    BS color style.
   * @param string $object   Object content.
   *
   * @return string HTML for the tooltip.
   */
  public function tooltip(string $text = 'Tooltip text', string $title = 'title', string $position = 'top', string $style = 'info', string $object = 'MyTooltip'): string
  {
    $ttText   = '';
    $alphanum = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randid   = substr(str_shuffle($alphanum), 0, 32);

    if (strlen($title)) {
      $ttText .= "<span class='text-bold fs-6' style='padding-top: 4px; padding-bottom: 4px'>" . $title . "</span><br>";
    }

    $ttText .= '<span>' . $text . '</span>';

    return '
      <span class="' . $randid . '">
        <span data-bs-custom-class="tooltip-' . $style . '" data-bs-placement="' . $position . '" data-bs-toggle="tooltip" data-bs-html="true" data-container="' . $randid . '" title="' . $ttText . '">
          ' . $object . '
        </span>
      </span>
      ';
  }

  //---------------------------------------------------------------------------
  /**
   * Return an icon with a tooltip.
   *
   * @param string $text     Tooltip text.
   * @param string $title    Tooltip title.
   * @param string $position Position.
   * @param string $style    BS color style.
   * @param string $icon     Icon class.
   *
   * @return string HTML for the tooltip icon.
   */
  public function tooltipIcon(string $text = 'Tooltip text', string $title = '', string $position = 'top', string $style = '', string $icon = 'bi bi-question-circle'): string
  {
    $ttContainer = '';
    $ttText      = '';
    $alphanum    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randid      = substr(str_shuffle($alphanum), 0, 32);

    if (strlen($title)) {
      $ttText .= "<div class='text-bold fs-6 mb-2'>" . $title . "</div>";
    }

    $ttText .= '<span>' . htmlentities($text) . '</span>';

    if (strlen($style)) {
      $ttContainer = ' data-container=".' . $randid . '"';
    }

    $html = '<span data-bs-custom-class="tooltip-' . (string)$style . '" data-bs-placement="' . $position . '" class ="ms-1 ' . $icon . '" data-bs-toggle="tooltip" data-bs-html="true" title="' . $ttText . '"' . $ttContainer . '></span>';

    if (strlen($style)) {
      $html = '<span class="' . $randid . '">' . $html . '</span>';
    }

    return $html;
  }
}

