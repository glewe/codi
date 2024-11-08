<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>

  <form action="<?= base_url() ?>/roles/edit/<?= $role->id ?>" method="post">
    <?= csrf_field() ?>

    <div class="card">

      <?= $bs->cardHeader([ 'icon' => 'bi-person-circle', 'title' => lang('Auth.btn.editRole'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

      <div class="card-body">
        <?php
        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => true,
          'name' => 'name',
          'title' => lang('Auth.role.name'),
          'desc' => lang('Auth.role.name_desc'),
          'errors' => session('errors.name'),
          'value' => $role->name
        ]);

        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => false,
          'name' => 'description',
          'title' => lang('Auth.role.description'),
          'desc' => lang('Auth.role.description_desc'),
          'errors' => session('errors.description'),
          'value' => $role->description
        ]);

        $data = [
          'type' => 'select',
          'subtype' => 'multi',
          'name' => 'sel_permissions',
          'size' => '8',
          'mandatory' => false,
          'title' => lang('Auth.role.permissions'),
          'desc' => lang('Auth.role.permissions_desc'),
          'errors' => session('errors.permissions'),
        ];
        foreach ($permissions as $permission) {
          $data[ 'items' ][] = [
            'selected' => array_key_exists($permission->id, $rolePermissions) ? true : false,
            'title' => $permission->name,
            'value' => $permission->id,
          ];
        }
        echo $bs->formRow($data);

        echo $bs->formRow([
          'type' => 'bscolor',
          'mandatory' => false,
          'name' => 'bscolor',
          'icon' => 'bi bi-person-circle',
          'title' => lang('Auth.role.bscolor'),
          'desc' => lang('Auth.role.bscolor_desc'),
          'errors' => session('errors.bscolor'),
          'checked' => $role->bscolor
        ]);

        ?>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><?= lang('Auth.btn.submit') ?></button>
        <a class="btn btn-secondary float-end" href="<?= base_url() ?>/roles"><?= lang('Auth.btn.cancel') ?></a>
      </div>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
