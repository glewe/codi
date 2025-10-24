<?= $this->extend('layout') ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials/alert') ?>

  <div class="card">

    <?= $bs->cardHeader([ 'icon' => 'bi-person-circle', 'title' => lang('Auth.role.roles'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

    <div class="card-body">

      <?php if (has_permissions('role.create')) { ?>
        <div class="text-end">
          <a href="<?= base_url() ?>/roles/create" class="btn btn-primary"><?= lang('Auth.btn.createRole') ?></a>
        </div>
      <?php } ?>

      <?php if (!empty($roles) && is_array($roles)) :
        $i = 1; ?>

        <table id="roleList" class="table table-bordered dt-responsive nowrap table-striped align-middle data-table" style="width:100%">
          <thead>
          <tr>
            <th data-ordering="false">#</th>
            <th data-ordering="false">ID</th>
            <th data-ordering="false"><?= lang('Auth.name') ?></th>
            <th data-ordering="false"><?= lang('Auth.description') ?></th>
            <?php if (has_permissions([ 'role.edit', 'role.delete' ])) { ?>
              <th data-ordering="false" class="text-start"><?= lang('Auth.permission.permissions') ?></th>
              <th class="text-center"><?= lang('Auth.btn.action') ?></th>
            <?php } ?>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($roles as $role) :
            ?>
            <tr>
              <td class="align-top"><?= $i++ ?></td>
              <td class="align-top"><?= $role->id ?></td>
              <td class="align-top"><i class="bi bi-person-circle text-<?= $role->bscolor ?> me-2"></i><?= $role->name ?></td>
              <td class="align-top"><?= $role->description ?></td>
              <?php if (has_permissions([ 'role.edit', 'role.delete' ])) { ?>
                <td class="align-top">
                  <button class="btn btn-light btn-sm" data-bs-toggle="collapse" data-bs-target="#collapsePermissions<?= $role->id ?>" aria-expanded="false" aria-controls="collapsePermissions<?= $role->id ?>">
                    <?= lang('Auth.role.show_permissions') ?><i class="bi-caret-down-fill ms-2"></i>
                  </button>
                  <div class="collapse" id="collapsePermissions<?= $role->id ?>">
                    <?php
                    $perms = $rolePermissions[$role->id];
                    foreach ($perms[0] as $perm) :
                      echo $perm->name . '<br>';
                    endforeach;
                    ?>
                  </div>
                  <script>
                    var collapseElement<?= $role->id ?> = document.getElementById('collapsePermissions<?= $role->id ?>');
                    var buttonElement<?= $role->id ?> = document.querySelector('button[data-bs-target="#collapsePermissions<?= $role->id ?>"]');
                    collapseElement<?= $role->id ?>.addEventListener('shown.bs.collapse', () => {
                      buttonElement<?= $role->id ?>.innerHTML = '<?= lang("Auth.role.hide_permissions") ?><i class="bi-caret-up-fill ms-2">';
                    });
                    collapseElement<?= $role->id ?>.addEventListener('hidden.bs.collapse', () => {
                      buttonElement<?= $role->id ?>.innerHTML = '<?= lang("Auth.role.show_permissions") ?><i class="bi-caret-down-fill ms-2">';
                    });
                  </script>
                </td>
                <td class="text-center align-top">
                  <form name="form_<?= $role->id ?>" action="<?= base_url() ?>/roles" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="hidden_id" value="<?= $role->id ?>">
                    <button id="action-<?= $role->id ?>" type="button" class="btn btn-light btn-sm dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots align-middle"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action-<?= $role->id ?>">
                      <?php if (has_permissions('role.edit')) { ?>
                        <a class="dropdown-item" href="roles/edit/<?= $role->id ?>"><i class="bi-pencil-square me-2"></i><?= lang('Auth.btn.edit') ?></a>
                      <?php } ?>
                      <?php if (has_permissions('role.delete')) { ?>
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalDeleteRole_<?= $role->id ?>"><i class="bi-trash me-2"></i><?= lang('Auth.btn.delete') ?></button>
                      <?php } ?>
                    </div>
                    <?php
                    if (has_permissions('role.delete')) {
                      echo $bs->modal([
                        'id' => 'modalDeleteRole_' . $role->id,
                        'header' => lang('Auth.modal.confirm'),
                        'header_color' => 'danger',
                        'body' => lang('Auth.role.delete_confirm') . ":<br><br><ul><li><strong>" . $role->name . "</strong></li></ul>",
                        'btn_color' => 'danger',
                        'btn_name' => 'btn_delete',
                        'btn_text' => lang('Auth.btn.delete'),
                      ]);
                    }
                    ?>
                  </form>
                </td>
              <?php } ?>
            </tr>

          <?php endforeach; ?>
          </tbody>
        </table>

      <?php else : ?>

        <div class="alert alert-warning" role="alert">
          <?= lang('Auth.role.none_found') ?>
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
    $('#roleList').DataTable({
      "paging": true,
      "ordering": true,
      "info": true,
      "pageLength": 25,
      language: {
        url: '<?= base_url() ?>/addons/datatables/datatables.<?= lang('General.locale') ?>.json'
      },
      <?php if (has_permissions([ 'role.edit', 'role.delete' ])) { ?>
      columnDefs: [
        {targets: [0, 5], orderable: false, searchable: false}
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
