<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials/alert') ?>

  <form action="<?= base_url() ?>settings" method="post">
    <?= csrf_field() ?>

    <div class="card">

      <?= $bs->cardHeader([ 'icon' => 'bi-gear', 'title' => lang('Settings.title'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

      <div class="card-body">

        <div class="card">

          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
              <?php
              $i = 0;
              foreach ($formFields as $tab => $tabsettings) { ?>
                <li class="nav-item" role="presentation">
                  <button class="nav-link <?= !$i ? 'active' : '' ?>" id="<?= $tab ?>-tab" data-bs-toggle="tab" data-bs-target="#<?= $tab ?>-tab-pane" type="button" role="tab" aria-controls="<?= $tab ?>-tab-pane" aria-selected="<?= !$i ? 'true' : 'false' ?>"><?= lang('Settings.tab.' . $tab) ?></button>
                </li>
                <?php $i++;
              } ?>
            </ul>
          </div>

          <div class="card-body">
            <div class="tab-content" id="myTabContent">

              <?php
              $i = 0;
              foreach ($formFields as $tab => $tabsettings) { ?>
                <!--begin:<?= $tab ?> Tab-->
                <div class="tab-pane fade <?= !$i ? 'show active' : '' ?>" id="<?= $tab ?>-tab-pane" role="tabpanel" aria-labelledby="<?= $tab ?>-tab">
                  <?php
                  foreach ($formFields[$tab] as $key => $setting) {
                    $pieces = explode('_', $key);
                    $fieldName = $pieces[1];
                    switch ($setting['type']) {
                      case 'text':
                        echo $bs->formRow([
                          'type' => $setting['type'],
                          'mandatory' => $setting['mandatory'],
                          'name' => $key,
                          'title' => lang('Settings.' . $fieldName),
                          'desc' => lang('Settings.' . $fieldName . '_desc'),
                          'errors' => session('errors.' . $key),
                          'value' => array_key_exists($fieldName, $settings) ? $settings[$fieldName] : ''
                        ]);
                        break;

                      case 'number':
                        echo $bs->formRow([
                          'type' => $setting['type'],
                          'mandatory' => $setting['mandatory'],
                          'name' => $key,
                          'title' => lang('Settings.' . $fieldName),
                          'desc' => lang('Settings.' . $fieldName . '_desc'),
                          'errors' => session('errors.' . $key),
                          'value' => array_key_exists($fieldName, $settings) ? $settings[$fieldName] : '',
                          'min' => $setting['min'],
                          'max' => $setting['max'],
                          'step' => $setting['step']
                        ]);
                        break;

                      case 'radio':
                        echo $bs->formRow([
                          'type' => $setting['type'],
                          'mandatory' => $setting['mandatory'],
                          'name' => $key,
                          'title' => lang('Settings.' . $fieldName),
                          'desc' => lang('Settings.' . $fieldName . '_desc'),
                          'errors' => session('errors.' . $key),
                          'items' => $setting['items'],
                        ]);
                        break;

                      case 'check':
                      case 'switch':
                        echo $bs->formRow([
                          'type' => $setting['type'],
                          'mandatory' => $setting['mandatory'],
                          'name' => $key,
                          'title' => lang('Settings.' . $fieldName),
                          'desc' => lang('Settings.' . $fieldName . '_desc'),
                          'errors' => session('errors.' . $key),
                          'value' => $setting['value'],
                        ]);
                        break;

                      case 'select':
                        echo $bs->formRow([
                          'type' => 'select',
                          'subtype' => 'single',
                          'name' => $key,
                          'mandatory' => $setting['mandatory'],
                          'title' => lang('Settings.' . $fieldName),
                          'desc' => lang('Settings.' . $fieldName . '_desc'),
                          'errors' => session('errors.' . $key),
                          'items' => $setting['items'],
                        ]);
                        break;

                      case 'textarea':
                      case 'textareawide':
                      case 'ckeditor':
                        echo $bs->formRow([
                          'type' => $setting['type'],
                          'rows' => ($fieldName === 'welcomeText') ? '10' : '5',
                          'name' => $key,
                          'mandatory' => $setting['mandatory'],
                          'title' => lang('Settings.' . $fieldName),
                          'desc' => lang('Settings.' . $fieldName . '_desc'),
                          'errors' => session('errors.' . $key),
                          'value' => array_key_exists($fieldName, $settings) ? $settings[$fieldName] : ''
                        ]);
                        break;

                      default:
                        break;
                    }
                  }
                  ?>
                </div>
                <!--end:<?= $tab ?> Tab-->
                <?php $i++;
              } ?>

            </div>
          </div>
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><?= lang('Auth.btn.submit') ?></button>
        <a class="btn btn-secondary float-end" href="<?= base_url() ?>/users"><?= lang('Auth.btn.cancel') ?></a>
      </div>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
