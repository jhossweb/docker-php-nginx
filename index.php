<?php
/** index.php */

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/')->load();

require_once __DIR__ . '/src/Config/database.php';

new \App\AppServer;

