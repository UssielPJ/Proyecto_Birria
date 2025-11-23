<?php

return [
  'db' => [
    'host'    => 'trolley.proxy.rlwy.net',   
    'port'    => 40949,
    'name'    => 'railway', 
    'user'    => 'root',        
    'pass'    => 'eKPhmDSkAzlaeBcuDgdNErBZNlOdzXWt',            
    'charset' => 'utf8mb4',
  ],
  'app' => [
    'debug' => true, 
    'allowed_origins' => [
      'http://localhost',
      'http://localhost/Proyecto_Birria',
      'http://127.0.0.1',
      'http://127.0.0.1/Proyecto_Birria',
    ],
  ],
    'jwt_secret' => 'F4uqAgozCh0B2SKkEa3A3UDIFxt+OExv72heTEUtGlM=',
];
