<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials/alert') ?>

  <div class="card">

    <?= $bs->cardHeader([ 'icon' => 'bi-key-fill', 'title' => lang('Auth.permission.permissions'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

    <div class="card-body">

      <?php if (has_permissions('permission.create')) { ?>
        <div class="text-end">
          <a href="<?= base_url() ?>/permissions/create" class="btn btn-primary"><?= lang('Auth.btn.createPermission') ?></a>
        </div>
      <?php } ?>

      <?php if (!empty($permissions) && is_array($permissions)) :
        $i = 1;
        ?>

        <table id="permissionList" class="table table-bordered dt-responsive nowrap table-striped align-middle data-table" style="width:100%">
          <thead>
          <tr>
            <th data-ordering="false">#</th>
            <th data-ordering="false">ID</th>
            <th data-ordering="false"><?= lang('Auth.name') ?></th>
            <th data-ordering="false"><?= lang('Auth.description') ?></th>
            <?php if (has_permissions([ 'permissions.edit', 'permissions.delete' ])) { ?>
              <th class="text-center"><?= lang('Auth.btn.action') ?></th>
            <?php } ?>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($permissions as $permission) :
            ?>
            <tr>
              <td class="align-top"><?= $i++ ?></td>
              <td class="align-top"><?= $permission->id ?></td>
              <td class="align-top"><?= $permission->name ?></td>
              <td class="align-top"><?= $permission->description ?></td>
              <?php if (has_permissions([ 'permission.edit', 'permission.delete' ])) { ?>
                <td class="text-center align-top">
                  <form name="form_<?= $permission->id ?>" action="<?= base_url() ?>/permissions" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="hidden_id" value="<?= $permission->id ?>">
                    <button id="action-<?= $permission->id ?>" type="button" class="btn btn-light btn-sm dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots align-middle"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action-<?= $permission->id ?>">
                      <?php if (has_permissions('permission.edit')) { ?>
                        <a class="dropdown-item" href="permissions/edit/<?= $permission->id ?>"><i class="bi-pencil-square me-2"></i><?= lang('Auth.btn.edit') ?></a>
                      <?php } ?>
                      <?php if (has_permissions('permission.delete')) { ?>
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalDeleteRole_<?= $permission->id ?>"><i class="bi-trash me-2"></i><?= lang('Auth.btn.delete') ?></button>
                      <?php } ?>
                    </div>
                    <?php
                    if (has_permissions('permission.delete')) {
                      echo $bs->modal([
                        'id' => 'modalDeletePermission_' . $permission->id,
                        'header' => lang('Auth.modal.confirm'),
                        'header_color' => 'danger',
                        'body' => lang('Auth.permission.delete_confirm') . ":<br><br><ul><li><strong>" . $permission->name . "</strong></li></ul>",
                        'btn_color' => 'danger',
                        'btn_name' => 'btn_delete',
                        'btn_text' => lang('Auth.btn.delete'),
                      ]);
                    } ?>
                  </form>
                </td>
              <?php } ?>
            </tr>

          <?php endforeach; ?>
          </tbody>
        </table>

      <?php else : ?>

        <div class="alert alert-warning" role="alert">
          <?= lang('Auth.permission.none_found') ?>
        </div>

      <?php endif ?>

    </div>
  </div>
</div>

<script>
  //
  // DataTables init
  //
  $(document).ready(function () {
    $('#permissionList').DataTable({
      "paging": true,
      "ordering": true,
      "info": true,
      "pageLength": 25,
      language: {
        url: '<?= base_url() ?>/addons/datatables/datatables.<?= lang('General.locale') ?>.json'
      },
      <?php if (has_permissions([ 'permission.edit', 'permission.delete' ])) { ?>
      columnDefs: [
        {targets: [0, 4], orderable: false, searchable: false}
      ]
      <?php } else { ?>
      columnDefs: [
        {targets: [0, 3], orderable: false, searchable: false}
      ]
      <?php } ?>
    });
  });
</script>
<?= $this->endSection() ?>
