<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>

  <form action="<?= base_url() ?>/permissions/create" method="post">
    <?= csrf_field() ?>

    <div class="card">

      <?= $bs->cardHeader([ 'icon' => 'bi-key-fill', 'title' => lang('Auth.btn.createPermission'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

      <div class="card-body row">
        <?php
        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => true,
          'name' => 'name',
          'title' => lang('Auth.permission.name'),
          'desc' => lang('Auth.permission.name_desc'),
          'errors' => session('errors.name'),
          'value' => old('name')
        ]);
        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => false,
          'name' => 'description',
          'title' => lang('Auth.permission.description'),
          'desc' => lang('Auth.permission.description_desc'),
          'errors' => session('errors.description'),
          'value' => old('description')
        ]);
        ?>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><?= lang('Auth.btn.submit') ?></button>
        <a class="btn btn-secondary float-end" href="<?= base_url() ?>/permissions"><?= lang('Auth.btn.cancel') ?></a>
      </div>

    </div>
  </form>
</div>

<?= $this->endSection() ?>
