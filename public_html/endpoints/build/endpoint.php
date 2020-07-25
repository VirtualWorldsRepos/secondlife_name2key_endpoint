<?php
if(defined("entrypoint") == true)
{
    if($api_request == "full") include("build/full.php");
    else if($api_request == "update") include("build/update.php");
    else $reply = array("status" => false,"message"=>"request not supported");
}
?>
