<?php
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
    output('<br/><a href="build/import/'.$api_key.'?page=0" target="_blank">Group 0</a><br/>');
    output('<a href="build/import/'.$api_key.'?page=1" target="_blank">Group 1</a><br/>');
    output('<a href="build/import/'.$api_key.'?page=2" target="_blank">Group 2</a><br/>');
    output('<a href="build/import/'.$api_key.'?page=3" target="_blank">Group 3</a><br/>');
    output('<a href="build/import/'.$api_key.'?page=4" target="_blank">Group 4</a><br/>');
    output('<a href="build/import/'.$api_key.'?page=4" target="_blank">Group 5</a><br/>');
    $reply = array("status"=>true,"message"=>'<br/>Please import final dataset one by one!');
}
else
{
    $reply = array("status"=>false,"message"=>"please do not call this file directly!");
}
?>
