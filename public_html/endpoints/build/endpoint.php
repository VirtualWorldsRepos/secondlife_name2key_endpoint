<?php
function output($str) {
    echo $str;
    ob_end_flush();
    ob_flush();
    flush();
    ob_start();
}
if(defined("entrypoint") == true)
{
    $all_ok = true;
    $need_unzip = false;
    $need_download = false;
    $need_sql_build = false;
    $group_options = array("a","b","c","d","e","f","g","h","i","j","k",
    "l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
    "1","2","3","4","5","6","7","8","9","0");
    if($api_key == $vaild_keys[0])
    {
        if($api_request == "buildsql")
        {
            $need_sql_build = true;
            include("endpoints/build/helpers/clear_sql_files.php");
            include("endpoints/build/helpers/buildsql.php");
        }
        else if($api_request == "download")
        {
            include("endpoints/build/helpers/download.php");
        }
        else if($api_request == "clearfiles")
        {
            include("endpoints/build/helpers/clear_sql_files.php");
            include("endpoints/build/helpers/clear_files.php");
        }
        else if($api_request == "import")
        {
            include("endpoints/build/helpers/import.php");
        }
        else if($api_request == "rebuild")
        {
            include("endpoints/build/helpers/clear_files.php");
            include("endpoints/build/helpers/full.php");
        }
        else
        {
            $reply = array("status" => false,"message"=>"request not supported");
        }
        output(print_r($sql->sqlSave(),true));
    }
    else
    {
        $reply = array("status" => false,"message"=>"sorry only the first api key is allowed to rebuild the dataset");
    }
}
?>
