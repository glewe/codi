<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!-- DataTables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.js"></script>

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
