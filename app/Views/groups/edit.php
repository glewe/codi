<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>

  <form action="<?= base_url() ?>/groups/edit/<?= $group->id ?>" method="post">
    <?= csrf_field() ?>

    <div class="card">

      <?= $bs->cardHeader([ 'icon' => 'bi-people-fill', 'title' => lang('Auth.btn.editGroup'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

      <div class="card-body">
        <?php
        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => true,
          'name' => 'name',
          'title' => lang('Auth.group.name'),
          'desc' => lang('Auth.group.name_desc'),
          'errors' => session('errors.name'),
          'value' => $group->name
        ]);

        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => false,
          'name' => 'description',
          'title' => lang('Auth.group.description'),
          'desc' => lang('Auth.group.description_desc'),
          'errors' => session('errors.description'),
          'value' => $group->description
        ]);

        $data = [
          'type' => 'select',
          'subtype' => 'multi',
          'name' => 'sel_permissions',
          'size' => '8',
          'mandatory' => false,
          'title' => lang('Auth.group.permissions'),
          'desc' => lang('Auth.group.permissions_desc'),
          'errors' => session('errors.permissions'),
        ];
        foreach ($permissions as $permission) {
          $data[ 'items' ][] = [
            'selected' => array_key_exists($permission->id, $groupPermissions) ? true : false,
            'title' => $permission->name,
            'value' => $permission->id,
          ];
        }
        echo $bs->formRow($data);
        ?>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><?= lang('Auth.btn.submit') ?></button>
        <a class="btn btn-secondary float-end" href="<?= base_url() ?>/groups"><?= lang('Auth.btn.cancel') ?></a>
      </div>

    </div>
  </form>
</div>

<?= $this->endSection() ?>
