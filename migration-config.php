<?php
$config = parse_ini_file("app/config/config.ini", true);
return [
    'name' => 'Adserver',
    'migrations_namespace' => 'Migrations',
    'table_name' => 'migrations',
    'migrations_directory' => 'migrations'
];
