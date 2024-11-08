<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container content">

  <div class="col-lg-12">

    <?= view('partials\alert') ?>

    <div class="card mb-3">
      <?= $bs->cardHeader([
        'icon' => 'bi bi-pen',
        'title' => 'Sample Form',
        'help' => getPageHelpUrl(uri_string())
      ])
      ?>
      <div class="card-body">

        <ul class="nav nav-tabs" style="margin-bottom: 15px;" role="tablist">
          <li class="nav-item"><a class="nav-link" href="#tab-form" aria-controls="tab-form" data-bs-toggle="tab" role="tab" aria-selected="true">Form Elements</a></li>
        </ul>

        <div id="myTabContent" class="tab-content">

          <div class="tab-pane fade show active" id="tab-form">

            <h3>Checkbox</h3>
            <?php
            $data = array(
              'type' => 'checkbox',
              'name' => 'mycheckbox',
              'value' => 'My label',
              'title' => 'My Checkbox',
              'desc' => 'This is a sample checkbox field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>Color Picker</h3>
            <?php
            $data = array(
              'type' => 'color',
              'name' => 'mycolor',
              'value' => '990000',
              'title' => 'My Color',
              'desc' => 'This is a sample Coloris color picker field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>Date</h3>
            <?php
            $data = array(
              'type' => 'date',
              'name' => 'mydate',
              'value' => '',
              'title' => 'My Date',
              'desc' => 'This is a sample date picker field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>Date/Time Picker</h3>
            <?php
            $data = array(
              'type' => 'datetime',
              'name' => 'mydatetime',
              'value' => '',
              'title' => 'My Date/Time',
              'desc' => 'This is a sample date/time picker field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>File Upload</h3>
            <?php
            $data = array(
              'type' => 'file',
              'name' => 'myfile',
              'accept' => 'image/*',
              'multiple' => false,
              'title' => 'My File Upload',
              'desc' => 'This is a sample file upload field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>Info</h3>
            <?php
            $data = array(
              'type' => 'info',
              'name' => 'myinfo',
              'value' => 'My info',
              'title' => 'My Info',
              'desc' => 'This is a sample info field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>Info Wide</h3>
            <?php
            $data = array(
              'type' => 'infowide',
              'name' => 'mylabel',
              'value' => 'My label',
              'title' => 'My Label',
              'desc' => loremIpsum(true),
            );
            echo $bs->formRow($data);
            ?>

            <h3>Number</h3>
            <?php
            $data = array(
              'type' => 'number',
              'name' => 'mynumber',
              'value' => '123',
              'title' => 'My Number',
              'min' => '0',
              'max' => '1000',
              'step' => '1',
              'desc' => 'This is a sample number field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>Password</h3>
            <?php
            $data = array(
              'type' => 'password',
              'name' => 'mypassword',
              'value' => '',
              'disabled' => 0,
              'title' => 'My Password',
              'desc' => 'This is a sample password field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>Radio</h3>
            <?php
            $data = array(
              'type' => 'radio',
              'name' => 'myradio',
              'disabled' => 0,
              'title' => 'My Radio Selection',
              'desc' => 'This is a sample radio selection.',
              'items' => [
                ['value'=> '1', 'label' => 'Option 1', 'checked' => false],
                ['value'=> '2', 'label' => 'Option 2', 'checked' => true],
                ['value'=> '3', 'label' => 'Option 3', 'checked' => false],
              ],
            );
            echo $bs->formRow($data);
            ?>
            <div class="spacer-40"></div>

            <h3>Radio Bootstrap Color</h3>
            <?php
            $data = array(
              'type' => 'bscolor',
              'name' => 'mybscolor',
              'disabled' => 0,
              'title' => 'My Bootstrap Color',
              'desc' => 'This is a sample radio selection for Bootstrap color.',
              'checked' => 'primary',
            );
            echo $bs->formRow($data);
            ?>
            <div class="spacer-40"></div>

            <h3>Range</h3>
            <?php
            $data = array(
              'type' => 'range',
              'name' => 'myrange',
              'value' => '50',
              'min' => '0',
              'max' => '100',
              'step' => '5',
              'disabled' => 0,
              'title' => 'My Range',
              'desc' => 'This is a sample range input.',
            );
            echo $bs->formRow($data);
            ?>
            <div class="spacer-40"></div>

            <h3>Select Single</h3>
            <?php
            $data = array(
              'type' => 'select',
              'subtype' => 'single',
              'name' => 'myselectsingle',
              'disabled' => 0,
              'title' => 'My Single Selection',
              'desc' => 'This is a sample single selection list.',
              'items' => [
                ['value'=> '1', 'title' => 'Selection 1', 'selected' => false],
                ['value'=> '2', 'title' => 'Selection 2', 'selected' => true],
                ['value'=> '3', 'title' => 'Selection 3', 'selected' => false],
                ['value'=> '4', 'title' => 'Selection 4', 'selected' => false],
              ],
            );
            echo $bs->formRow($data);
            ?>
            <div class="spacer-40"></div>

            <h3>Select Multi</h3>
            <?php
            $data = array(
              'type' => 'select',
              'subtype' => 'multi',
              'name' => 'myselectmulti',
              'disabled' => 0,
              'title' => 'My Multi Selection',
              'desc' => 'This is a sample multi selection list.',
              'items' => [
                ['value'=> '1', 'title' => 'Selection 1', 'selected' => false],
                ['value'=> '2', 'title' => 'Selection 2', 'selected' => true],
                ['value'=> '3', 'title' => 'Selection 3', 'selected' => false],
                ['value'=> '4', 'title' => 'Selection 4', 'selected' => false],
              ],
              'size' => 5,
            );
            echo $bs->formRow($data);
            ?>
            <div class="spacer-40"></div>

            <h3>Switch</h3>
            <?php
            $data = array(
              'type' => 'switch',
              'name' => 'myswitch',
              'value' => '0',
              'disabled' => 0,
              'title' => 'My Switch',
              'desc' => 'This is a sample switch field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>Text</h3>
            <?php
            $data = array(
              'type' => 'text',
              'name' => 'mytext',
              'value' => '',
              'disabled' => 0,
              'title' => 'My Text',
              'desc' => 'This is a sample text input field.',
            );
            echo $bs->formRow($data);
            ?>

            <h3>Textarea</h3>
            <?php
            $data = array(
              'type' => 'textarea',
              'name' => 'mytextarea',
              'value' => loremIpsum(),
              'disabled' => 0,
              'title' => 'My Textarea',
              'desc' => 'This is a sample textarea field.',
              'rows' => 4,
            );
            echo $bs->formRow($data);
            ?>

            <h3>Textarea Wide</h3>
            <?php
            $data = array(
              'type' => 'textareawide',
              'name' => 'mytextareawide',
              'value' => loremIpsum(true),
              'disabled' => 0,
              'title' => 'My Textarea Wide',
              'desc' => 'This is a sample textarea field over the whole width.',
              'rows' => 6,
            );
            echo $bs->formRow($data);
            ?>

          </div>
        </div>
      </div>
    </div>
    <div class="spacer-20"></div>

  </div>
</div>

<?= $this->endSection() ?>
