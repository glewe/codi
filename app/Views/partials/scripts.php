<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>

<!-- DataTables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.2/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/b-print-3.2.4/r-3.0.5/datatables.min.js" integrity="sha384-fqukR154yKDgd2HRf9T/B4CtQGyrXJs8G9HUTauYgORjBVPpANUkplKhm6N5KXCH" crossorigin="anonymous"></script>

<!-- Cookie Consent -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent/3.1.1/cookieconsent.min.js" integrity="sha512-yXXqOFjdjHNH1GND+1EO0jbvvebABpzGKD66djnUfiKlYME5HGMUJHoCaeE4D5PTG2YsSJf6dwqyUUvQvS0vaA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  //
  // Cookie Consent
  //
  window.addEventListener("load", function () {
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
        "href": "dataprivacy"
      }
    })
  });

  //
  // Back to Top Icon
  //
  $(function () {
    var btn = $('#top-link-block');
    $(window).scroll(function () {
      if ($(window).scrollTop() > 400) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });
    btn.on('click', function (e) {
      e.preventDefault();
      $('html, body').animate({
        scrollTop: 0
      }, '400');
    });
  });

  //
  // Show Bootstrap Toasts
  //
  var toastElList = [].slice.call(document.querySelectorAll('.toast'))
  var toastList = toastElList.map(function (toastEl) {
    return new bootstrap.Toast(toastEl)
  });
  toastList.forEach(toast => toast.show());
  console.log(toastList);

  //
  // Enable Bootstrap Tooltips
  //
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

  <?php if (isset($settings['autocloseAlertSuccess']) && $settings['autocloseAlertSuccess']) { ?>//
  // Autohide success alerts
  //
  $(".alert-success-dismissible").fadeTo(<?=$settings['autocloseDelay']?>, 500).slideUp(500, function () {
    $(".alert-success-dismissible").slideUp(500);
  });
  <?php } ?>

  <?php if (isset($settings['autocloseAlertWarning']) && $settings['autocloseAlertWarning']) { ?>//
  // Autohide warning alerts
  //
  $(".alert-warning-dismissible").fadeTo(<?=$settings['autocloseDelay']?>, 500).slideUp(500, function () {
    $(".alert-warning-dismissible").slideUp(500);
  });
  <?php } ?>

  <?php if (isset($settings['autocloseAlertDanger']) && $settings['autocloseAlertDanger']) { ?>//
  // Autohide danger alerts
  //
  $(".alert-danger-dismissible").fadeTo(<?=$settings['autocloseDelay']?>, 500).slideUp(500, function () {
    $(".alert-danger-dismissible").slideUp(500);
  });
  <?php } ?>

</script>

<!-- Application script -->
<script src="js/script.min.js"></script>

<!-- Custom script -->
<script src="js/custom.min.js"></script>

</body>
</html>
