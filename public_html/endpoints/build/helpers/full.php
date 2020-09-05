<?php
function output($str) {
    echo $str;
    ob_end_flush();
    ob_flush();
    flush();
    ob_start();
}
$group_options = array("a","b","c","d","e","f","g","h","i","j","k",
"l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
"1","2","3","4","5","6","7","8","9","0");
set_time_limit (240);
ini_set('memory_limit', '4095M');
if(defined("entrypoint") == true)
{
    include("endpoints/build/helpers/cleanup.php");
    include("endpoints/build/helpers/download.php");
    include("endpoints/build/helpers/buildsql.php");
    include("endpoints/build/helpers/import.php");
    $reply = array("status"=>true,"message"=>"all done");
}
else
{
    $reply = array("status"=>false,"message"=>"please do not call this file directly!");
}
?>
