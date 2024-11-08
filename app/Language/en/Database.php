<?php

return [

  'pageTitle' => 'Database Management',

  'tab' => [
    'optimize' => 'Optimize',
    'reset' => 'Reset',
  ],

  'btn' => [
    'optimize' => 'Optimize Tables',
    'reset' => 'Reset Database',
  ],

  'optimize' => 'Optimize Database Tables',
  'optimize_desc' => 'Optimizing the database tables can improve the performance of the system. It reorganizes the physical storage
    of table data and associated index data, to reduce storage space and improve I/O efficiency when accessing the tables. This process may take some time to complete.',
  'optimize_success' => 'The database tables have been successfully optimized.',

  'resetConfirm' => 'Confirm',
  'resetConfirm_desc' => 'Resetting the database will replace all your information with the installation sample database.
    Type the following in the text box to confirm your decision: "YesIAmSure".',
  'reset_warning' => '<strong>Danger!</strong> This will reset the database with sample data. All your data will be lost.',
  'reset_success' => 'The database has been successfully reset to sample data.',

];
