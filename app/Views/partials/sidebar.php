<!--begin::Sidebar-->
<aside id="sidebar">
  <div class="d-flex">
    <button class="sidebar-toggle" type="button">
      <i class="<?= config('Config\AppInfo')->icon ?> navbar-logo logo-gradient"></i>
    </button>
    <div class="sidebar-logo">
      <a href="<?= base_url() ?>home"><?= config('Config\AppInfo')->name ?></a>
    </div>
  </div>
  <ul class="sidebar-nav">

    <!--Home-->
    <li class="sidebar-item">
      <?= $bs->sidebarLink([ 'target' => 'home', 'icon' => 'bi bi-house', 'label' => lang('Navbar.home.title') ]); ?>
      <ul id="home" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
        <?= $bs->sidebarSublink([ 'url' => base_url(), 'icon' => 'bi bi-house-check', 'label' => lang('Navbar.home.title'), 'permitted' => true ]); ?>
        <?php foreach ($config->supportedLocales as $loc) { ?>
          <li class="sidebar-item">
            <a class="sidebar-link sidebar-sublink" href="<?= base_url() ?>lang/<?= $loc ?>">
              <img src="<?= base_url() . 'images/flags/' . $loc . '.svg' ?>" alt="<?= $loc ?>" class="me-3" style="width: 16px;"/><?= lang('App.locales.' . $loc) ?>
              <?php if (isset($session) && $session->get('lang') === $loc) {
                echo '<i class="bi bi-check-lg ms-2 text-success"></i>';
              } ?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </li>

    <?php
    $viewMenu = [
      'link' => [ 'target' => 'view', 'icon' => 'bi bi-window', 'label' => lang('Navbar.view.title'), ],
      'dropdown' => [
        [ 'url' => base_url() . 'sample/view', 'icon' => 'bi bi-heart', 'label' => lang('Navbar.view.sample'), 'permitted' => true ],
      ]
    ];
    echo '<!--View-->' . $bs->sidebarItem($viewMenu);

    if (logged_in()) {
      $editMenu = [
        'link' => [ 'target' => 'edit', 'icon' => 'bi bi-pencil-square', 'label' => lang('Navbar.edit.title'), ],
        'dropdown' => [
          [ 'url' => base_url() . 'sample/edit', 'icon' => 'bi bi-pen', 'label' => lang('Navbar.edit.sample'), 'permitted' => true ],
        ]
      ];
      echo '<!--Edit-->' . $bs->sidebarItem($editMenu);
    }

    if (has_permissions([
      'options.manage',
      'label.view',
      'priority.view',
      'product.view',
      'statuscategory.view'
    ])) {
      $optionsMenu = [
        'link' => [ 'target' => 'options', 'icon' => 'bi bi-sliders', 'label' => lang('Navbar.options.title'), ],
        'dropdown' => [
          [ 'url' => base_url() . 'options', 'icon' => 'bi bi-sliders2', 'label' => lang('Navbar.options.options'), 'permitted' => has_permissions('options.manage') ],
          [ 'url' => base_url() . 'labels', 'icon' => 'bi bi-tag-fill', 'label' => lang('Navbar.options.labels'), 'permitted' => has_permissions('label.view') ],
          [ 'url' => base_url() . 'priorities', 'icon' => 'bi bi-bell-fill', 'label' => lang('Navbar.options.priorities'), 'permitted' => has_permissions('priority.view') ],
          [ 'url' => base_url() . 'products', 'icon' => 'bi bi-box', 'label' => lang('Navbar.options.products'), 'permitted' => has_permissions('product.view') ],
          [ 'url' => base_url() . 'statuscategories', 'icon' => 'bi bi-circle-fill', 'label' => lang('Navbar.options.statuscategories'), 'permitted' => has_permissions('statuscategory.view') ],
        ]
      ];
      echo '<!--Options-->' . $bs->sidebarItem($optionsMenu);
    }

    if (has_permissions([
      'application.manage',
      'database.edit',
      'log.view'
    ])) {
      $adminMenu = [
        'link' => [ 'target' => 'admin', 'icon' => 'bi bi-gear-fill', 'label' => lang('Navbar.administration.title'), ],
        'dropdown' => [
          [ 'url' => base_url() . 'database', 'icon' => 'bi bi-database-fill-gear', 'label' => lang('Navbar.administration.database'), 'permitted' => has_permissions('database.edit') ],
          [ 'url' => base_url() . 'log', 'icon' => 'bi bi-card-list', 'label' => lang('Navbar.administration.log'), 'permitted' => has_permissions('log.view') ]
        ]
      ];
      if ($configLic->checkLicense) {
        $adminMenu['dropdown'][] = [ 'url' => base_url() . 'license', 'icon' => 'bi bi-vector-pen', 'label' => lang('Navbar.administration.license'), 'permitted' => has_permissions('application.manage') ];
      }
      $adminMenu['dropdown'][] = [ 'url' => base_url() . 'phpinformation', 'icon' => 'bi bi-filetype-php', 'label' => lang('Navbar.administration.phpinfo'), 'permitted' => has_permissions('application.manage') ];
      $adminMenu['dropdown'][] = [ 'url' => base_url() . 'settings', 'icon' => 'bi bi-gear', 'label' => lang('Navbar.administration.settings'), 'permitted' => has_permissions('application.manage') ];
      echo '<!--Admin-->' . $bs->sidebarItem($adminMenu);
    }

    if (has_permissions([
      'group.view',
      'permission.view',
      'region.view',
      'role.view',
      'user.view'
    ])) {
      $useradminMenu = [
        'link' => [ 'target' => 'useradmin', 'icon' => 'bi bi-person-fill-gear', 'label' => lang('Navbar.useradmin.title'), ],
        'dropdown' => [
          [ 'url' => base_url() . 'groups', 'icon' => 'bi bi-people-fill', 'label' => lang('Navbar.useradmin.groups'), 'permitted' => has_permissions('group.view') ],
          [ 'url' => base_url() . 'permissions', 'icon' => 'bi bi-key-fill', 'label' => lang('Navbar.useradmin.permissions'), 'permitted' => has_permissions('permission.view') ],
          [ 'url' => base_url() . 'roles', 'icon' => 'bi bi-person-circle', 'label' => lang('Navbar.useradmin.roles'), 'permitted' => has_permissions('role.view') ],
          [ 'url' => base_url() . 'users', 'icon' => 'bi bi-person-fill', 'label' => lang('Navbar.useradmin.users'), 'permitted' => has_permissions('user.view') ],
        ]
      ];
      echo '<!--UserAdmin-->' . $bs->sidebarItem($useradminMenu);
    } ?>

    <?php if (config('Config\App')->showHelpMenu) {
      $helpMenu = [
        'link' => [ 'target' => 'help', 'icon' => 'bi bi-question-circle-fill', 'label' => lang('Navbar.help.title'), ],
        'dropdown' => [
          [ 'url' => base_url() . 'dataprivacy', 'icon' => 'bi bi-shield-shaded', 'label' => lang('Navbar.help.dataprivacy'), 'permitted' => $settings['dataPrivacyPolicy'] ],
          [ 'url' => base_url() . 'imprint', 'icon' => 'bi bi-vector-pen', 'label' => lang('Navbar.help.imprint'), 'permitted' => $settings['imprint'] ],
          [ 'url' => base_url() . 'about', 'icon' => config('Config\AppInfo')->icon . ' logo-gradient', 'label' => lang('Navbar.help.about'), 'permitted' => true ],
        ]
      ];
      echo '<!--Help-->' . $bs->sidebarItem($helpMenu);
    } ?>

    <li class="sidebar-item mt-2 mb-2">
      <hr class="sidebar-divider">
    </li>

    <!--User-->
    <li class="sidebar-item">
      <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#user" aria-expanded="false" aria-controls="user">
        <img src="<?= $avatarUrl ?>" class="sidebar-avatar" alt="">
        <span><?= logged_in() ? user_username() : lang('Navbar.user.not_logged_in') ?></span>
      </a>
      <ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
        <?php
        if (!logged_in()) {
          echo $bs->sidebarSublink([ 'url' => base_url() . 'login', 'icon' => 'bi bi-box-arrow-in-right', 'label' => lang('Navbar.user.login'), 'permitted' => true ]);
          echo $bs->sidebarSublink([ 'url' => base_url() . 'register', 'icon' => 'bi bi-person-fill-add', 'label' => lang('Navbar.user.register'), 'permitted' => !empty($settings) && $settings['allowRegistration'] ]);
        } else {
          echo $bs->sidebarSublink([ 'url' => base_url() . 'users/profile/' . user_id(), 'icon' => 'bi bi-person-square', 'label' => lang('Navbar.user.editprofile'), 'permitted' => true ]);
          echo $bs->sidebarSublink([ 'url' => base_url() . 'setup2fa', 'icon' => 'bi bi-unlock', 'label' => lang('Navbar.user.setup2fa'), 'permitted' => true ]);
          echo $bs->sidebarSublink([ 'url' => base_url() . 'whoami', 'icon' => 'bi bi-question-circle', 'label' => lang('Navbar.user.whoami'), 'permitted' => true ]);
          echo $bs->sidebarSublink([ 'url' => base_url() . 'logout', 'icon' => 'bi bi-box-arrow-left', 'label' => lang('Navbar.user.logout'), 'permitted' => true ]);
        } ?>
      </ul>
    </li>

  </ul>

  <div class="sidebar-footer">
    <ul class="sidebar-nav pb-0">

      <!-- Width Menu -->
      <li class="sidebar-item">
        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#widthmode" aria-expanded="false" aria-controls="widthmode">
          <i class="bi bi-fullscreen-exit width-icon-active"></i>
          <span><?= lang('General.toggleWidth') ?></span>
        </a>
        <ul id="widthmode" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
          <li class="sidebar-item">
            <span class="sidebar-link sidebar-sublink d-flex align-items-center" data-width-value="narrow">
              <i class="bi bi-fullscreen-exit"></i>
              <?= lang('General.normal') ?>
            </span>
          </li>
          <li class="sidebar-item">
            <span class="sidebar-link sidebar-sublink d-flex align-items-center" data-width-value="wide">
              <i class="bi bi-fullscreen"></i>
              <?= lang('General.wide') ?>
            </span>
          </li>
        </ul>
      </li>

      <!-- Theme Menu -->
      <li class="sidebar-item">
        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#darkmode" aria-expanded="false" aria-controls="darkmode">
          <i class="bi bi-circle-half theme-icon-active"></i>
          <span><?= lang('General.toggleTheme') ?></span>
        </a>
        <ul id="darkmode" class="sidebar-dropdown-bottom list-unstyled collapse" data-bs-parent="#sidebar">
          <li class="sidebar-item">
            <span class="sidebar-link sidebar-sublink d-flex align-items-center" data-bs-theme-value="light">
              <i class="bi bi-sun-fill"></i>
              <?= lang('General.light') ?>
            </span>
          </li>
          <li class="sidebar-item">
            <span type="button" class="sidebar-link sidebar-sublink d-flex align-items-center" data-bs-theme-value="dark">
              <i class="bi bi-moon-stars-fill"></i>
              <?= lang('General.dark') ?>
            </span>
          </li>
          <li class="sidebar-item">
            <span type="button" class="sidebar-link sidebar-sublink d-flex align-items-center active" data-bs-theme-value="auto">
              <i class="bi bi-circle-half"></i>
              <?= lang('General.auto') ?>
            </span>
          </li>
        </ul>
      </li>

    </ul>
  </div>

</aside>
<!--end::Sidebar-->
