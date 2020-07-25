<?php
if(defined("entrypoint") == true)
{
    if($api_key == $vaild_keys[0])
    {
        set_time_limit (240);
        ini_set('memory_limit', '4095M');
        ob_end_flush();
        $file_url = "../required/csv_dataset/".$api_request.".sql";
        header('Content-Type: text/plain');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url);
        die();
    }
    else
    {
        $reply = array("status" => false,"message"=>"sorry only the first api key is allowed to view required level files!");
    }
}
?>
