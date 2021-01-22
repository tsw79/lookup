<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/29/2019
 * Time: 16:43
 */
return [
  "dirs" => [
    ROOT_DIR,
    VENDOR_DIR,
  ],
  "namespaces" => [
    "lookup"           => "src",
    "phpchassis\mvc"   => "phpchassis\mvc\src",
    "phpchassis\lib"   => "phpchassis\lib\src",
    "Psr\SimpleCache"  => "psr\simple-cache\src",
    "Psr\Log"		   => "psr\log\Psr\Log",
    "Psr\Http\Message" => "psr\http-message\src",
    "Psr\Container"	   => "psr\container\src"
  ]
];