<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>

  <form action="<?= base_url() ?>/users/create" method="post">
    <?= csrf_field() ?>

    <div class="card">

      <?= $bs->cardHeader([ 'icon' => 'bi-person-fill-add', 'title' => lang('Auth.btn.createUser'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

      <div class="card-body">

        <?php
        echo $bs->formRow([
          'type' => 'email',
          'mandatory' => true,
          'name' => 'email',
          'title' => lang('Auth.user.email'),
          'desc' => lang('Auth.user.email_desc'),
          'errors' => session('errors.email'),
          'value' => old('email')
        ]);

        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => true,
          'name' => 'username',
          'title' => lang('Auth.user.username'),
          'desc' => lang('Auth.user.username_desc'),
          'errors' => session('errors.username'),
          'value' => old('username')
        ]);

        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => false,
          'name' => 'firstname',
          'title' => lang('Auth.user.firstname'),
          'desc' => lang('Auth.user.firstname_desc'),
          'errors' => session('errors.firstname'),
          'value' => old('firstname')
        ]);

        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => false,
          'name' => 'lastname',
          'title' => lang('Auth.user.lastname'),
          'desc' => lang('Auth.user.lastname_desc'),
          'errors' => session('errors.lastname'),
          'value' => old('lastname')
        ]);

        echo $bs->formRow([
          'type' => 'text',
          'mandatory' => false,
          'name' => 'displayname',
          'title' => lang('Auth.user.displayname'),
          'desc' => lang('Auth.user.displayname_desc'),
          'errors' => session('errors.displayname'),
          'value' => old('displayname')
        ]);

        echo $bs->formRow([
          'type' => 'password',
          'mandatory' => true,
          'name' => 'password',
          'title' => lang('Auth.user.password'),
          'desc' => lang('Auth.user.password_desc'),
          'errors' => session('errors.password'),
        ]);

        echo $bs->formRow([
          'type' => 'password',
          'mandatory' => true,
          'name' => 'pass_confirm',
          'title' => lang('Auth.user.pass_confirm'),
          'desc' => lang('Auth.user.pass_confirm_desc'),
          'errors' => session('errors.pass_confirm'),
        ]);

        echo $bs->formRow([
          'type' => 'check',
          'mandatory' => false,
          'name' => 'pass_resetmail',
          'title' => lang('Auth.user.pass_resetmail'),
          'desc' => lang('Auth.user.pass_resetmail_desc'),
          'errors' => session('errors.pass_resetmail'),
        ]);

        echo $bs->formRow([
          'type' => 'switch',
          'mandatory' => false,
          'name' => 'hidden',
          'title' => lang('Auth.user.hidden'),
          'desc' => lang('Auth.user.hidden_desc'),
          'errors' => session('errors.hidden'),
          'value' => false
        ]);

        ?>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><?= lang('Auth.btn.submit') ?></button>
        <a class="btn btn-secondary float-end" href="<?= base_url() ?>/users"><?= lang('Auth.btn.cancel') ?></a>
      </div>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
