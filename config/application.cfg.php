<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/16/2019
 * Time: 11:32
 */

return [
  'id'         => 'basic',
  'name'       => 'PhpChassis-MVC',
  'bootstrap'  => ['log'],
  'timeZone'   => 'Asia/Riyadh',
  'basePath'   => dirname(__DIR__ . "/.."),
  'params'     => require(__DIR__ . "/params.cfg.php"),
  'components' => require(__DIR__ . "/web.components.cfg.php"),
  'routes'     => require(__DIR__ . "/routes.cfg.php"),
  'db'         => require(__DIR__ . "/db.cfg.php"),
  'autoload'   => require(__DIR__ . "/autoload.cfg.php"),
  'aliases' => [
    '@modules'      => '@app/modules',
    '@auth-module'  => '@app/modules/authrbac',
    '@log-module'   => '@app/modules/loggerman',
    '@email-module' => '@app/modules/mailbike'
  ],
  'search.results' => [
    'sites' => [
      'limit' => [
        'page'        => 15,
        'title'       => 55,
        'description' => 230
      ]
    ],
    'images' => [
      'limit' => [
        'page' => 20
      ]
    ]
  ]
];