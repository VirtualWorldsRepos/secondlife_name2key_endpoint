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
ini_set('memory_limit', '8095M');
if(defined("entrypoint") == true)
{
    include("endpoints/build/helpers/cleanup.php");
    include("endpoints/build/helpers/download.php");
    include("endpoints/build/helpers/buildsql.php");
    $reply = array("status"=>true,"message"=>'all done please now<br/>
    import the data by clicking on each of these links<br/>
    one by one after they say Done<br/>
    <a href="build/import/'.$api_key.'?page=0" target="_blank">Group 0</a><br/>
    <a href="build/import/'.$api_key.'?page=1" target="_blank">Group 1</a><br/>
    <a href="build/import/'.$api_key.'?page=2" target="_blank">Group 2</a><br/>
    <a href="build/import/'.$api_key.'?page=3" target="_blank">Group 3</a><br/>
    <a href="build/import/'.$api_key.'?page=4" target="_blank">Group 4</a><br/>
    <a href="build/import/'.$api_key.'?page=5" target="_blank">Group 5</a><br/>
    ');
}
else
{
    $reply = array("status"=>false,"message"=>"please do not call this file directly!");
}
?>
