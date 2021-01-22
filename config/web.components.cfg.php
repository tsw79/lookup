<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/16/2019
 * Time: 11:36
 */
return [
  // Request
  'request' => [
    // Insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => 'wjJOOP9hqMW7Ny38QlcyMuVXF7OVyygt',
  ],
  // Formatter
  'formatter' => [
    'dateFormat'        => 'dd.MM.yyyy',
    'decimalSeparator'  => '.',
    'thousandSeparator' => ',',
    'currencyCode'      => 'USD',
  ],
  // Redis
  'redis' => [
    'class'     => 'yii\redis\Connection',
    'hostname'  => 'localhost',
    'port'      => 6379,
    'database'  => 0,
  ],
  // Cache
  'cache' => [
    //'class' => 'yii\redis\Cache',
    'class' => 'yii\caching\FileCache',
  ],
  // Session
  'session' => [
    'class' => 'yii\redis\Session',
    'class' => 'app\common\web\Session'
  ],
  // Error Handler
  'errorHandler' => [
    'errorAction' => 'site/error',
  ],
];