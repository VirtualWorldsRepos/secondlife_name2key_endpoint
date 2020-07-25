<?php
set_time_limit (10);
ob_start();
$api_replytype = "json";
$reply = array("status" => false,"message"=>"Not processed");
if(getenv('DB_HOST') != FALSE)
{
    define("entrypoint","yes");
    // Supported:
    // name / request / key / [reply_format ~ optional supports json,csv anything else will be taken as print_r]

    // build
        // full
    // name2key
        // avatar name
    // key2name
        /// avatar uuid

    if(getenv('API_KEYS') != FALSE)
    {
        $vaild_keys = explode(",",getenv('API_KEYS'));
        if($vaild_keys[0] != "setup")
        {
            $api_name = "none";
            $api_request = "";
            $api_key = "";

            include("framework/core.php");

            if(in_array($api_key,$vaild_keys) == true)
            {
                $known_api = array("build","name2key","key2name");
                if(in_array($api_name,$known_api) == true)
                {
                    include("endpoints/".$api_name."/endpoint.php");
                }
                else
                {
                    $reply = array("status" => false,"message"=>"Unknown api");
                }
            }
            else
            {
                $reply = array("status" => false,"message"=>"bad request");
            }
        }
        else
        {
            $reply = array("status" => false,"message"=>"in setup mode");
        }
    }
    else
    {
        $reply = array("status" => false,"message"=>"no api keys setup");
    }
}
else
{
    $reply = array("status" => false,"message"=>"Not running in docker");
}

if($api_replytype == "json")
{
    echo json_encode($reply);
}
else if($api_replytype == "csv")
{
    $addon = "";
    foreach($reply as $key => $value)
    {
        echo $addon;
        echo $key;
        echo ",";
        echo $value;
        $addon = ",";
    }
}
else
{
    print_r($reply);
}
ob_end_flush();
?>
