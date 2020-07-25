<?php
define("require_id_on_load",true);
$db_objects_load_path = "framework/db_objects/";
require_once("framework/db_objects/loader.php"); // db_objects
$framework_loading = array("url_loading","autoloader");
foreach($framework_loading as $framework) { require_once("framework/".$framework.".php"); }

if(defined("magic") == true)
{
    class db extends error_logging
    {
        protected $dbHost = "localhost";
        protected $dbName = "name2keydb";
        protected $dbUser = "root";
        protected $dbPass = "";
    }
}
else if(getenv('DB_HOST') != FALSE)
{
    class db extends error_logging
    {
        protected $dbHost = "loading";
        protected $dbName = "loading";
        protected $dbUser = "loading";
        protected $dbPass = "loading";
        function __construct() {
            $this->dbHost = getenv('DB_HOST');
            $this->dbName = getenv('DB_DATABASE');
            $this->dbUser = getenv('DB_USERNAME');
            $this->dbPass = getenv('DB_PASSWORD');
        }
    }
}
else
{
    die("Setup error");
}
require_once("framework/mysqli/loader.php"); // sql_driver
$sql = new mysqli_controler();
?>
