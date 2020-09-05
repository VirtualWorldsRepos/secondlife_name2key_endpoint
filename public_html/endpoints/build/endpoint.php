<?php
if(defined("entrypoint") == true)
{
    $all_ok = true;
    $need_unzip = false;
    $need_download = false;
    $need_sql_build = false;
    if($api_key == $vaild_keys[0])
    {
        if($api_request == "buildsql")
        {
            $need_sql_build = true;
            include("endpoints/build/helpers/buildsql.php");
        }
        else if($api_request == "download")
        {
            include("endpoints/build/helpers/download.php");
        }
        else if($api_request == "clearfiles")
        {
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
    }
    else
    {
        $reply = array("status" => false,"message"=>"sorry only the first api key is allowed to rebuild the dataset");
    }
}
?>
