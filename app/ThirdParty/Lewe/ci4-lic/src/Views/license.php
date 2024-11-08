<?= $this->extend(config('Lic')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="card">

  <?= $bs->cardHeader([ 'icon' => 'bi-vector-pen', 'title' => lang('Lic.license'), 'help' => '#' ]) ?>

  <div class="card-body">

    <?= view('CI4\Auth\Views\_alert') ?>

    <?php if (isset($L->details)) : ?>

      <?php echo $L->show($L->details, true) ?>

    <?php else : ?>

      <?php
      echo $bs->alert($data = [
        'type' => 'warning',
        'icon' => '',
        'title' => lang('Lic.invalid'),
        'subject' => lang('Lic.invalid_subject'),
        'text' => lang('Lic.invalid_text'),
        'help' => lang('Lic.invalid_help'),
        'dismissable' => false,
      ]);
      ?>

    <?php endif ?>
  </div>
</div>

<form action="<?= base_url() ?>/license" method="post">
  <?= csrf_field() ?>
  <div class="card mt-4">
    <div class="card-body">
      <div class="row">
        <div class="col">

          <?php
          echo $bs->formRow([
            'type' => 'text',
            'mandatory' => true,
            'name' => 'licensekey',
            'title' => lang('Lic.key'),
            'desc' => lang('Lic.key_help'),
            'errors' => session('errors.licensekey'),
            'value' => $L->details->license_key
          ]);

          $licStatus = $L->status();
          switch ($licStatus) {

            case "pending": ?>
              <!-- Form Row: Activate -->
              <div class="row">
                <label class="col" for="btn_activate">
                  <strong><?= lang('Lic.btn.activate') ?></strong><br>
                  <span><?= lang('Lic.activation_help') ?></span>
                </label>
                <div class="col">
                  <button type="submit" class="btn btn-primary" name="btn_activate" id="btn_activate"><?= lang('Lic.btn.activate') ?></button>
                </div>
              </div>
              <?php break;

            case "unregistered": ?>
              <!-- Form Row: Register -->
              <div class="row">
                <label class="col" for="btn_register">
                  <strong><?= lang('Lic.btn.register') ?></strong><br>
                  <span><?= lang('Lic.registration_help') ?></span>
                </label>
                <div class="col">
                  <button type="submit" class="btn btn-success" name="btn_register" name="btn_register"><?= lang('Lic.btn.register') ?></button>
                </div>
              </div>
              <?php break;

            case "active":
            default: ?>
              <!-- Form Row: Register -->
              <div class="row">
                <label class="col" for="btn_deregister">
                  <strong><?= lang('Lic.btn.deregister') ?></strong><br>
                  <span><?= lang('Lic.deregistration_help') ?></span>
                </label>
                <div class="col">
                  <button type="submit" class="btn btn-warning" name="btn_deregister" name="btn_deregister"><?= lang('Lic.btn.deregister') ?></button>
                </div>
              </div>
              <?php break;
          }
          ?>

        </div>
      </div>
    </div>
  </div>
</form>

<?= $this->endSection() ?>
