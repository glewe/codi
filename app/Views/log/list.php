<?= $this->extend('layout') ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials/alert') ?>

  <div class="card">

    <?= $bs->cardHeader([ 'icon' => 'bi-card-list', 'title' => lang('Log.log'), 'help' => getPageHelpUrl(uri_string()) ]) ?>

    <div class="card-body">

      <?php if (has_permissions([ 'log.edit', 'log.delete' ])) { ?>
      <form name="form_log" action="log" method="post">
        <?= csrf_field() ?>
        <div class="text-end mb-2">
          <?php if (has_permissions([ 'log.delete' ])) { ?>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalClearLog"><i class="bi-trash me-2"></i><?= lang('Log.clearLog') ?></button>
            <?php
            if (has_permissions('log.delete')) {
              echo $bs->modal([
                'id' => 'modalClearLog',
                'header' => lang('Auth.modal.confirm'),
                'header_color' => 'danger',
                'body' => lang('Log.delete_confirm'),
                'btn_color' => 'danger',
                'btn_name' => 'btn_clear_log',
                'btn_text' => lang('App.btn.delete'),
              ]);
            }
            ?>
          <?php } ?>
          <?php if (has_permissions([ 'log.edit' ])) { ?>
            <button type="submit" class="btn btn-primary" name="btn_save_settings"><i class="bi-floppy me-2"></i><?= lang('Log.saveSettings') ?></button>
          <?php } ?>
        </div>
        <?php } ?>

        <div class="card">

          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="log-tab" data-bs-toggle="tab" data-bs-target="#log-tab-pane" type="button" role="tab" aria-controls="log-tab-pane" aria-selected="true"><?= lang('Log.tab.log') ?></button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="logsettings-tab" data-bs-toggle="tab" data-bs-target="#logsettings-tab-pane" type="button" role="tab" aria-controls="logsettings-tab-pane" aria-selected="true"><?= lang('Log.tab.settings') ?></button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="logcolors-tab" data-bs-toggle="tab" data-bs-target="#logcolors-tab-pane" type="button" role="tab" aria-controls="logcolors-tab-pane" aria-selected="true"><?= lang('Log.tab.colors') ?></button>
              </li>
            </ul>
          </div>

          <div class="card-body">
            <div class="tab-content" id="myTabContent">

              <div class="tab-pane fade show active" id="log-tab-pane" role="tabpanel" aria-labelledby="log-tab">

                <?php
                if (!empty($events) && is_array($events)) :
                  $i = 1; ?>
                  <table id="dataList" class="table table-bordered dt-responsive nowrap table-striped align-middle data-table" style="width:100%">
                    <thead>
                    <tr>
                      <th data-ordering="false">#</th>
                      <th class="text-start"><?= lang('Log.time') ?></th>
                      <th data-ordering="false"><?= lang('Log.type') ?></th>
                      <th data-ordering="false"><?= lang('Log.user') ?></th>
                      <th data-ordering="false"><?= lang('Log.ip') ?></th>
                      <th data-ordering="false"><?= lang('Log.event') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($events as $event) :
                      $color = $settings['logColor' . $event['type']];
                      ?>
                      <tr>
                        <td style="color: <?= $color ?>;" class="align-top"><?= $i++ ?></td>
                        <td style="color: <?= $color ?>;" class="align-top text-start"><i class="bi-clock me-1"></i><?= $event['created_at'] ?></td>
                        <td style="color: <?= $color ?>;" class="align-top"><i class="bi-folder me-1"></i><?= $event['type'] ?></td>
                        <td style="color: <?= $color ?>;" class="align-top"><i class="bi-person me-1"></i><?= $event['user'] ?></td>
                        <td style="color: <?= $color ?>;" class="align-top"><i class="bi-laptop me-1"></i><?= $event['ip'] ?></td>
                        <td style="color: <?= $color ?>;" class="align-top"><i class="bi-pencil-square me-1"></i><?= $event['event'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                <?php else : ?>
                  <div class="mt-2">
                    <?php
                    echo $bs->alertSmall($data = [
                      'type' => 'warning',
                      'icon' => '',
                      'title' => 'Oops',
                      'subject' => lang('Log.none_found'),
                      'text' => '',
                      'help' => '',
                      'dismissible' => false,
                    ]);
                    ?>
                  </div>
                <?php endif ?>
              </div>

              <div class="tab-pane fade" id="logsettings-tab-pane" role="tabpanel" aria-labelledby="logsettings-tab">
                <?php
                foreach ($formFields['filters'] as $field) {
                  foreach ($field as $key => $setting) {
                    $pieces = explode('_', $key);
                    $fieldName = $pieces[1];
                    switch ($setting['type']) {
                      case 'color':
                      case 'radio':
                      case 'check':
                      case 'switch':
                        echo $bs->formRow([
                          'type' => $setting['type'],
                          'mandatory' => $setting['mandatory'],
                          'name' => $key,
                          'title' => lang('Log.' . $fieldName),
                          // 'desc' => lang('Log.' . $fieldName . '_desc'),
                          'desc' => '',
                          'errors' => session('errors.' . $key),
                          'value' => array_key_exists($fieldName, $settings) ? $settings[$fieldName] : '',
                        ]);
                        break;

                      default:
                        echo '';
                        break;
                    }
                  }
                }
                ?>
              </div>

              <div class="tab-pane fade" id="logcolors-tab-pane" role="tabpanel" aria-labelledby="logcolors-tab">
                <?php
                foreach ($formFields['colors'] as $field) {
                  foreach ($field as $key => $setting) {
                    $pieces = explode('_', $key);
                    $fieldName = $pieces[1];
                    switch ($setting['type']) {
                      case 'color':
                        echo $bs->formRow([
                          'type' => $setting['type'],
                          'mandatory' => $setting['mandatory'],
                          'name' => $key,
                          'title' => lang('Log.' . $fieldName),
                          'desc' => lang('Log.' . $fieldName . '_desc'),
                          'errors' => session('errors.' . $key),
                          'value' => array_key_exists($fieldName, $settings) ? $settings[$fieldName] : '',
                        ]);
                        break;

                      default:
                        echo '';
                        break;
                    }
                  }
                }
                ?>
              </div>

            </div>
          </div>
        </div>

        <?php if (has_permissions([ 'log.edit', 'log.delete' ])) { ?>
      </form>
    <?php } ?>

    </div>
  </div>
</div>

<script>
  //
  // DataTables init
  //
  $(document).ready(function () {
    $('#dataList').DataTable({
      "paging": true,
      "ordering": true,
      "info": true,
      "pageLength": 50,
      language: {
        url: '<?= base_url() ?>/addons/datatables/datatables.<?= lang('General.locale') ?>.json'
      },
      columnDefs: [
        {targets: [0], orderable: false, searchable: false}
      ]
    });
  });
</script>
<?= $this->endSection() ?>
