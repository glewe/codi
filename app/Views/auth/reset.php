<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials/alert') ?>

  <div class="row d-flex justify-content-center align-middle">
    <div class="col-md-6">

      <div class="card">

        <div class="card-header">
          <i class="bi-unlock-fill me-2"></i><strong><?= lang('Auth.login.reset_your_password') ?></strong>
          <a href="<?= getPageHelpUrl(uri_string()) ?>" target="_blank" class="float-end card-header-help-icon" title="Get help for this page..."><i class="bi-question-circle"></i></a>
        </div>

        <div class="card-body">
          <p><?= lang('Auth.login.enter_code_email_password') ?></p>

          <form action="<?= base_url() ?>/reset-password" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
              <label for="token"><?= lang('Auth.login.token') ?></label>
              <input type="text" class="form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>" name="token" id="token" placeholder="<?= lang('Auth.login.token') ?>" value="<?= esc(old('token', $token ?? '')) ?>">
              <div class="invalid-feedback">
                <?= session('errors.token') ?>
              </div>
            </div>

            <div class="mb-3">
              <label for="email"><?= lang('Auth.login.email') ?></label>
              <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" id="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.login.email') ?>" value="<?= esc(old('email')) ?>">
              <div class="invalid-feedback">
                <?= session('errors.email') ?>
              </div>
            </div>

            <br>

            <div class="mb-3">
              <label for="password"><?= lang('Auth.login.new_password') ?></label>
              <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" id="password">
              <div class="invalid-feedback">
                <?= session('errors.password') ?>
              </div>
            </div>

            <div class="mb-3">
              <label for="pass_confirm"><?= lang('Auth.login.new_password_repeat') ?></label>
              <input type="password" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" name="pass_confirm" id="pass_confirm">
              <div class="invalid-feedback">
                <?= session('errors.pass_confirm') ?>
              </div>
            </div>

            <br>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.login.reset_password') ?></button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
