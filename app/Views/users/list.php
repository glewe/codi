<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>

  <div class="card">

    <?= $bs->cardHeader([ 'icon' => 'bi-person-fill', 'title' => lang('Auth.user.users'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

    <div class="card-body">

      <?php if (has_permissions('user.create')) { ?>
        <div class="text-end">
          <a href="<?= base_url() ?>users/create" class="btn btn-primary"><?= lang('Auth.btn.createUser') ?></a>
        </div>
      <?php } ?>
      <?php if (!empty($users) && is_array($users)) :
        $i = 1; ?>

        <table id="userList" class="table table-bordered dt-responsive nowrap table-striped align-middle data-table" style="width:100%">
          <thead>
          <tr>
            <!-- TODO
            <th scope="col" style="width: 10px;">
              <div class="form-check">
                <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
              </div>
            </th>
            -->
            <th data-ordering="false">#</th>
            <th data-ordering="false">ID</th>
            <th data-ordering="false"><?= lang('Auth.login.username') ?></th>
            <th data-ordering="false"><?= lang('Auth.login.email') ?></th>
            <th data-ordering="false"><?= lang('Auth.group.groups') ?></th>
            <th data-ordering="false"><?= lang('Auth.role.roles') ?></th>
            <?php if (has_permissions([ 'user.edit', 'user.delete' ])) { ?>
              <th><?= lang('Auth.account.account') ?></th>
              <th><?= lang('Auth.user.banned') ?></th>
              <th><?= lang('Auth.2fa.2fa') ?></th>
              <th class="text-center"><?= lang('Auth.btn.action') ?></th>
            <?php } ?>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($users as $user) :
            $userGroups = $user->getGroups();
            $userRoles = $user->getRoles();
            ?>

            <tr>
              <!-- TODO
              <td scope="row">
                <div class="form-check">
                  <input class="form-check-input fs-15" type="checkbox" name="chk_userActive[]" value="option_<?= $user->id ?>">
                </div>
              </td>
              -->
              <td class="align-top"><?= $i++ ?></td>
              <td class="align-top"><?= $user->id ?></td>
              <td class="align-top"><?= $user->username ?></td>
              <td class="align-top"><?= $user->email ?></td>
              <td class="align-top">
                <?php foreach ($userGroups as $group) : echo $group . '<br>'; endforeach; ?>
              </td>
              <td class="align-top">
                <?php foreach ($userRoles as $role) : echo $role . '<br>'; endforeach; ?>
              </td>
              <?php if (has_permissions([ 'user.edit', 'user.delete' ])) { ?>
                <td class="align-top">
                  <?= $user->isActivated() ?
                    '<span class="badge bg-success">' . lang('Auth.user.active') . '</span>' :
                    '<span class="badge bg-light text-dark">' . lang('Auth.user.inactive') . '</span>'
                  ?>
                </td>
                <td class="align-top">
                  <?= $user->isBanned() ?
                    '<span class="badge bg-danger-subtle text-danger">' . lang('Auth.user.banned') . '</span>' :
                    '<span class="badge bg-success-subtle text-success">' . lang('Auth.user.not_banned') . '</span>'
                  ?>
                </td>
                <td class="align-top">
                  <?= $user->hasSecret() ?
                    '<span class="badge bg-success-subtle text-success">' . lang('General.yes') . '</span>' :
                    '<span class="badge bg-warning-subtle text-warning">' . lang('General.no') . '</span>'
                  ?>
                </td>
                <td class="text-center align-top">
                  <form name="form_<?= $user->id ?>" action="<?= base_url() ?>users" method="post">
                    <?= csrf_field() ?>
                    <input name="hidden_id" type="hidden" value="<?= $user->id ?>">
                    <button id="action-<?= $user->id ?>" type="button" class="btn btn-light btn-sm dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots align-middle"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action-<?= $user->id ?>">
                      <?php if (has_permissions('user.edit')) { ?>
                        <a class="dropdown-item" href="users/edit/<?= $user->id ?>"><i class="bi bi-pencil-square me-2"></i><?= lang('Auth.btn.edit') ?></a>
                        <a class="dropdown-item" href="users/profile/<?= $user->id ?>"><i class="bi bi-person-square me-2"></i><?= lang('Auth.btn.editProfile') ?></a>
                      <?php } ?>
                      <?php if ($user->hasSecret() && has_permissions([ 'user.edit' ])) { ?>
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalRemoveSecret_<?= $user->id ?>"><i class="bi bi-shield-x me-2"></i><?= lang('Auth.btn.remove_secret') ?></button>
                      <?php } ?>
                      <?php if (has_permissions([ 'user.delete' ])) { ?>
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalDeleteUser_<?= $user->id ?>"><i class="bi bi-trash align-bottom me-2"></i><?= lang('Auth.btn.delete') ?></button>
                      <?php } ?>
                    </div>
                    <?php
                    if ($user->hasSecret() && has_permissions([ 'user.edit' ])) {
                      echo $bs->modal([
                        'id' => 'modalRemoveSecret_' . $user->id,
                        'header' => lang('Auth.modal.confirm'),
                        'header_color' => 'danger',
                        'body' => lang('Auth.user.remove_secret_confirm') . "<br><br>" . lang('Auth.user.remove_secret_confirm_desc'),
                        'btn_color' => 'danger',
                        'btn_name' => 'btn_remove_secret',
                        'btn_text' => lang('Auth.btn.remove_secret'),
                      ]);
                    }
                    if (has_permissions([ 'user.delete' ])) {
                      echo $bs->modal([
                        'id' => 'modalDeleteUser_' . $user->id,
                        'header' => lang('Auth.modal.confirm'),
                        'header_color' => 'danger',
                        'body' => lang('Auth.user.delete_confirm') . ":<br><br><ul><li><strong>" . $user->username . " (" . $user->email . ")</strong></li></ul>",
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
          <?php
          echo $bs->alertSmall($data = [
            'type' => 'warning',
            'icon' => '',
            'title' => 'Oops',
            'subject' => lang('Auth.user.none_found'),
            'text' => '',
            'help' => '',
            'dismissible' => false,
          ]);
          ?>
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
    $('#userList').DataTable({
      "paging": true,
      "ordering": true,
      "info": true,
      "pageLength": 25,
      language: {
        url: '<?= base_url() ?>/addons/datatables/datatables.<?= lang('General.locale') ?>.json'
      },
      <?php if (has_permissions([ 'user.edit', 'user.delete' ])) { ?>
      columnDefs: [
        {targets: [0, 9], orderable: false, searchable: false}
      ]
      <?php } else { ?>
      columnDefs: [
        {targets: [0, 5], orderable: false, searchable: false}
      ]
      <?php } ?>
    });
  });

  // $('#checkAll').click(function (e) {
  //   var checkBoxes = document.getElementById('userList').querySelectorAll('input[type=checkbox]');
  //   if ($(this).hasClass('checkedAll')) {
  //     $(checkBoxes).prop('checked', false);
  //     $(this).removeClass('checkedAll');
  //   } else {
  //     $(checkBoxes).prop('checked', true);
  //     $(this).addClass('checkedAll');
  //   }
  // });
</script>
<?= $this->endSection() ?>
