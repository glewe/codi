<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">

    <a class="navbar-brand" href="#"><i class="bi-shield-shaded text-warning"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLeweLic" aria-controls="navbarLeweLic" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarLeweLic">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= base_url() ?>/"><?= lang('Lic.nav.home') ?></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="authDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= lang('Lic.nav.license.self') ?></a>
          <ul class="dropdown-menu" aria-labelledby="authDropdown">
            <li><a class="dropdown-item" href="<?= base_url() ?>/license"><i class="bi-vector-pen menu-icon"></i><?= lang('Lic.nav.license.show') ?></a></li>
          </ul>
        </li>
      </ul>
    </div>

  </div>
</nav>
