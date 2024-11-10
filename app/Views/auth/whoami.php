<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>
  <?= auth_display() ?>

</div>

<?= $this->endSection() ?>
