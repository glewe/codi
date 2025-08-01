<?php

return [

  'pageTitle' => 'Lizenz',

  // _Global
  'description' => 'Beschreibung',
  'getHelpForPage' => 'Hilfe f&uuml;r diese Seite...',
  'license' => 'Lizenz',
  'activation_fail' => 'Der folgende Fehler ist beim Aktivieren der Lizenz aufgetreten:',
  'activation_help' => 'Die Lizenz ist g&uuml;ltig aber noch nicht aktiviert. Bitte aktiviere sie.',
  'activation_success' => 'Die Lizenz wurde erfolgreich aktiviert.',
  'active' => 'Aktive Lizenz',
  'active_subject' => 'Dies ist eine aktive Lizenz f&uuml;r diese Domain. Hervorragend!',
  'active_unregistered_subject' => 'Dies ist eine aktive Lizenz aber nicht f&uuml;r diese Domain registriert.',
  'blocked' => 'Blockierte Lizenz',
  'blocked_subject' => 'Diese Lizenz ist blockiert.',
  'blocked_help' => 'Bitte kontaktiere deinen Administrator, um die Lizenz wieder freizuschalten.',
  'close_this_message' => 'Diese Nachricht schlie&szlig;en',
  'company' => 'Firma',
  'date_created' => 'Angelegt am',
  'date_expiry' => 'L&auml;ft aus am',
  'date_renewed' => 'Erneuert am',
  'daysleft' => 'Tage &uuml;brig',
  'deregistration_fail' => 'Der folgende Fehler ist beim Deregistrieren der Lizenz f&uuml;r diese Domain aufgetreten:',
  'deregistration_help' => 'Du kannst diese Domain von der Lizenz deregistrieren, z.B. wenn du auf eine neuen Domain umziehen willst. Deregistriere diese Domain hier und registriere die neue von dort.',
  'deregistration_success' => 'Die Domain wurde erfolgreich von der Lizenz deregistriert.',
  'details' => 'Lizenzdetails',
  'email' => 'E-mail',
  'expired' => 'Abgelaufene Lizenz',
  'expired_subject' => 'Diese Lizenz ist abgelaufen.',
  'expired_help' => 'Bitte kontaktiere deinen Administrator, um die Lizenz zu erneuern.',
  'expiringsoon' => 'Lizenz Ablaufwarnung',
  'expiringsoon_subject' => 'Deine Lizenz wird in %d Tagen ablaufen.',
  'expiringsoon_help' => 'Bitte kontaktiere deinen Administrator, um die Lizenz rechtzeitig zu erneuern.',
  'invalid' => 'Ung&uuml;ltige Lizenz',
  'invalid_subject' => 'Der Lizenzschl&uuml;ssel wurde nicht gefunden oder ist ung&uuml;tig.',
  'invalid_text' => 'Diese Domain ist nicht registriert oder der Lizenzschl&uuml;ssel fehlt oder wurde noch nicht aktiviert.',
  'invalid_help' => 'Bitte kontaktiere deinen Administrator, um eine g&uumlltige Lizenz zu installieren.',
  'invalid_save' => 'Du kannst den Lizenschl&uuml;ssel oben &auml;ndern und speichern, um den Check zu wiederholen.',
  'key' => 'Lizenzschl&uuml;ssel',
  'key_help' => 'Gib den Lizenzschl&uuml;ssel hier ein oder &auml;ndere ihn. Er wurde bei der Bestellung zugesandt.',
  'max_allowed_domains' => 'Maximal Erlaubte Domains',
  'name' => 'Lizenznehmer',
  'pending' => 'Ausstehende Lizenz',
  'pending_subject' => 'Diese Lizenz ist g&uuml;ltig oder wurde noch nicht aktiviert.',
  'pending_help' => 'Bitte kontaktiere deinen Administrator, um die Lizenz zu aktivieren.',
  'product' => 'Produkt',
  'registered_domains' => 'Registrierte Domains',
  'registration_fail' => 'Der folgende Fehler ist beim Registrieren der Lizenz f&uuml;r diese Domain aufgetreten:',
  'registration_help' => 'Diese Domain ist nicht f&uuml;r diesen Lizenzschl&uuml;ssel registriert.<br>Wenn die Lizenz mehrere Domains erlaubt, klicke den <var>Registrieren</var> Knopf um diese Domain hinzuzuf&uuml;gen.',
  'registration_success' => 'Die Domain wurde erfolgreich f&uuml;r diese Lizenz registriert.',
  'status' => 'Status',
  'unregistered' => 'Unregistrierte Lizenz',
  'unregistered_subject' => 'Der Lizenzschl&uuml;ssel ist nicht f&uuml;r diese Domain registriert.',
  'unregistered_help' => 'Bitte kontaktiere deinen Administrator um eine diese Domain zu registrieren oder einen g&uuml;tigen Lizenzschl&uuml;ssel zu erhalten.',

  'alert' => [
    'error' => 'Fehler',
    'information' => 'Information',
    'warning' => 'Warnung',
    'api_error' => 'Es gab ein Problem bei der Kommunikation mit dem Lizenzserver.'
  ],

  // Buttons
  'btn' => [
    'action' => 'Aktion',
    'activate' => 'Aktivieren',
    'cancel' => 'Abbrechen',
    'create' => 'Anlegen',
    'deactivate' => 'Deaktivieren',
    'deregister' => 'Deregistrieren',
    'delete' => 'L&ouml;sdchen',
    'edit' => 'Editieren',
    'register' => 'Registrierenr',
    'reset' => 'Zur&uuml;cksetzen',
    'save' => 'Speichern',
    'search' => 'Suchen',
    'submit' => 'Abschicken',
    'view' => 'Anzeigen',
  ],

  //
  // Exceptions
  //
  'exception' => [
    'blocked' => 'Dein Lizenzschlüssel ist blockiert.',
    'expired' => 'Dein Lizenzschlüssel ist abgelaufen.',
    'invalid' => 'Dein Lizenzschlüssel ist ungültig.',
    'nokey' => 'Es wurde kein Lizenzschlüssel gefunden.',
    'pending' => 'Dein Lizenzschlüssel muss noch aktiviert werden.',
    'unregistered' => 'Für deinen Lizenzschlüssel ist aktiviert aber noch nicht registriert.',
  ],

  // Modal Dialogs
  'modal' => [
    'confirm' => 'Bitte Best&auml;tigen',
  ],

  // Navbar
  'nav' => [
    'home' => 'Home',
    'license' => [
      'self' => 'Lizenz',
      'show' => 'Anzeigen',
    ],
  ],

];
