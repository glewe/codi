<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>
<div class="container">

  <?= view('partials/alert') ?>

  <form action="<?= base_url() ?>/users/profile/<?= $user->id ?>" method="post">
    <?= csrf_field() ?>

    <div class="card">

      <?= $bs->cardHeader([ 'icon' => 'bi-person-square', 'title' => lang('Auth.btn.editProfile') . ' ' . lang('General.for') . ' ' . $user->username, 'help' => getPageHelpUrl(uri_string()) ]) ?>

      <div class="card-body">

        <div class="card">

          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button
                  aria-controls="personal-tab-pane"
                  aria-selected="true"
                  class="nav-link active"
                  data-bs-toggle="tab"
                  data-bs-target="#personal-tab-pane"
                  id="personal-tab"
                  role="tab"
                  type="button"
                >
                  <?= lang('Profile.tab.personal') ?>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  aria-controls="contact-tab-pane"
                  aria-selected="false"
                  class="nav-link"
                  data-bs-toggle="tab"
                  data-bs-target="#contact-tab-pane"
                  id="contact-tab"
                  role="tab"
                  type="button"
                >
                  <?= lang('Profile.tab.contact') ?>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  aria-controls="options-tab-pane"
                  aria-selected="false"
                  class="nav-link"
                  data-bs-toggle="tab"
                  data-bs-target="#options-tab-pane"
                  id="options-tab"
                  role="tab"
                  type="button"
                >
                  <?= lang('Profile.tab.options') ?>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  aria-controls="avatar-tab-pane"
                  aria-selected="false"
                  class="nav-link"
                  data-bs-toggle="tab"
                  data-bs-target="#avatar-tab-pane"
                  id="avatar-tab"
                  role="tab"
                  type="button"
                >
                  <?= lang('Profile.tab.avatar') ?>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  aria-controls="2fa-tab-pane"
                  aria-selected="false"
                  class="nav-link"
                  data-bs-toggle="tab"
                  data-bs-target="#2fa-tab-pane"
                  id="2fa-tab"
                  role="tab"
                  type="button"
                >
                  <?= lang('Profile.tab.2fa') ?>
                </button>
              </li>
            </ul>
          </div>

          <div class="card-body">
            <div class="tab-content" id="myTabContent">

              <!--begin:Personal Tab-->
              <div class="tab-pane fade show active" id="personal-tab-pane" role="tabpanel" aria-labelledby="personal-tab">
                <div class="card">
                  <div class="card-body">
                    <?php
                    echo $bs->formRow([
                      'type' => 'text',
                      'mandatory' => false,
                      'name' => 'organization',
                      'title' => lang('Profile.organization'),
                      'desc' => lang('Profile.organization_desc'),
                      'errors' => session('errors.organization'),
                      'value' => array_key_exists('organization', $profile) ? $profile['organization'] : ''
                    ]);
                    echo $bs->formRow([
                      'type' => 'text',
                      'mandatory' => false,
                      'name' => 'position',
                      'title' => lang('Profile.position'),
                      'desc' => lang('Profile.position_desc'),
                      'errors' => session('errors.position'),
                      'value' => array_key_exists('position', $profile) ? $profile['position'] : ''
                    ]);
                    echo $bs->formRow([
                      'type' => 'text',
                      'mandatory' => false,
                      'name' => 'id',
                      'title' => lang('Profile.id'),
                      'desc' => lang('Profile.id_desc'),
                      'errors' => session('errors.id'),
                      'value' => array_key_exists('id', $profile) ? $profile['id'] : ''
                    ]);
                    ?>
                  </div>
                </div>
              </div>
              <!--end:Personal Tab-->

              <!--begin:Contact Tab-->
              <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab">
                <div class="card">
                  <div class="card-body">
                    <?php
                    echo $bs->formRow([
                      'type' => 'text',
                      'mandatory' => false,
                      'name' => 'phone',
                      'title' => lang('Profile.phone'),
                      'desc' => lang('Profile.phone_desc'),
                      'errors' => session('errors.phone'),
                      'value' => array_key_exists('phone', $profile) ? $profile['phone'] : ''
                    ]);
                    echo $bs->formRow([
                      'type' => 'text',
                      'mandatory' => false,
                      'name' => 'mobile',
                      'title' => lang('Profile.mobile'),
                      'desc' => lang('Profile.mobile_desc'),
                      'errors' => session('errors.mobile'),
                      'value' => array_key_exists('mobile', $profile) ? $profile['mobile'] : ''
                    ]);
                    echo $bs->formRow([
                      'type' => 'text',
                      'mandatory' => false,
                      'name' => 'facebook',
                      'title' => lang('Profile.facebook'),
                      'desc' => lang('Profile.facebook_desc'),
                      'errors' => session('errors.facebook'),
                      'value' => array_key_exists('facebook', $profile) ? $profile['facebook'] : ''
                    ]);
                    echo $bs->formRow([
                      'type' => 'text',
                      'mandatory' => false,
                      'name' => 'linkedin',
                      'title' => lang('Profile.linkedin'),
                      'desc' => lang('Profile.linkedin_desc'),
                      'errors' => session('errors.linkedin'),
                      'value' => array_key_exists('linkedin', $profile) ? $profile['linkedin'] : ''
                    ]);
                    echo $bs->formRow([
                      'type' => 'text',
                      'mandatory' => false,
                      'name' => 'instagram',
                      'title' => lang('Profile.instagram'),
                      'desc' => lang('Profile.instagram_desc'),
                      'errors' => session('errors.instagram'),
                      'value' => array_key_exists('instagram', $profile) ? $profile['instagram'] : ''
                    ]);
                    echo $bs->formRow([
                      'type' => 'text',
                      'mandatory' => false,
                      'name' => 'xing',
                      'title' => lang('Profile.xing'),
                      'desc' => lang('Profile.xing_desc'),
                      'errors' => session('errors.xing'),
                      'value' => array_key_exists('xing', $profile) ? $profile['xing'] : ''
                    ]);
                    ?>
                  </div>
                </div>
              </div>
              <!--end:Contact Tab-->

              <!--begin:Options Tab-->
              <div class="tab-pane fade" id="options-tab-pane" role="tabpanel" aria-labelledby="options-tab">
                <div class="card">
                  <div class="card-body">
                    <?php
                    echo $bs->formRow([
                      'type' => 'radio',
                      'mandatory' => false,
                      'name' => 'theme',
                      'title' => lang('Profile.theme'),
                      'desc' => lang('Profile.theme_desc'),
                      'errors' => session('errors.theme'),
                      'items' => array(
                        [ 'label' => lang('General.default'), 'value' => 'default', 'checked' => ($profile['theme'] === 'default' ? true : false) ],
                        [ 'label' => lang('Profile.light'), 'value' => 'light', 'checked' => ($profile['theme'] === 'light' ? true : false) ],
                        [ 'label' => lang('Profile.dark'), 'value' => 'dark', 'checked' => ($profile['theme'] === 'dark' ? true : false) ]
                      )
                    ]);
                    echo $bs->formRow([
                      'type' => 'radio',
                      'mandatory' => false,
                      'name' => 'menu',
                      'title' => lang('Profile.menu'),
                      'desc' => lang('Profile.menu_desc'),
                      'errors' => session('errors.menu'),
                      'items' => array(
                        [ 'label' => lang('General.default'), 'value' => 'default', 'checked' => ($profile['menu'] === 'default' ? true : false) ],
                        [ 'label' => lang('Profile.navbar'), 'value' => 'navbar', 'checked' => ($profile['menu'] === 'navbar' ? true : false) ],
                        [ 'label' => lang('Profile.sidebar'), 'value' => 'sidebar', 'checked' => ($profile['menu'] === 'sidebar' ? true : false) ]
                      )
                    ]);
                    echo $bs->formRow([
                      'type' => 'select',
                      'subtype' => 'single',
                      'name' => 'language',
                      'mandatory' => false,
                      'title' => lang('Profile.language'),
                      'desc' => lang('Profile.language_desc'),
                      'errors' => session('errors.language'),
                      'items' => $languageOptions,
                    ]);
                    ?>
                  </div>
                </div>
              </div>
              <!--end:Contact Tab-->

              <!--begin:Avatar Tab-->
              <div class="tab-pane fade" id="avatar-tab-pane" role="tabpanel" aria-labelledby="avatar-tab">
                <div class="card">
                  <div class="card-body">

                    <!-- Current Avatar -->
                    <div class="row">
                      <div class="col">
                        <strong><?= lang('Profile.avatar_current') ?></strong>
                      </div>
                      <div class="col">
                        <?php
                        $avatar = $avaUrl . "default_male.png";
                        if ($profile['avatar'] == "gravatar") {
                          $avatar = $gravatarUrl;
                        } else {
                          $avatar = $avaUrl . $profileAvatar;
                        } ?>
                        <img src="<?= $avatar ?>" width="72" height="72" alt="">
                      </div>
                    </div>
                    <hr class="my-4">

                    <!-- Gravatar -->
                    <div class="row">
                      <label class="col" for="gravatar">
                        <strong><?= lang('Profile.use_gravatar') ?></strong>
                      </label>
                      <div class="col">
                        <img src="<?= $gravatarUrl ?>" width="72" height="72" alt="" class="float-start me-2">
                        <input id="gravatar" name="avatar" type="radio" value="gravatar" <?= $profile['avatar'] === 'gravatar' ? 'checked' : '' ?>>
                      </div>
                    </div>
                    <hr class="my-4">

                    <?php foreach (config('App')->avatarSets as $set) {
                      $title = $set['title'];
                      $key = $set['set'];
                      $sample = $set['sample'];
                      ?>
                      <!-- <?= $title ?> Avatars -->
                      <div class="row">
                        <div class="col">
                          <strong>"<?= $title ?>" Avatars</strong><br>
                          <span class="text-normal clearfix">
                            <?= lang('Profile.avatar_credits') . ' <a href="' . $set['creditsLink'] . '" target="_blank">' . $set['creditsName'] . '</a>.' ?>
                          </span>
                        </div>
                        <div class="col">
                          <img src="<?= $avaUrl . $sample ?>" style="width:72px;height:72px;" alt="">
                          <button class="btn btn-primary mt-3 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $key ?>" aria-expanded="false" aria-controls="collapse-<?= $key ?>">
                            <?= lang('Profile.avatar_show') ?>...
                          </button>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="collapse col mt-4" id="collapse-<?= $key ?>">
                          <?php foreach ($avatars as $avatar) {
                            $fileNamePieces = explode('_', $avatar);
                            if (isset($fileNamePieces[1]) && isset($fileNamePieces[2]) && $fileNamePieces[1] === $key) {
                              $namePieces = explode('.', $fileNamePieces[2]);
                              $border = 'border: 1px solid #eeeeee; padding: 4px;';
                              $checked = '';
                              if ($profileAvatar == $avatar) {
                                $border = 'border: 2px solid #dd0000; padding: 2px;';
                                $checked = ' checked="checked" ';
                              } ?>
                              <div class="float-start" style="<?= $border ?>">
                                <label>
                                  <input name="opt_avatar" type="radio" value="<?= $avatar ?>" <?= $checked ?>>
                                </label>
                                <img src="<?= $avaUrl . $avatar ?>" style="width:72px;height:72px;" alt=""">
                              </div>
                            <?php }
                          } ?>
                        </div>
                      </div>
                      <hr class="my-4">
                    <?php } ?>

                  </div>
                </div>
              </div>
              <!--end:Avatar Tab-->

              <!--begin:2FA Tab-->
              <div class="tab-pane fade" id="2fa-tab-pane" role="tabpanel" aria-labelledby="2fa-tab" tabindex="0">
                <?php if (user()->hasSecret() && $settings['require2fa']) { ?>
                  <div class="alert alert-warning">
                    <?= lang('Auth.2fa.setup.secret_exists') ?>
                    <div><a href="<?= base_url() . '/setup2fa' ?>" class="btn btn-secondary mt-2"><?= lang('Navbar.user.setup2fa') ?></a></div>
                  </div>
                <?php } elseif (user()->hasSecret() && !$settings['require2fa']) { ?>
                  <div class="alert alert-warning">
                    <?= lang('Auth.2fa.setup.secret_exists_not_required') ?>
                    <div>
                      <a href="<?= base_url() . '/setup2fa' ?>" class="btn btn-secondary mt-2"><?= lang('Navbar.user.setup2fa') ?></a>
                      <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#modalRemoveSecret"><i class="bi bi-trash align-bottom me-2"></i><?= lang('Auth.btn.remove_secret') ?></button>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="alert alert-info">
                    <?= lang('Profile.2fa_desc') ?>
                    <div><a href="<?= base_url() . '/setup2fa' ?>" class="btn btn-secondary mt-2"><?= lang('Navbar.user.setup2fa') ?></a></div>
                  </div>
                <?php } ?>
                <?php
                  echo $bs->modal([
                    'id' => 'modalRemoveSecret',
                    'header' => lang('Auth.modal.confirm'),
                    'header_color' => 'danger',
                    'body' => lang('Profile.remove_secret_confirm') . "<br><br>" . lang('Profile.remove_secret_confirm_desc'),
                    'btn_color' => 'danger',
                    'btn_name' => 'btn_remove_secret',
                    'btn_text' => lang('Auth.btn.remove_secret'),
                  ]);
                ?>

              </div>
              <!--end:Contact Tab-->

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
