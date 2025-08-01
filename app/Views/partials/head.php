<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>

  <meta http-equiv="Content-type" content="text/html;charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8" />
  <base href="<?= base_url() ?>" />

  <!-- App Info -->
  <title><?= (isset($settings['applicationName'])) ? $settings['applicationName'] : '' ?> <?= (isset($page)) ? ' | ' . $page : '' ?></title>
  <meta name="title" content="<?= config('Config\AppInfo')->name; ?>">
  <meta name="description" content="<?= config('Config\AppInfo')->description ?>">
  <meta name="keywords" content="<?= config('Config\AppInfo')->keywords ?>">
  <meta name="author" content="<?= config('Config\AppInfo')->author ?>">
  <meta name="version" content="<?= config('Config\AppInfo')->version ?>">
  <meta name="date" content="<?= config('Config\AppInfo')->releaseDate ?>">

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= base_url('images/icons/app-icon-32.png') ?>">

  <?php if (isset($settings['noCaching']) && $settings['noCaching']) { ?>
    <!-- Disable Caching -->
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
  <?php } ?>
  <!-- Robots -->
  <meta name="robots" content="<?= (isset($settings['robots'])) ? $settings['robots'] : 'noindex' ?>" />

  <!-- Social Media, Icons -->
  <link rel="canonical" href="<?= base_url() ?>">
  <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('images/icons/app-icon-57.png') ?>">
  <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('images/icons/app-icon-60.png') ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('images/icons/app-icon-72.png') ?>">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('images/icons/app-icon-76.png') ?>">
  <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('images/icons/app-icon-114.png') ?>">
  <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('images/icons/app-icon-120.png') ?>">
  <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('images/icons/app-icon-144.png') ?>">
  <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('images/icons/app-icon-152.png') ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('images/icons/app-icon-180.png') ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('images/icons/app-icon-16.png') ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('images/icons/app-icon-32.png') ?>">
  <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('images/icons/app-icon-96.png') ?>">
  <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('images/icons/app-icon-192.png') ?>">
  <link rel="manifest" href="<?= base_url('images/icons/manifest.webmanifest') ?>">
  <meta name="theme-color" content="#ffffff">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?= base_url('images/icons/app-icon-144.png') ?>">
  <meta property="og:locale" content="en_US">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= config('Config\AppInfo')->name ?>">
  <meta property="og:description" content="<?= config('Config\AppInfo')->description ?>">
  <meta property="og:url" content="<?= base_url() ?>">
  <meta property="og:site_name" content="<?= config('Config\AppInfo')->name ?>">
  <meta property="og:image" content="<?= base_url('images/og-image.png') ?>">
  <meta property="og:image:secure_url" content="<?= base_url('images/og-image.png') ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:locale" content="en_US">
  <meta property="og:updated_time" content="<?= date('Y-m-d H:i:s') ?>">
  <meta name="twitter:card" content="summary">
  <meta name="twitter:description" content="<?= config('Config\AppInfo')->description ?>">
  <meta name="twitter:title" content="<?= config('Config\AppInfo')->name ?>">
  <meta name="twitter:image" content="<?= base_url('images/twitter-image.png') ?>">

  <!-- Bootstrap Color Mode Switcher -->
  <script src="js/color-modes.min.js"></script>

  <!-- Bootstrap Width Mode Switcher -->
  <script src="js/width-modes.min.js"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="fonts/fontawesome-free-6.7.2-web/css/all.min.css">

  <!-- Fonts (served locally due to GDPR constraints) -->
  <link rel="stylesheet" href="css/font-<?= $settings['font'] ?>.min.css">

  <!-- Cookie Consent -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent/3.1.1/cookieconsent.min.css" integrity="sha512-LQ97camar/lOliT/MqjcQs5kWgy6Qz/cCRzzRzUCfv0fotsCTC9ZHXaPQmJV8Xu/PVALfJZ7BDezl5lW3/qBxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Datatables CSS -->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.2/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/b-print-3.2.4/r-3.0.5/datatables.min.css" rel="stylesheet" integrity="sha384-ZjEDUJp1nW8KqHTQvJzZt+epElsOCgauH1k+/LwE6jZybUl8FoQWtY5wPXQXeWML" crossorigin="anonymous">

  <!-- Application CSS -->
  <link href="css/styles.min.css" rel="stylesheet" type="text/css" />

  <!-- Custom CSS-->
  <link href="css/custom.min.css" rel="stylesheet" type="text/css" />

  <!-- jQuery JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- jQuery UI JS -->
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>

  <!-- Coloris picker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css" />
  <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>

  <!-- Date Time Picker -->
  <link rel="stylesheet" href="addons/datetimepicker/jquery.datetimepicker.min.css">
  <script src="addons/datetimepicker/jquery.datetimepicker.full.min.js"></script>

  <!-- ChartJs -->
  <script src="addons/chartjs-4.4.5/chart.umd.min.js"></script>

  <!-- HighlightJs -->
  <?php if (isset($settings['highlightJsTheme']) && $settings['highlightJsTheme'] === 'light') { ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/styles/default.min.css" integrity="sha512-hasIneQUHlh06VNBe7f6ZcHmeRTLIaQWFd43YriJ0UND19bvYRauxthDg8E4eVNPm9bRUhr5JGeqH7FRFXQu5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?php } else { ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/styles/dark.min.css" integrity="sha512-bfLTSZK4qMP/TWeS1XJAR/VDX0Uhe84nN5YmpKk5x8lMkV0D+LwbuxaJMYTPIV13FzEv4CUOhHoc+xZBDgG9QA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?php } ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/highlight.min.js" integrity="sha512-6yoqbrcLAHDWAdQmiRlHG4+m0g/CT/V9AGyxabG8j7Jk8j3r3K6due7oqpiRMZqcYe9WM2gPcaNNxnl2ux+3tA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/languages/javascript.min.js" integrity="sha512-XrpvbK+zc0wErJG1VptH0H4w4zyiniHOBR35DJ1VISA+cqYxhksvqFwZk0M8lX9ylaIjTXoMYolOPb93zdrGpg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/languages/css.min.js" integrity="sha512-fpDUuCO8gpUPZ7TzS3mjJsopogeCbFf94kXHQNzOdEQXksHWOiOHaynatkhBRQraX1GMVtLlU5Z/8NWuK8TLLw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/languages/php.min.js" integrity="sha512-Gde2hoEUx5qPs6AgZnAU4U9t+T93OyFaTL0xBrMflHP2nU7jOpUtaYQ5l32YGLgnwOKPkl7S8YTM2FHMRWmebg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Lightbox2 -->
  <link rel="stylesheet" href="addons/lightbox2-2.11.5/css/lightbox.min.css" type="text/css">
  <script src="addons/lightbox2-2.11.5/js/lightbox.min.js"></script>

  <!-- TinyMCE -->
  <script src="<?= base_url('addons/tinymce/tinymce.min.js'); ?>"></script>

  <?php if ($settings['cookieConsent']) { ?><!-- Cookie Consent -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.1/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.1/cookieconsent.min.js"></script>
  <?php } ?>
  <script>
    window.addEventListener("load", function() {
      window.cookieconsent.initialise({
        "cookie": {
          "name": "leweteamcal_cookieconsent"
        },
        "palette": {
          "popup": {
            "background": "#252e39"
          },
          "button": {
            "background": "#14a7d0"
          }
        },
        "theme": "classic",
        "content": {
          "message": "<?= lang('App.cookie.message') ?>",
          "link": "<?= lang('App.cookie.learnMore') ?>",
          "dismiss": "<?= lang('App.cookie.dismiss') ?>",
          "href": "<?= base_url() ?>dataprivacy"
        }
      })
    });
  </script>

  <?php if ($settings['googleAnalytics'] && strlen($settings['googleAnalyticsId'])) { ?><!--Begin: Google Analytics GA4-->
    <script>
      // Define dataLayer and the gtag function.
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }

      // Set default consents to 'denied'
      // Set analytic consent to 'granted' (see Imprint page for opt-out option)
      gtag('consent', 'default', {
        'ad_storage': 'denied',
        'ad_user_data': 'denied',
        'ad_personalization': 'denied',
        'analytics_storage': 'granted'
      });
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $settings['googleAnalyticsId'] ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }

      gtag('js', new Date());
      gtag('config', '<?= $settings['googleAnalyticsId'] ?>');

      // Opt out to GA
      function gaOptout() {
        gtag('consent', 'update', {
          'analytics_storage': 'denied'
        });
      }
    </script>
    <!--End: Google Analytics GA4-->
  <?php } ?>

</head>

<body>

  <!-- Back to Top -->
  <a id="top-link-block"><i class="fas fa-chevron-up fa-2x text-white p-2"></i></a>