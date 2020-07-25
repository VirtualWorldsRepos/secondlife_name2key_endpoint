<?php
define("require_id_on_load",true);
require_once("framework/db_objects/loader.php"); // db_objects
$framework_loading = array("url_loading","autoloader");
foreach($framework_loading as $framework) { require_once("framework/".$framework.".php"); }
require_once("framework/mysqli/loader.php"); // sql_driver

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

$sql = new mysqli_controler();
?>
