<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials/alert') ?>

  <div class="card mb-3">
    <?= $bs->cardHeader([ 'icon' => 'bi-vector-pen', 'title' => config('AppInfo')->name . ' ' . lang('Lic.license'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

    <div class="card-body">

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
          'dismissible' => false,
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
              'value' => $licenseKey,
              'ruler' => false
            ]);
            ?>
            <div class="col float-end">
              <button type="submit" class="btn btn-warning" name="btn_save"><?= lang('Lic.btn.save') ?></button>
            </div>

          </div>
        </div>
      </div>
      <div class="card-footer">
        <?php
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
                <button type="submit" class="btn btn-success" name="btn_register" id="btn_register"><?= lang('Lic.btn.register') ?></button>
              </div>
            </div>
            <?php break;

          case "active": ?>
            <!-- Form Row: De-Register -->
            <div class="row">
              <label class="col" for="btn_deregister">
                <strong><?= lang('Lic.btn.deregister') ?></strong><br>
                <span><?= lang('Lic.deregistration_help') ?></span>
              </label>
              <div class="col">
                <button type="submit" class="btn btn-warning" name="btn_deregister" id="btn_deregister"><?= lang('Lic.btn.deregister') ?></button>
              </div>
            </div>
            <?php break;

          case "invalid": ?>
            <!-- Form Row: De-Register -->
            <div class="row">
              <label class="col" for="lic_invalid">
                <strong id="lic_invalid"><?= lang('Lic.invalid') ?></strong><br>
                <span><?= lang('Lic.invalid_save') ?></span>
              </label>
            </div>
            <?php break;

          default:
            break;
        }
        ?>
      </div>
    </div>
  </form>

  <?= $this->endSection() ?>
