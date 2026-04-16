<?php if (!defined('DATATABLES')) exit(); // Ensure being used in DataTables env.

// FIX: Matikan error reporting agar warning Deprecated PHP 8.2 tidak merusak JSON
error_reporting(0);
ini_set('display_errors', '0');


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Database user / pass
 */
$sql_details = array(
    "type" => "Mysql",     // Database type: "Mysql", "Postgres", "Sqlserver", "Sqlite" or "Oracle"
    "user" => "root",          // Database user name
    "pass" => "",          // Database password
    "host" => "localhost", // Database host
    "port" => "3306",          // Database connection port (can be left empty for default)
    "db"   => "skripsi",          // Database name
    "dsn"  => "",          // PHP DSN extra information. Set as `charset=utf8mb4` if you are using MySQL
    "pdoAttr" => array()   // PHP PDO attributes array. See the PHP documentation for all options
);


// This is included for the development and deploy environment used on the DataTables
// server. You can delete this block - it just includes my own user/pass without making 
// them public!
if ( is_file($_SERVER['DOCUMENT_ROOT']."/datatables/pdo.php") ) {
    include( $_SERVER['DOCUMENT_ROOT']."/datatables/pdo.php" );
}
// /End development include