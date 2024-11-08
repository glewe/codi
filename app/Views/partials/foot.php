<!--begin::footer-->
<footer id="footer" class="mt-5 pt-3 fs-small">
  <div class="container">
    <div class="row mt-3">
      <div class="col-lg-4 col-md-4 col-sm-4 text-start ps-5 w-33">
        <span class="text-muted">
          &copy; <?= date('Y') ?> by <a href="<?= (isset($settings['footerCopyrightUrl'])) ? $settings['footerCopyrightUrl'] : config('AppInfo')->copyrightUrl ?>"><?= (isset($settings['footerCopyrightName'])) ? $settings['footerCopyrightName'] : config('AppInfo')->copyrightBy ?></a>
        </span>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 text-center w-33">
        <span class="text-muted"><a href="about"><?= lang('App.footer.about') ?></a> | <a href="imprint"><?= lang('App.footer.imprint') ?></a> | <a href="dataprivacy"><?= lang('App.footer.dataprivacy') ?></a></span><br>
        <span class="text-muted fst-italic fs-small">
          <!-- As per the license agreement, you are not allowed to change or remove the following block! -->
          Powered by <?= config('AppInfo')->name . ' ' . config('AppInfo')->version . ' © ' . date('Y') ?> by <a href="<?= config('AppInfo')->copyrightUrl ?>" target="_blank" rel="noopener"><?= config('AppInfo')->copyrightBy ?></a>
        </span>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 text-end w-33">
        <?php if (isset($settings['footerSocialLinks']) && strlen($settings['footerSocialLinks'])) {
          $urlArray = explode(';', $settings['footerSocialLinks']);
          foreach ($urlArray as $url) {
            if (strlen($url)) { ?>
              <span class="social-icon"><a href="<?= $url ?>" target="_blank"><i class="fab fs-5 mt-2"></i></a></span>
            <?php }
          }
        } ?>
      </div>
    </div>
  </div>
</footer>
<!--end::footer-->
