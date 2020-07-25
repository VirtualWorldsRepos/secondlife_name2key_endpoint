<?php
if(defined("entrypoint") == true)
{
    // $api_request   "Madpeter Zond"
    $groupa = array("a","s","c","b","g","n","q","v","y");
    $groupb = array("m","k","j","d","h","o","t","w","z");
    $groupc = array("e","l","r","f","i","p","u","x");

    if(strlen($api_request) >= 3)
    {
        $api_request = str_replace("%20"," ",$api_request);
        $bits = explode(" ",$api_request);
        $warn_no_lastname = "";
        if(count($bits) == 1)
        {
            $warn_no_lastname = " No last name sent using Resident";
            $api_request .= " Resident";
        }
        $firstbit = strtolower($api_request[0]);
        $objset = new groupother_set();
        if(in_array($firstbit,$groupa) == true)
        {
            $objset = new group1_set();
        }
        else if(in_array($firstbit,$groupb) == true)
        {
            $obj = new group2_set();
        }
        else if(in_array($firstbit,$groupc) == true)
        {
            $obj = new group3_set();
        }
        $whereconfig = array(
                "fields" => array("name"),
                "values" => array($api_request),
                "matches" => array("% LIKE %"),
                "types" => array("s")
        );
        $obj->load_with_config($whereconfig);
        if($obj->get_count() > 0)
        {
            if($obj->get_count() == 1)
            {
                $entry = $obj->get_first();
                $reply = array(
                    "status"=>true,
                    "found"=>true,
                    "name"=>$entry->get_name(),
                    "uuid"=>$entry->get_uuid(),
                    "lookingfor"=>$api_request,
                    "message"=>"Entry found". $warn_no_lastname
                );
            }
            else
            {
                $reply = array(
                    "status"=>true,
                    "found"=>false,
                    "name"=>"",
                    "uuid"=>"",
                    "lookingfor"=>$api_request,
                    "message"=>"Multiple results found please try again with MORE DETAIL". $warn_no_lastname
                );
            }
        }
        else
        {
            $reply = array(
                "status"=>true,
                "found"=>false,
                "name"=>"",
                "uuid"=>"",
                "lookingfor"=>$api_request,
                "message"=>"No results found!". $warn_no_lastname
            );
        }
    }
    else
    {
        $reply = array(
            "status"=>true,
            "found"=>false,
            "name"=>"",
            "uuid"=>"",
            "lookingfor"=>"",
            "message"=>"api requires you have most of a vaild name"
        );
    }
}
?>
