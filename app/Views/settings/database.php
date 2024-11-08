<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials\alert') ?>

  <form action="<?= base_url() ?>database" method="post">
    <?= csrf_field() ?>

    <div class="card">

      <?= $bs->cardHeader([ 'icon' => 'bi-database-fill-gear', 'title' => lang('Database.pageTitle'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

      <div class="card-body">

        <div class="card">

          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="optimize-tab" data-bs-toggle="tab" data-bs-target="#optimize-tab-pane" type="button" role="tab" aria-controls="optimize-tab-pane" aria-selected="true"><?= lang('Database.tab.optimize') ?></button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="reset-tab" data-bs-toggle="tab" data-bs-target="#reset-tab-pane" type="button" role="tab" aria-controls="reset-tab-pane" aria-selected="true"><?= lang('Database.tab.reset') ?></button>
              </li>
            </ul>
          </div>

          <div class="card-body">
            <div class="tab-content" id="myTabContent">

              <!--begin:Optimize Tab-->
              <div class="tab-pane fade show active" id="optimize-tab-pane" role="tabpanel" aria-labelledby="optimize-tab">
                <p><strong><?= lang('Database.optimize') ?></strong><br>
                  <?= lang('Database.optimize_desc') ?></p>
                <hr>
                <button type="submit" class="btn btn-primary" name="btn_optimize"><?= lang('Database.btn.optimize') ?></button>
              </div>
              <!--end:Optimize Tab-->

              <!--begin:Reset Tab-->
              <div class="tab-pane fade" id="reset-tab-pane" role="tabpanel" aria-labelledby="reset-tab">

                <div class="alert alert-danger"><?= lang('Database.reset_warning') ?></div>
                <hr class="my-4">
                <?php
                echo $bs->formRow([
                  'type' => 'text',
                  'mandatory' => false,
                  'name' => 'txt_resetConfirm',
                  'title' => lang('Database.resetConfirm'),
                  'desc' => lang('Database.resetConfirm_desc'),
                  'errors' => session('errors.txt_resetConfirm'),
                  'value' => '',
                  'placeholder' => '',
                ]);
                ?>
                <button type="submit" class="btn btn-primary" name="btn_reset"><?= lang('Database.btn.reset') ?></button>
              </div>
              <!--end:Cleanup Tab-->

            </div>
          </div>
        </div>
      </div>

    </div>
  </form>
</div>

<?= $this->endSection() ?>
