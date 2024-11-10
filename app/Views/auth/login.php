<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials/alert') ?>

  <div class="row d-flex justify-content-center align-middle">
    <div class="col-md-6">

      <div class="card">

        <div class="card-header">
          <i class="bi-box-arrow-in-right me-2"></i><strong><?= lang('Auth.login.title') ?></strong></i>
          <a href="<?= getPageHelpUrl(uri_string()) ?>" target="_blank" class="float-end card-header-help-icon" title="Get help for this page..."><i class="bi-question-circle"></i></a>
        </div>

        <div class="card-body">

          <form action="<?= base_url() ?>/login" method="post">
            <?= csrf_field() ?>

            <?php if ($authConfig->validFields === [ 'email' ]) : ?>
              <div class="mb-3">
                <label for="email"><?= lang('Auth.login.email') ?></label>
                <input id="email" type="email" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.login.email') ?>">
                <div class="invalid-feedback">
                  <?= session('errors.login') ?>
                </div>
              </div>
            <?php else : ?>
              <div class="mb-3">
                <label for="username"><?= lang('Auth.login.email_or_username') ?></label>
                <input id="username" type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.login.email_or_username') ?>">
                <div class="invalid-feedback">
                  <?= session('errors.login') ?>
                </div>
              </div>
            <?php endif; ?>

            <div class="mb-3">
              <label for="password"><?= lang('Auth.login.password') ?></label>
              <input id="password" type="password" name="password" class="form-control  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.login.password') ?>">
              <div class="invalid-feedback">
                <?= session('errors.password') ?>
              </div>
            </div>

            <?php
            if ($settings['allowRemembering']) : ?>
              <div class="form-check">
                <label for="remember" class="form-check-label">
                  <input id="remember" type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                  <?= lang('Auth.login.remember_me') ?>
                </label>
              </div>
            <?php endif; ?>

            <br>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary"><?= lang('Auth.login.action') ?></button>
            </div>
          </form>

          <hr>

          <?php if ($settings['allowRegistration']) : ?>
            <p><a href="<?= base_url() ?>register"><?= lang('Auth.login.need_an_account') ?></a></p>
          <?php endif; ?>

          <?php if ($authConfig->activeResetter) : ?>
            <p><a href="<?= base_url() ?>forgot"><?= lang('Auth.login.forgot_your_password') ?></a></p>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
