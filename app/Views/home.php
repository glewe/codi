<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>

  <div class="card mb-3">
    <?= $bs->cardHeader([
      'icon' => config('AppInfo')->icon,
      'title' => lang('App.home.welcome_to') . ' ' . config('AppInfo')->name,
      'help' => getPageHelpUrl(uri_string())
    ])
    ?>
    <div class="card-body">

      <?= $settings['welcomeText'] ?>

    </div>
  </div>
</div>

<?= $this->endSection() ?>
