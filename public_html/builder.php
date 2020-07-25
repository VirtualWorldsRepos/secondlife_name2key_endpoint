<?php
set_time_limit (10);
ob_start();
if(getenv('DB_HOST') == FALSE)
{
    echo "Warming up the magic now<br/>";
    define("magic","yes");
    define("entrypoint","yes");
    $api_name = "build";
    $api_request = "full";
    $api_key = "magic";
    $vaild_keys = array("magic");
    include("framework/core.php");
    include("endpoints/build/endpoint.php");
}
else
{
    echo "Builder magic is only to be used outside of docker!";
}
ob_end_flush();
?>
