<?php
if(defined("entrypoint") == true)
{
    // $api_request   "Madpeter Zond"
    $group_options = array("a","b","c","d","e","f","g","h","i","j","k",
    "l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
    "1","2","3","4","5","6","7","8","9","0");
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
        $use_object_class = "group_other";
        if(in_array($firstbit,$group_options) == true)
        {
            $use_object_class = "group_".$firstbit."";
        }
        $obj = new $$use_object_class();

        $whereconfig = array(
                "fields" => array("name"),
                "values" => array($api_request),
                "matches" => array("LIKE %"),
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
