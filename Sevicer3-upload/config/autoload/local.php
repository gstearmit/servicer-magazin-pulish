<?php
return array(
   'db' => array(
      'username' => 'admin_servicer3',
      'password' => 'n2Os33MM',
   ),
);

return array(
  'doctrine' => array(
    'connection' => array(
      'orm_default' => array(
        'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
        'params' => array(
          'host'     => 'localhost',
          'port'     => '3306',
          'user'     => 'admin_servicer3',
          'password' => 'n2Os33MM',
          'dbname'   => 'admin_servicer3'
        )
      )
    )
  ),
);

