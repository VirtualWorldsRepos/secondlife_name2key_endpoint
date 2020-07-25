<?php
if(defined("entrypoint") == true)
{
    // $api_request   "Madpeter Zond|UUID"
    $group_options = array("a","b","c","d","e","f","g","h","i","j","k",
    "l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
    "1","2","3","4","5","6","7","8","9","0");
    $bits = explode("|",$api_request);
    if(count($bits) == 2)
    {
        $uuid = $bits[1];
        $api_request = $bits[0];
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
            $use_object_class = "group_other_set";
            if(in_array($firstbit,$group_options) == true)
            {
                $use_object_class = "group_".$firstbit."_set";
            }
            $obj = new $use_object_class();

            $whereconfig = array(
                    "fields" => array("name"),
                    "values" => array($api_request),
                    "matches" => array("LIKE %"),
                    "types" => array("s")
            );
            $obj->load_with_config($whereconfig);
            if($obj->get_count() == 0)
            {
                $use_object_class = "group_".$firstbit."";
                $obj = new $use_object_class();
                $obj->set_field("uuid",$uuid);
                $obj->set_field("name",$api_request);
                $status = $obj->create_entry();
                if($status["status"] == true)
                {
                    $reply = array(
                        "status"=>true,
                        "message"=>"Entry created"
                    );
                }
                else
                {
                    $reply = array(
                        "status"=>false,
                        "message"=>"Unable to add entry"
                    );
                }
            }
            else
            {
                $reply = array(
                    "status"=>true,
                    "message"=>"Already in database"
                );
            }
        }
        else
        {
            $reply = array(
                "status"=>false,
                "message"=>"api requires you have most of a vaild name"
            );
        }
    }
    else
    {
        $reply = array(
            "status"=>false,
            "message"=>"Expected \"Name Lastname|UUID\""
        );
    }
}
?>
