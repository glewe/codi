<?php

return [

  'pageTitle' => 'Datenbank-Wartung',

  'tab' => [
    'optimize' => 'Optimieren',
    'reset' => 'Zurücksetzen',
  ],

  'btn' => [
    'optimize' => 'Tabellen optimieren',
    'reset' => 'Datenbank zurücksetzen',
  ],

  'optimize' => 'Datenbanktabellen optimieren',
  'optimize_desc' => 'Durch die Optimierung der Datenbanktabellen kann die Leistung des Systems verbessert werden. Es wird die physische Speicherung der
    Tabellendaten und der zugehörigen Indexdaten neu organisiert, um den Speicherplatz zu reduzieren und die I/O-Effizienz beim Zugriff auf die Tabellen zu verbessern. Dieser Vorgang kann einige Zeit in Anspruch nehmen.',
  'optimize_success' => 'Die Datenbanktabellen wurden erfolreich optimiert.',

  'resetConfirm' => 'Bestätigen',
  'resetConfirm_desc' => 'Durch das Zurücksetzen der Datenbank werden alle Ihre Informationen durch die Installationsbeispieldaten ersetzt.
    Geben Sie folgendes in das Textfeld ein, um Ihre Entscheidung zu bestätigen: "YesIAmSure".',
  'reset_warning' => '<strong>Achtung!</strong> Dadurch wird die Datenbank auf Beispieldaten zurückgesetzt. Alle Ihre Daten gehen verloren.',
  'reset_success' => 'Die Datenbank wurde erfolgreich auf Beispieldaten zurückgesetzt.',

];
