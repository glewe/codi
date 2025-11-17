<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials/alert') ?>

  <div class="card">

    <?= $bs->cardHeader(['icon' => 'bi-people-fill', 'title' => lang('Auth.group.groups'), 'help' => getPageHelpUrl(uri_string())]) ?>

    <div class="card-body">

      <?php if (has_permissions('group.create')) { ?>
        <div class="text-end">
          <a href="<?= base_url() ?>/groups/create" class="btn btn-primary"><?= lang('Auth.btn.createGroup') ?></a>
        </div>
      <?php } ?>

      <?php if (!empty($groups) && is_array($groups)) :
        $i = 1; ?>

        <table id="groupList" class="table table-bordered dt-responsive nowrap table-striped align-middle data-table" style="width:100%">
          <thead>
            <tr>
              <th data-ordering="false">#</th>
              <th data-ordering="false">ID</th>
              <th data-ordering="false"><?= lang('Auth.name') ?></th>
              <th data-ordering="false"><?= lang('Auth.description') ?></th>
              <?php if (has_permissions(['group.edit', 'group.delete'])) { ?>
                <th data-ordering="false" class="text-start"><?= lang('Auth.permission.permissions') ?></th>
                <th class="text-center"><?= lang('Auth.btn.action') ?></th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($groups as $group) :
            ?>
              <tr>
                <td class="align-top"><?= $i++ ?></td>
                <td class="align-top"><?= $group->id ?></td>
                <td class="align-top"><?= $group->name ?></td>
                <td class="align-top"><?= $group->description ?></td>
                <?php if (has_permissions(['group.edit', 'group.delete'])) { ?>
                  <td class="align-top">
                    <?php $perms = $groupPermissions[$group->id]; ?>
                    <?php if (!empty($perms[0])): ?>
                      <button class="btn btn-light btn-sm" data-bs-toggle="collapse" data-bs-target="#collapsePermissions<?= $group->id ?>" aria-expanded="false" aria-controls="collapsePermissions<?= $group->id ?>">
                        <?= lang('Auth.role.show_permissions') ?><i class="bi-caret-down-fill ms-2"></i>
                      </button>
                      <div class="collapse" id="collapsePermissions<?= $group->id ?>">
                        <?php
                        foreach ($perms[0] as $perm) :
                          echo $perm->name . '<br>';
                        endforeach;
                        ?>
                      </div>
                      <script>
                        (function() {
                          const collapseElement = document.getElementById('collapsePermissions<?= $group->id ?>');
                          const buttonElement = document.querySelector('button[data-bs-target="#collapsePermissions<?= $group->id ?>"]');
                          collapseElement.addEventListener('shown.bs.collapse', () => {
                            buttonElement.innerHTML = '<?= lang("Auth.role.hide_permissions") ?><i class="bi-caret-up-fill ms-2">';
                          });
                          collapseElement.addEventListener('hidden.bs.collapse', () => {
                            buttonElement.innerHTML = '<?= lang("Auth.role.show_permissions") ?><i class="bi-caret-down-fill ms-2">';
                          });
                        })();
                      </script>
                    <?php else: 
                      echo lang("Auth.group.no_permissions");
                    endif; ?>
                  </td>
                  <td class="text-center align-top">
                    <form name="form_<?= $group->id ?>" action="groups" method="post">
                      <?= csrf_field() ?>
                      <input type="hidden" name="hidden_id" value="<?= $group->id ?>">
                      <button id="action-<?= $group->id ?>" type="button" class="btn btn-light btn-sm dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots align-middle"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="action-<?= $group->id ?>">
                        <?php if (has_permissions('group.edit')) { ?>
                          <a class="dropdown-item" href="groups/edit/<?= $group->id ?>"><i class="bi-pencil-square me-2"></i><?= lang('Auth.btn.edit') ?></a>
                        <?php } ?>
                        <?php if (has_permissions('group.delete')) { ?>
                          <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalDeleteGroup_<?= $group->id ?>"><i class="bi-trash me-2"></i><?= lang('Auth.btn.delete') ?></button>
                        <?php } ?>
                      </div>
                      <?php
                      if (has_permissions('group.delete')) {
                        echo $bs->modal([
                          'id' => 'modalDeleteGroup_' . $group->id,
                          'header' => lang('Auth.modal.confirm'),
                          'header_color' => 'danger',
                          'body' => lang('Auth.group.delete_confirm') . ":<br><br><ul><li><strong>" . $group->name . "</strong></li></ul>",
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

    </div>

  <?php else : ?>

    <div class="alert alert-warning" role="alert">
      <?php
        echo $bs->alertSmall($data = [
          'type' => 'warning',
          'icon' => '',
          'title' => 'Oops',
          'subject' => lang('Auth.group.none_found'),
          'text' => '',
          'help' => '',
          'dismissible' => false,
        ]);
      ?>
    </div>

  <?php endif ?>

  </div>
</div>

<script>
  //
  // DataTables init
  //
  $(document).ready(function() {
    $('#groupList').DataTable({
      "paging": true,
      "ordering": true,
      "info": true,
      "pageLength": 25,
      language: {
        url: '<?= base_url() ?>/addons/datatables/datatables.<?= lang('General.locale') ?>.json'
      },
      <?php if (has_permissions(['group.edit', 'group.delete'])) { ?>
        columnDefs: [{
          targets: [0, 5],
          orderable: false,
          searchable: false
        }]
      <?php } else { ?>
        columnDefs: [{
          targets: [0, 3],
          orderable: false,
          searchable: false
        }]
      <?php } ?>
    });
  });
</script>
<?= $this->endSection() ?>