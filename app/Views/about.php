<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">

  <?= view('partials/alert') ?>

  <div class="card mb-3">
    <?= $bs->cardHeader([
      'icon' => 'bi-question-circle-fill',
      'title' => lang('App.about.about') . ' ' . config('AppInfo')->name,
      'help' => getPageHelpUrl(uri_string())
    ])
    ?>
    <div class="card-body row">
      <div class="col-lg-2 align-self-center text-start align-self-baseline">
        <i class="<?= config('AppInfo')->icon ?> fa-8x logo-gradient float-start"></i>
      </div>
      <div class="col-lg-10 align-self-center">
        <h4><?= config('AppInfo')->name ?></h4>
        <p>
          <strong><?= lang('Auth.about.version') ?>:</strong>&nbsp;&nbsp;<?= config('AppInfo')->version ?><span id="versioncompare"></span><br>
          <strong><?= lang('Auth.about.copyright') ?>:</strong>&nbsp;&nbsp;&copy;&nbsp;<?= config('AppInfo')->firstYear . '-' . date('Y') ?> by <a class="about" href="<?= config('AppInfo')->authorUrl ?>" target="_blank" rel="noopener"><?= config('AppInfo')->author ?></a><br>
          <strong><?= lang('Auth.about.support') ?>:</strong>&nbsp;&nbsp;<a href="<?= config('AppInfo')->supportUrl ?>" target="_blank" rel="noopener">GitHub Issues</a><br>
          <strong><?= lang('Auth.about.documentation') ?>:</strong>&nbsp;&nbsp;<a class="about" href="<?= config('AppInfo')->documentationUrl ?>" target="_blank" rel="noopener">n/a</a><br>
          <strong><?= lang('App.about.source_code') ?>:</strong>&nbsp;&nbsp;<a class="about" href="<?= config('AppInfo')->repoUrl ?>" target="_blank" rel="noopener">CODI on GitHub</a><br>
          <strong><?= lang('App.about.download') ?>:</strong>&nbsp;&nbsp;<a class="about" href="<?= config('AppInfo')->downloadUrl ?>" target="_blank" rel="noopener">Releases</a><br>
        </p>
      </div>
    </div>
  </div>

  <?php if ($settings['versionCheck']) { ?>
    <script src="<?= config('AppInfo')->versionScript ?>"></script>
    <script>
      const running_version = parseVersionString('<?= config('AppInfo')->version ?>');
      if (running_version.major < latest_version.major) {
        //
        // Major version smaller
        //
        document.getElementById("versioncompare").innerHTML = '&nbsp;&nbsp;<a class="btn btn-sm btn-danger" href="<?= config('AppInfo')->downloadUrl ?>" target="_blank"><?= lang('App.about.majorUpdateAvailable') ?></a>';
      } else if (running_version.major === latest_version.major) {
        //
        // Major version equal
        //
        if (running_version.minor < latest_version.minor || (running_version.minor === latest_version.minor && running_version.patch < latest_version.patch)) {
          //
          // Minor version smaller OR (minor version equal AND patch version smaller)
          //
          document.getElementById("versioncompare").innerHTML = '&nbsp;&nbsp;<a class="btn btn-sm btn-warning" href="<?= config('AppInfo')->downloadUrl ?>" target="_blank"><?= lang('App.about.minorUpdateAvailable') ?></a>';
        } else {
          //
          // Same versions
          //
          //document.getElementById("versioncompare").innerHTML = '&nbsp;&nbsp;<a class="btn btn-sm btn-success" href="<?= config('AppInfo')->downloadUrl ?>" target="_blank"><?= lang('App.about.newestVersion') ?></a>';
        }
      }
    </script>
  <?php } ?>

  <?php if (config('AppInfo')->showCredits) { ?>
    <!--begin::Credits-->
    <div class="card my-3">
      <div class="card-header cursor-pointer">
        <div data-bs-toggle="collapse" href="#credits" role="button" aria-expanded="false" aria-controls="credits">
          <div class="row">
            <div class="col-lg-12">
              <i class="bi-hand-thumbs-up-fill me-3"></i><?= lang('Auth.about.credits') ?>...
            </div>
          </div>
        </div>
      </div>
      <div class="collapse" id="credits">
        <div class="card-body mt-2">
          <ul>
            <?php foreach (config('AppInfo')->credits as $key => $credit) { ?>
              <li><?= $credit['author'] . ' ' . lang('Auth.for') ?> <a href="<?= $credit['url'] ?>" target="_blank" rel="noopener"><?= $credit['product'] . (strlen($credit['version']) ? ' (' . $credit['version'] . ')' : '')?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <!--end::Credits-->
  <?php } ?>

  <?php if (config('AppInfo')->showReleaseInfo) { ?>
    <!--begin::Release Information-->
    <div class="card my-3">
      <div class="card-header cursor-pointer">
        <div data-bs-toggle="collapse" href="#releaseInformation" role="button" aria-expanded="false" aria-controls="releaseInformation">
          <div class="row">
            <div class="col-lg-12">
              <i class="bi-exclamation-circle-fill me-3"></i><?= lang('Auth.about.release_info') ?>...
            </div>
          </div>
        </div>
      </div>
      <div class="collapse" id="releaseInformation">
        <div class="card-body">
          <?php require_once 'partials\releaseinfo.phtml'; ?>
        </div>
      </div>
    </div>
    <!--begin::Release Information-->
  <?php } ?>

  <?php if (ENVIRONMENT === 'development') { ?>
    <div class="card my-3">
      <div class="card-header cursor-pointer">
        <div data-bs-toggle="collapse" href="#frameworkInformation" role="button" aria-expanded="false" aria-controls="frameworkInformation">
          <div class="row">
            <div class="col-lg-12">
              <i class="bi-exclamation-circle-fill me-3"></i><?= lang('App.about.framework_information') ?>...
            </div>
          </div>
        </div>
      </div>
      <div class="collapse" id="frameworkInformation">
        <div class="card-body">
          <p>
            PHP Version <?= phpversion() ?><br>
            CodeIgniter <?= CodeIgniter\CodeIgniter::CI_VERSION ?><br>
            CI4-Auth <?= config('AuthInfo')->version ?><br>
            CI4-Lic <?= config('LicInfo')->version ?><br>
            Page rendered in {elapsed_time} seconds<br>
            Environment: <?= ENVIRONMENT ?>
          </p>
        </div>
      </div>
    </div>
  <?php } ?>

</div>

<?= $this->endSection() ?>
