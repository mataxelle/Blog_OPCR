<?php

/*define('__DBHOST', $_ENV['DB_HOST']);
define('__DBDATABASE', $_ENV['DB_DATABASE']);
define('__DBUSERNAME', $_ENV['DB_USERNAME']);
define('__DBPASSWORD', $_ENV['DB_PASSWORD']);*/

define('__DBHOST', filter_input(INPUT_ENV, "DB_HOST"));
define('__DBDATABASE', $_ENV['DB_DATABASE']);
define('__DBUSERNAME', $_ENV['DB_USERNAME']);
//define('__DBUSERNAME', filter_input(INPUT_ENV, "DB_USERNAME"));
//define('__DBPASSWORD', $_ENV['DB_PASSWORD']);
define('__DBPASSWORD', filter_input(INPUT_ENV, "DB_PASSWORD"));
