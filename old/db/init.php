<?php

// Include ezSQL core
include_once "ez_sql_core.php";

// Include ezSQL database specific component
include_once "ez_sql_pdo.php";

// Include local configuration
include_once "local-config.php";

// Initialise database object and establish a connection at the same time
// db_user / db_password / db_name / db_host
// If you need to specify a custom port, use notation: 'mysql:host=127.0.0.1;port=9999;dbname=some_db'
$db = new ezSQL_pdo('mysql:host='. DB_HOST .';dbname='. DB_NAME .'', DB_USER, DB_PASSWORD);

?>