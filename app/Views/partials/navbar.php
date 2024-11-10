<!--begin::navbar-->
<nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a href="<?= base_url() ?>" class="navbar-brand" style="padding: 2px 8px 0 8px;"><i class="<?= config('Config\AppInfo')->icon ?> fa-lg logo-gradient" style="font-size: larger;"></i></a>
    <button
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
      class="navbar-toggler"
      data-bs-toggle="collapse"
      data-bs-target="#navbarContent"
      type="button"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- App -->
        <li class="nav-item dropdown me-2 mt-2">
          <?= $bs->navbarLink([ 'target' => 'appDropdown', 'icon' => 'bi bi-house', 'label' => config('Config\AppInfo')->name ]); ?>
          <ul class="dropdown-menu ms-2" aria-labelledby="appDropdown">
            <?= $bs->navbarSublink([ 'url' => base_url(), 'icon' => 'bi bi-house-check', 'label' => lang('Navbar.home.title'), 'permitted' => true ]); ?>
            <?= $bs->navbarSublink([ 'url' => 'divider', 'permitted' => true ]); ?>
            <?php foreach ($config->supportedLocales as $loc) { ?>
              <li>
                <a class="dropdown-item" href="<?= base_url() ?>lang/<?= $loc ?>">
                  <img src="<?= base_url() . 'images/flags/' . $loc . '.svg' ?>" alt="<?= $loc ?>" class="me-3" style="width: 16px;"/><?= lang('App.locales.' . $loc) ?>
                  <?php if (isset($session) && $session->get('lang') === $loc) {
                    echo '<i class="bi-check-lg ms-2 text-success"></i>';
                  } ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </li>

        <?php
        $viewMenu = [
          'link' => [ 'target' => 'viewDropdown', 'icon' => 'bi bi-window', 'label' => lang('Navbar.view.title'), ],
          'dropdown' => [
            [ 'url' => base_url() . 'sample/view', 'icon' => 'bi bi-heart', 'label' => lang('Navbar.view.sample'), 'permitted' => true ],
          ]
        ];
        echo '<!--View-->' . $bs->navbarItem($viewMenu);

        if (logged_in()) {
          $editMenu = [
            'link' => [ 'target' => 'edit', 'icon' => 'bi bi-pencil-square', 'label' => lang('Navbar.edit.title'), ],
            'dropdown' => [
              [ 'url' => base_url() . 'sample/edit', 'icon' => 'bi bi-pen', 'label' => lang('Navbar.edit.sample'), 'permitted' => true ],
            ]
          ];
          echo '<!--Edit-->' . $bs->navbarItem($editMenu);
        } ?>

      </ul>

      <!-- Right Menu Section -->
      <ul class="navbar-nav">

        <!-- Width -->
        <li class="nav-item dropdown me-2 mt-2">
          <a class="nav-link dropdown-toggle text-light" href="#" id="widthDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi-fullscreen-exit width-icon-active"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="widthDropdown">
            <li><a class="dropdown-item" href="#" data-width-value="narrow"><i class="bi-fullscreen-exit menu-icon"></i><?= lang('General.normal') ?></a></li>
            <li><a class="dropdown-item" href="#" data-width-value="wide"><i class="bi-fullscreen menu-icon"></i><?= lang('General.wide') ?></a></li>
          </ul>
        </li>

        <!-- Theme -->
        <li class="nav-item dropdown me-2 mt-2">
          <a class="nav-link dropdown-toggle text-light" href="#" id="themeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi-circle-half theme-icon-active"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
            <li><a href="#" class="dropdown-item" data-bs-theme-value="light"><i class="bi-sun-fill menu-icon"></i><?= lang('General.light') ?></a></li>
            <li><a href="#" type="button" class="dropdown-item" data-bs-theme-value="dark"><i class="bi-moon-stars-fill menu-icon"></i><?= lang('General.dark') ?></a></li>
            <li><a href="#" type="button" class="dropdown-item" data-bs-theme-value="auto"><i class="bi-circle-half menu-icon"></i><?= lang('General.auto') ?></a></li>
          </ul>
        </li>

        <?php if (has_permissions([
          'application.manage',
          'database.edit',
          'log.view',
          'group.view',
          'options.manage',
          'permission.view',
          'region.view',
          'role.view',
          'user.view'
        ])) {
          $adminMenu = [
            'link' => [ 'target' => 'adminDropdown', 'icon' => 'bi bi-gear-fill', 'label' => lang('Navbar.administration.title'), ],
            'dropdown' => [
              [ 'url' => base_url() . 'options', 'icon' => 'bi bi-sliders', 'label' => lang('Navbar.administration.options'), 'permitted' => has_permissions('options.manage') ],
              [ 'url' => 'divider', 'permitted' => true ],
              [ 'url' => base_url() . 'groups', 'icon' => 'bi bi-people-fill', 'label' => lang('Navbar.useradmin.groups'), 'permitted' => has_permissions('group.view') ],
              [ 'url' => base_url() . 'permissions', 'icon' => 'bi bi-key-fill', 'label' => lang('Navbar.useradmin.permissions'), 'permitted' => has_permissions('permission.view') ],
              [ 'url' => base_url() . 'roles', 'icon' => 'bi bi-person-circle', 'label' => lang('Navbar.useradmin.roles'), 'permitted' => has_permissions('role.view') ],
              [ 'url' => base_url() . 'users', 'icon' => 'bi bi-person-fill', 'label' => lang('Navbar.useradmin.users'), 'permitted' => has_permissions('user.view') ],
              [ 'url' => 'divider', 'permitted' => true ],
              [ 'url' => base_url() . 'database', 'icon' => 'bi bi-database-fill-gear', 'label' => lang('Navbar.administration.database'), 'permitted' => has_permissions('database.edit') ],
              [ 'url' => base_url() . 'log', 'icon' => 'bi bi-card-list', 'label' => lang('Navbar.administration.log'), 'permitted' => has_permissions('log.view') ]
            ]
          ];
          if ($configLic->checkLicense) {
            $adminMenu['dropdown'][] = [ 'url' => base_url() . 'license', 'icon' => 'bi bi-vector-pen', 'label' => lang('Navbar.administration.license'), 'permitted' => has_permissions('application.manage') ];
          }
          $adminMenu['dropdown'][] = [ 'url' => base_url() . 'phpinformation', 'icon' => 'bi bi-filetype-php', 'label' => lang('Navbar.administration.phpinfo'), 'permitted' => has_permissions('application.manage') ];
          $adminMenu['dropdown'][] = [ 'url' => base_url() . 'settings', 'icon' => 'bi bi-gear', 'label' => lang('Navbar.administration.settings'), 'permitted' => has_permissions('application.manage') ];
          echo '<!--Admin-->' . $bs->navbarItem($adminMenu, true);
        }

        $helpMenu = [
          'link' => [ 'target' => 'helpDropdown', 'icon' => 'bi bi-question-circle-fill', 'label' => lang('Navbar.help.title'), ],
          'dropdown' => [
            [ 'url' => base_url() . 'dataprivacy', 'icon' => 'bi bi-shield-shaded', 'label' => lang('Navbar.help.dataprivacy'), 'permitted' => $settings['dataPrivacyPolicy'] ],
            [ 'url' => base_url() . 'imprint', 'icon' => 'bi bi-vector-pen', 'label' => lang('Navbar.help.imprint'), 'permitted' => $settings['imprint'] ],
            [ 'url' => 'divider', 'permitted' => true ],
            [ 'url' => base_url() . 'about', 'icon' => config('AppInfo')->icon . ' logo-gradient', 'label' => lang('Navbar.help.about') . ' ' . config('AppInfo')->name, 'permitted' => true ],
          ]
        ];
        echo '<!--Help-->' . $bs->navbarItem($helpMenu, true);

        $userMenu = [
          'link' => [ 'target' => 'userDropdown', 'icon' => 'bi bi-question-circle-fill', 'label' => '<img src="' . $avatarUrl . '" class="sidebar-avatar" alt="">', ],
          'dropdown' => [
            [ 'url' => '#', 'icon' => 'bi bi-person', 'label' => logged_in() ? user_username() : lang('Navbar.user.not_logged_in'), 'permitted' => true ],
            [ 'url' => 'divider', 'permitted' => true ],
            [ 'url' => base_url() . 'login', 'icon' => 'bi bi-box-arrow-in-right', 'label' => lang('Navbar.user.login'), 'permitted' => !logged_in() ],
            [ 'url' => base_url() . 'register', 'icon' => 'bi bi-person-fill-add', 'label' => lang('Navbar.user.register'), 'permitted' => !logged_in() && !empty($settings) && $settings['allowRegistration'] ],
            [ 'url' => base_url() . 'users/profile/' . user_id(), 'icon' => 'bi bi-person-square', 'label' => lang('Navbar.user.editprofile'), 'permitted' => logged_in() ],
            [ 'url' => base_url() . 'setup2fa', 'icon' => 'bi bi-unlock', 'label' => lang('Navbar.user.setup2fa'), 'permitted' => logged_in() ],
            [ 'url' => base_url() . 'whoami', 'icon' => 'bi bi-question-circle', 'label' => lang('Navbar.user.whoami'), 'permitted' => logged_in() ],
            [ 'url' => base_url() . 'logout', 'icon' => 'bi bi-box-arrow-left', 'label' => lang('Navbar.user.logout'), 'permitted' => logged_in() ],
          ]
        ];
        echo '<!--Help-->' . $bs->navbarItem($userMenu, true);
        ?>

      </ul>

    </div>
  </div>
</nav>
<!--end::navbar-->
