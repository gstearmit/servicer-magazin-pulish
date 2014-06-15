<?php
return array(
   'db' => array(
      'username' => 'service3_public',
      'password' => '7rB8a982',
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
          'user'     => 'service3_public',
          'password' => '7rB8a982',
          'dbname'   => 'service3_magazine'
        )
      )
    )
  ),
);