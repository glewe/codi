<?= view('partials/head') ?>

<!--begin::wrapper-->
<div class="wrapper">

  <!--begin::main-->
  <?php
  if ($menu === 'navbar') {
    echo view('partials/navbar');
    echo '<main id="main" class="ms-0 px-3">';
    $marginTop = 'mt-8';
  } else {
    echo view('partials/sidebar');
    echo '<main id="main" class="p-3">';
    $marginTop = 'mt-3';
  }
  ?>
  <div class="<?= $marginTop ?>">
    <?= $this->renderSection('main') ?>
  </div>

  <?= view('partials/foot') ?>

  </main>
  <!--end::main-->

</div>
<!--end::wrapper-->

<?= view('partials/scripts') ?>
