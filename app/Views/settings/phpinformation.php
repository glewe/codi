<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>

  <div class="card mb-3">
    <?= $bs->cardHeader([ 'icon' => 'bi-filetype-php', 'title' => lang('App.phpinfo.title'), 'help' => getPageHelpUrl(uri_string()) ]) ?>
    <div class="card-body">
      <?= $output ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
