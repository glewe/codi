<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>

  <div class="row d-flex justify-content-center align-middle">
    <div class="col-md-6">

      <div class="card">

        <div class="card-header">
          <i class="bi-unlock-fill me-2"></i><strong><?= lang('Auth.login.forgot_password') ?></strong></i>
          <a href="<?= getPageHelpUrl(uri_string()) ?>" target="_blank" class="float-end card-header-help-icon" title="Get help for this page..."><i class="bi-question-circle"></i></a>
        </div>

        <div class="card-body">

          <p><?= lang('Auth.login.enter_email_instructions') ?></p>

          <form action="<?= base_url() ?>forgot" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
              <label for="email"><?= lang('Auth.login.email_address') ?></label>
              <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" id="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.login.email') ?>">
              <div class="invalid-feedback">
                <?= session('errors.email') ?>
              </div>
            </div>

            <br>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary"><?= lang('Auth.login.send_instructions') ?></button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
