<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">
  <div class="card">
    <?= $bs->cardHeader([ 'icon' => 'bi-vector-pen', 'title' => lang('App.imprint.title'), 'help' => 'https://github.com/glewe/lewe-ci4' ]) ?>
    <div class="card-body">
      <h4>Application</h4>
      <p><?= config('AppInfo')->name ?> was created by <?= config('AppInfo')->author ?> (<a href="<?= config('AppInfo')->authorUrl ?>"><?= config('AppInfo')->authorUrl ?></a>).
        <?= config('AppInfo')->name ?> also uses free modules by other great people providing them to the public.
        See detailed credits on the <a href="<?= base_url() . 'about' ?>">About page</a>.</p>
      <h4>Content</h4>
      <p>All content delivered with the <?= config('AppInfo')->name ?> application was created by George Lewe (except indicated otherwise on the <a href="<?= base_url() . 'about' ?>">About page</a>).
        If you feel that any material is used inappropriately, please contact <a href="https://www.lewe.com/contact/">Lewe.com</a>.</p>
      <p>None of the distributed application content, as a whole or in parts may be reproduced, copied or reused in any form or by any means, electronic or mechanical,
        for any purpose, without the express written permission of George Lewe.</p>
      <p><?= config('AppInfo')->name ?> is an open source application. Users of the application may have added further content to it. The application provider bears no
        responsibility for the accuracy, legality or content of such additions.</p>
      <h4>Links</h4>
      <p>All links delivered with the <?= config('AppInfo')->name ?> application are being provided as a convenience
        and for informational purposes only; they do not constitute an endorsement or an approval by <?= config('AppInfo')->name ?> of the products, services or opinions
        of the corporation or organization or individual. The application provider bears no responsibility for the accuracy, legality or content of the external site or
        for that of subsequent links. Contact the external site for questions regarding its content.</p>
      <h4>GDPR</h4>
      <p>No personal data is delivered with the <?= config('AppInfo')->name ?> application. Data privacy protection of any data added by users lies in the
        responsibility of the user.</p>
      <p><?= config('AppInfo')->name ?> provides a general GDPR generator. If used, users of the application are obliged to review the generated statement
        and to change or add any details that the generator does not properly cover.</p>
      <p>The application provider bears no responsibility for the accuracy,
        legality or content of the Data Privacy statement used on any installation of the application.</p>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
