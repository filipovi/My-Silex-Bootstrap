<?php
/*
 * This file is part of the BaseSilex Application
 *
 * (c) Pascal Filipovicz <pascal.filipovicz@frozenk.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
define('__CACHE__', false);
define('__LOG__', false);
define('__DBNAME__', 'dbname');

require_once __DIR__.'/../src/bootstrap.php';
$app = require __SRC__.'/app.php';

$app['debug'] = true;

$app->run();
