<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/16/2019
 * Time: 13:13
 */
return [
  'dev' => [
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'dbname'   => 'lookup',
    'user'     => 'lookup-usr',
    'password' => 'lookup123',
    'errmode'  => \PDO::ERRMODE_EXCEPTION,
    "dsn"      => "mysql:host=localhost;dbname=lookup;charset=utf8",
  ],
  'test' => [],
  'prod' => []
];