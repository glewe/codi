<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container content">

  <div class="col-lg-12">

    <?= view('partials\alert') ?>

    <div class="card mb-3">
      <?= $bs->cardHeader([
        'icon' => 'bi bi-heart',
        'title' => 'Sample Page',
        'help' => getPageHelpUrl(uri_string())
      ])
      ?>
      <div class="card-body">

        <ul class="nav nav-tabs" style="margin-bottom: 15px;" role="tablist">
          <li class="nav-item"><a class="nav-link active" href="#tab-general" aria-controls="tab-general" data-bs-toggle="tab" role="tab" aria-selected="true">General</a></li>
        </ul>

        <div id="myTabContent" class="tab-content">

          <div class="tab-pane fade show active" id="tab-general">

            <h3>Lightbox2</h3>
            <a href="images/og-image.png" data-lightbox="og-image" data-title="My OG Pic"><img src="<?= base_url() ?>images/og-image.png" class="img-fluid" alt="Pic Popup" style="width: 240px;"></a>
            <div class="spacer-40"></div>

            <h3>Figure</h3>
            <?= $bs->figure('images/og-image.png', 'This is my image caption', 'altText', '400px'); ?>
            <div class="spacer-40"></div>

            <h3>Toast</h3>
            <button type="button" class="btn btn-success" id="toastButton" onclick="$('.toast').toast('show');">Show Toast...</button>
            <div class="spacer-40"></div>

            <h3>Modal Dialog</h3>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreateUser">Modal Dialog...</button>
            <div class="spacer-40"></div>

            <h3>Chart.js</h3>
            <?php
            $chart = array(
              'label' => 'My first Dataset',
              'backgroundColor' => $bs->color['primary']['bg-subtle'],
              'borderColor' => $bs->color['primary']['border-subtle'],
              'labels' => array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ),
              'data' => array( 0, 10, 5, 2, 20, 30, 15, 12, 4, 6, 7, 23 ),
              'height' => 200

            );
            echo $chartjs->lineChart($chart);
            ?>
            <div class="spacer-40"></div>

            <h3>Dynamic Progress Bar</h3>
            <?php echo $bs->progressBar('warning', '0', '0%', true, true, '20px', 10); ?>
            <div class="spacer-40"></div>

            <h3>Logo</h3>
            <i class="bi bi-box-fill fa-10x logo-gradient"></i>
            <div class="spacer-40"></div>

            <h3>Tooltip</h3>
            <p>Hover the text (info tooltip top): <?php echo $bs->tooltip('This <b>is</b> the <em>tooltip</em> <u>text</u>', 'Title', 'top', 'info', 'Tootltip text'); ?></p>
            <div class="spacer-40"></div>

            <h3>Tooltip Icon</h3>
            <p>Hover the icon (danger tooltip left): <?php echo $bs->tooltipIcon('This <b>is</b> the <em>tooltip</em> <u>text</u>', 'Title', 'left', 'danger', 'bi bi-globe'); ?></p>
            <div class="spacer-40"></div>

            <h3>Spinner</h3>
            <?php echo $bs->spinner('grow', 'warning', 'Loading...'); ?>
            <div class="spacer-40"></div>

            <h3>Hightlight.js</h3>
            <pre>
              <code class="language-javascript">/**
 * Highlight.js
 */
function foo() {
  if (counter <= 10) {
    return;
  }
  // it works!
}</code>
            </pre>
            <script>hljs.highlightAll();</script>
            <div class="spacer-40"></div>

          </div>

        </div>
      </div>
    </div>
    <div class="spacer-20"></div>

    <!-- Modal Dialog -->
    <?php echo $bs->modal([
      'id' => 'modalCreateUser',
      'header' => 'Create User',
      'body' => '<label for="inputName" class="mb-2">Name</label><input id="inputName" class="form-control" name="txt_name" maxlength="40" value="" type="text">',
      'btn_color' => 'danger',
      'btn_name' => 'btn_userCreate',
      'btn_text' => 'Create User',
    ]); ?>

  </div>
</div>

<!-- Toast -->
<div aria-live="polite" aria-atomic="true" class="position-absolute top-0 end-0 p-3" style="z-index: 9999;">
  <?php
  $toast = array( 'id' => 'toast1', 'style' => 'primary', 'title' => 'CODI', 'time' => '5 min ago', 'message' => '<p>This is a sample toast message</p><ul><li>information</li></ul>' );
  echo $bs->toast($toast);
  $toast = array( 'id' => 'toast2', 'style' => 'warning', 'title' => 'CODI', 'time' => '5 min ago', 'message' => '<p>This is a sample toast message</p><ul><li>information</li></ul>' );
  echo $bs->toast($toast);
  ?>
</div>


<?= $this->endSection() ?>
