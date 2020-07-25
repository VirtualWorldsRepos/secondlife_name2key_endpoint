<?php
if(defined("entrypoint") == true)
{
    if($api_key == $vaild_keys[0])
    {
        if($api_request == "full")
        {
            include("endpoints/build/full.php");
        }
        else if($api_request == "rebuild")
        {
            include("endpoints/build/rebuild.php");
        }
        else
        {
            $reply = array("status" => false,"message"=>"request not supported");
        }
    }
    else
    {
        $reply = array("status" => false,"message"=>"sorry only the first api key is allowed to rebuild the dataset");
    }
}
?>
