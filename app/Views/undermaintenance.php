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
    <div class="card-body row">
      <div class="col-lg-2 text-center">
        <script src="https://cdn.lordicon.com/lordicon.js"></script>
        <lord-icon
          src="https://cdn.lordicon.com/jdalicnn.json"
          trigger="loop"
          delay="1000"
          state="loop-oscillate"
          colors="primary:#004c8b,secondary:#d77c00"
          style="width:100px;height:100px">
        </lord-icon>
      </div>
      <div class="col-lg-10">
        <h4><?= lang('App.maintenance.title') ?></h4>
        <p><?= lang('App.maintenance.text') ?></p>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
