<?php

require_once __DIR__ . '/vendor/autoload.php';

$config = new Zilla\Config\ConfigService([], new Zilla\Config\PHPStore(__DIR__));

var_dump($config->get('foo.bar'));

var_dump($config->get('config.some.bar'));
