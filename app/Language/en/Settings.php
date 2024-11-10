<?php

return [

  'pageTitle' => 'System Settings',

  'tab' => [
    'general' => 'Allgemein',
    'email' => 'E-Mail',
    'footer' => 'Footer',
    'homepage' => 'Startseite',
    'authentication' => 'Authentication',
    'gdpr' => 'GDPR',
    'system' => 'System',
    'theme' => 'Theme',
  ],
  'alerts' => 'Alert Messages',
  'alerts_desc' => 'With this option, you can select which result messages are displayed. The messages are usually displayed at the top of the screen.',
  'alerts_all' => 'All (incl. success messages)',
  'alerts_errors' => 'Warnings and errors only',
  'alerts_none' => 'None',
  'allowRegistration' => 'Allow Registration',
  'allowRegistration_desc' => 'If this option is enabled, users can register themselves. If it is disabled, only the administrator can create new users.',
  'allowRemembering' => 'Remember Me',
  'allowRemembering_desc' => 'If this option is enabled, the user will be remembered for 14 days and automatically logged in when returning to the application.',
  'applicationName' => 'Application Nname',
  'applicationName_desc' => 'Enter an application title here. It is used at several locations, e.g. the HTML header, menu and other pages where the title is referenced.',
  'applicationUrl' => 'Applikations URL',
  'applicationUrl_desc' => 'The URL of the application. Used for generating links and emails.',
  'autocloseAlertSuccess' => 'Autoclose Dismissible Success Alert Messages',
  'autocloseAlertSuccess_desc' => 'With this option on, dismissible success alert messages are automatically closed after a period of time. You can set the delay below.',
  'autocloseAlertWarning' => 'Autoclose Dismissible Warning Alert Messages',
  'autocloseAlertWarning_desc' => 'With this option on, dismissible warning alert messages are automatically closed after a period of time. You can set the delay below.',
  'autocloseAlertDanger' => 'Autoclose Dismissible Error Alert Messages',
  'autocloseAlertDanger_desc' => 'With this option on, dismissible error alert messages are automatically closed after a period of time. You can set the delay below.',
  'autocloseDelay' => 'Autoclose Delay',
  'autocloseDelay_desc' => 'Enter the time in milliseconds after which the dismissible alert messages are automatically closed. The default is 5000 milliseconds (5 seconds).',
  'cookieConsent' => 'Cookie Consent',
  'cookieConsent_desc' => 'With this option, a cookie consent is displayed at the bottom of the screen. The user can accept or decline the notice. This is a requirement in the EU.',
  'dataPrivacyPolicy' => 'Data Privacy Policy',
  'dataPrivacyPolicy_desc' => 'Check to activate the data privacy policy in the Help menu. In that case, fill in the fields below since they will be used in the Privacy Policy text.',
  'defaultLanguage' => 'Default Language',
  'defaultLanguage_desc' => 'The application contains the languages English and German. The administrator may have installed additional languages. Here you can set the default language.',
  'defaultMenu' => 'Default Menu',
  'defaultMenu_desc' => 'Select the default menu. The sidebar on the left is better suited for larger screens while the navbar on top is better adjusting to smaller screens.',
  'defaultMenu_navbar' => 'Navbar top',
  'defaultMenu_sidebar' => 'Sidebar left',
  'defaultTheme' => 'Default Theme',
  'defaultTheme_desc' => 'Select the default theme for the application.',
  'defaultTheme_dark' => 'Dark',
  'defaultTheme_light' => 'Light',
  'email' => [
    'applicationUrl' => 'Settings.email.applicationUrl',
    'applicationName' => 'Settings.email.applicationName',
    'htmlDescription' => 'Settings.email.htmlDescription',
    'htmlKeywords' => 'Settings.email.htmlKeywords',
    'emailReply' => 'Settings.email.emailReply',
  ],
  'emailFrom' => 'Mail From',
  'emailFrom_desc' => 'Specify a name to be shown as sender of notification e-mails.',
  'emailNotifications' => 'E-Mail Notifications',
  'emailNotifications_desc' => 'Enable/Disable email notifications. If this option is turned off, no automatic notifications will be sent by email. This does not apply to registration and password reset emails. Those are always sent.',
  'emailReply' => 'Mail Reply-To',
  'emailReply_desc' => 'Specify an e-mail address to reply to for notification e-mails. This field must contain a valid e-mail address. If that is not the case a dummy e-mail address will be saved.',
  'emailSMTP' => 'Use external SMTP server',
  'emailSMTP_desc' => 'Use an external SMTP server instead of the PHP mail() function to send out eMails. This feature requires the PEAR Mail package to be installed on your server. Many hosters install this package by default.',
  'emailSMTPAnonymous' => 'Anonymous SMTP',
  'emailSMTPAnonymous_desc' => 'Use SMTP connection without authentication.',
  'emailSMTPhost' => 'SMTP Host',
  'emailSMTPhost_desc' => 'Specify the SMTP host name.',
  'emailSMTPport' => 'SMTP Port',
  'emailSMTPport_desc' => 'Specify the SMTP host port.',
  'emailSMTPusername' => 'SMTP Username',
  'emailSMTPusername_desc' => 'Specify the SMTP username.',
  'emailSMTPpassword' => 'SMTP Password',
  'emailSMTPpassword_desc' => 'Specify the SMTP password.',
  'emailSMTPCrypto' => 'SMTP Encryption',
  'emailSMTPCrypto_desc' => 'What encryption shall be used for the SMTP connection',
  'emailSMTPCrypto_none' => 'None',
  'emailSMTPCrypto_ssl' => 'SSL',
  'emailSMTPCrypto_tls' => 'TLS',
  'font' => 'Font',
  'font_desc' => 'Select the font for the application. These Google fonts are not loaded from Google but local from the application.',
  'footerCopyrightName' => 'Footer Copyright Name',
  'footerCopyrightName_desc' => 'Will be displayed in the left footer section. Just enter the name, the (current) year will be displayed automatically.',
  'footerCopyrightUrl' => 'Footer Copyright URL',
  'footerCopyrightUrl_desc' => 'Enter the URL to which the footer copyright name shall link to. If none is provided, just the name is displayed.',
  'footerSocialLinks' => 'Footer Social Links',
  'footerSocialLinks_desc' => 'Your social links will be converted to corresponding icons and displayed in the right footer section. Enter all URLs to the social sites you want to link to. Separate them by semicolon.',
  'gdprController' => 'GDPR Controller',
  'gdprController_desc' => 'Enter the contact details of the controller responsible for data protection.',
  'gdprOrganization' => 'GDPR Organization',
  'gdprOrganization_desc' => 'Enter the name of the organization responsible for data protection.',
  'gdprPrivacyOfficer' => 'GDPR Data Protection Officer',
  'gdprPrivacyOfficer_desc' => 'Enter the contact details of the data protection officer.',
  'googleAnalytics' => 'Google Analytics',
  'googleAnalytics_desc' => 'The application supports Google Analytics. If you run your instance in the Internet and want to use Google Analytics to trace access to it, you can check this switch and enter your Google Analytics ID (GA4) below.',
  'googleAnalyticsId' => 'Google Analytics ID (GA4)',
  'googleAnalyticsId_desc' => 'Enter your Google Analytics ID (GA4) here. It is a string like "G-XXXXXXXXXX". If the Google Analytics switch is off, this value will have no effect.',
  'highlightJsTheme' => 'Highlight.js Theme',
  'highlightJsTheme_desc' => 'If you use Highlight.js to display syntax-colored source code, you can select between a light and a dark theme here.',
  'highlightJsTheme_dark' => 'Dark',
  'highlightJsTheme_light' => 'Light',
  'htmlDescription' => 'HTML Description',
  'htmlDescription_desc' => 'Enter a description of the application here. It is used in the HTML header for search engines.',
  'htmlKeywords' => 'HTML Keywords',
  'htmlKeywords_desc' => 'Enter a few keywords of the application here. It is used in the HTML header for search engines.',
  'imprint' => 'Imprint',
  'imprint_desc' => 'Check to activate the imprint in the Help menu.',
  'minimumPasswordLength' => 'Minimum Password Length',
  'minimumPasswordLength_desc' => 'The minimum number of characters a password must have (8 - 80 characters).',
  'noCaching' => 'Disable Caching',
  'noCaching_desc' => 'Disable caching for the application. This can lower performance but also lead to users always seeing the latest data in their browsers.',
  'require2fa' => 'Require Two-Factor Authentication',
  'require2fa_desc' => 'If this option is enabled, all users must use two-factor authentication. This is a security feature that requires users to provide two different authentication factors to verify themselves.',
  'robots' => 'Allow Search Engine Robots',
  'robots_desc' => 'Here you can set whether search engines are allowed to index the page.',
  'timezone' => 'Time Zone',
  'timezone_desc' => 'Select the time zone for the application.',
  'title' => 'System Settings',
  'underMaintenance' => 'Under Maintenance',
  'underMaintenance_desc' => 'If this option is enabled, the application is in maintenance mode. Only administrators can log in. All other users will see a maintenance message.',
  'underMaintenance_warning' => 'The application is still in maintenance mode. Don\'t forget to deactivate it when the maintenance activities are completed.',
  'update_success' => 'The application settings have been updated successfully.',
  'versionCheck' => 'Version Check',
  'versionCheck_desc' => 'Check for new versions of the application. If a new version is available, it will be shown on the About page. For this feature to work, the server must have access to the Internet.',
  'welcomeText' => 'Welcome Text',
  'welcomeText_desc' => 'Enter a text for the welcome message on the Home Page.',

];
