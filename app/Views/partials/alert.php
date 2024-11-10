<!-- Information Alert -->
<?php if (session()->has('message')) :
  echo $bs->alert($data = [
    'type' => 'info',
    'icon' => '',
    'title' => lang('Auth.alert.information'),
    'subject' => session('message'),
    'text' => '',
    'help' => '',
    'dismissible' => true,
  ]);
endif ?>

<!-- Success Alert -->
<?php if (session()->has('success')) :
  echo $bs->alert($data = [
    'type' => 'success',
    'icon' => '',
    'title' => lang('Auth.alert.success'),
    'subject' => session('success'),
    'text' => '',
    'help' => '',
    'dismissible' => true,
  ]);
endif ?>

<!-- Warning Alert -->
<?php if (session()->has('warning')) :
  echo $bs->alert($data = [
    'type' => 'warning',
    'icon' => '',
    'title' => lang('Auth.alert.warning'),
    'subject' => session('warning'),
    'text' => '',
    'help' => '',
    'dismissible' => true,
  ]);
endif ?>

<!-- Single Error Alert -->
<?php if (session()->has('error')) :
  echo $bs->alert($data = [
    'type' => 'danger',
    'icon' => '',
    'title' => lang('Auth.alert.error'),
    'subject' => session('error'),
    'text' => '',
    'help' => '',
    'dismissible' => true,
  ]);
endif ?>

<!-- Multiple Errors Alert -->
<?php if (session()->has('errors')) :
  $text = '<ul>';
  if (is_array(session('errors'))) {
    foreach (session('errors') as $error) {
      $text .= '<li>' . $error . '</li>';
    }
  } else {
    $text .= '<li>' . session('errors') . '</li>';
  }
  $text .= '</ul>';
  echo $bs->alert($data = [
    'type' => 'danger',
    'icon' => '',
    'title' => lang('Auth.alert.error'),
    'subject' => '',
    'text' => $text,
    'help' => '',
    'dismissible' => true,
  ]);
endif ?>
