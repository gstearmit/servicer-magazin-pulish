<?php
return array(
   'db' => array(
      'username' => 'admin',
      'password' => '123456a@',
   ),
);

return array(
  'doctrine' => array(
    'connection' => array(
      'orm_default' => array(
        'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
        'params' => array(
          'host'     => '192.168.0.24',
          'port'     => '3306',
          'user'     => 'admin',
          'password' => '123456a@',
          'dbname'   => 'magazineservicer'
        )
      )
    )
  ),
);