<?= $this->extend(config('App')->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">
  <div class="card">
    <?= $bs->cardHeader([ 'icon' => 'bi-vector-pen', 'title' => lang('App.imprint.title'), 'help' => 'https://github.com/glewe/lewe-teamcal' ]) ?>
    <div class="card-body">
      <h4>Applikation</h4>
      <p><?= config('AppInfo')->name ?> wurde von <?= config('AppInfo')->author ?> (<a href="<?= config('AppInfo')->authorUrl ?>"><?= config('AppInfo')->authorUrl ?></a>) entwickelt und erstellt.
        <?= config('AppInfo')->name ?> nutzt außerdem externe Module, die von ihren Autoren großzügigerweise der Öffentlichkeit zur Verfügung gestellt werden.
        Näheres dazu kann auf der <a href="<?= base_url() . 'about' ?>">Über Seite</a> eingesehen werden.</p>
      <h4>Inhalte</h4>
      <p>Alle Inhalte, die mit der <?= config('AppInfo')->name ?> Applikation ausgeliefert werden, wurden von George Lewe erstellt (mit Ausnahme der Module deren Autoren auf der <a href="<?= base_url() . 'about' ?>">Über Seite</a> ausgewiesen werden).
        Sollten Sie der Meinung sein, dass fremde Inhalte unangebracht oder nicht ausreichend gekennzeichnet genutzt werden, kontaktieren Sie bitte <a href="https://www.lewe.com/contact/">Lewe.com</a>.</p>
      <p>Keine der mit der Applikation ausgelieferten Inhalt dürfen ohne ausdrückliche schriftliche Erlaubnis von <?= config('AppInfo')->author ?> in keinster Weise reproduziert, kopiert oder anderweitig genutzt werden,
        weder ganz noch in Teilen.</p>
      <p><?= config('AppInfo')->name ?> ist eine Open Source Applikation. Nutzer können Inhalte hinzufügen. Der Hersteller der Applikation übernimmt keinerlei Verantwortung für diese Fremdinhalte.</p>
      <h4>Verknüpfungen</h4>
      <p>Alle Verknüpfungen, die mit der <?= config('AppInfo')->name ?> Applikation ausgeliefert werden, dienen nur der Bequemlichkeit und Information; sie bedeuten keine Meinung oder Zustimmung
        zu den Produkten, Dienstleistungen oder Meinungen, die von diesen externen Organisationen oder Einzelpersonen vertreten werden. Der Applikations Anbieter übernimmt keine Verantwortung für die Genauigkeit,
        Rechtmäßigkeit oder den Inhalt der externen Seiten. Kontaktieren Sie die externe Seite für Fragen zu deren Inhalt.</p>
      <h4>GDPR</h4>
      <p>Es werden keine persönlichen Daten mit <?= config('AppInfo')->name ?> ausgeliefert. Der Datenschutz der von den Nutzern hinzugefügten Inhalte obliegt alleinig dem Benutzer selbst.</p>
      <p><?= config('AppInfo')->name ?> bietet eine optionale GDPR Datenschutzerklärung. Wenn die Seite aktiviert wird, sind Benutzer dar Applikation verpflichtet die Erklärung zu überprüfen und
        entsprechend ihren Anforderungen gemäß anzupassen.</p>
      <p>Der Applikations Anbieter übernimmt keine Verantwortung für die Genauigkeit, Rechtmäßigkeit oder den Inhalt der Datenschutzerklärung.</p>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
