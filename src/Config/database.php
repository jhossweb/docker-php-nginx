<?php
/* database.php */

define("DB_HOST", $_ENV["PG_HOST"]);
define("DB_USER", $_ENV["PG_USER"]);
define("DB_PASS", $_ENV["PG_PASS"]);
define("DB_DBNAME", $_ENV["PG_DBNAME"]);
define('DB_PORT', $_ENV['PG_PORT']);