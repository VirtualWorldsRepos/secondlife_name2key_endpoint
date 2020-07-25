<?php
if(defined("entrypoint") == true)
{
    if($api_request == "full") include("endpoints/build/full.php");
    else $reply = array("status" => false,"message"=>"request not supported");
}
?>
