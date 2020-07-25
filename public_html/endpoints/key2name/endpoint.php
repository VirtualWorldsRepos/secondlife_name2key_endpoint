<?php
if(defined("entrypoint") == true)
{
    if(strlen($api_request) == 36)
    {
        $group_options = array("a","s","m","c","d","l","j","b","k","t","r","p","e","n","g","f","h","v","i","w",
        "o","z","x","y","u","q","1","0","2","3","4","6","7","5","8","9","other");
        $found = false;
        $found_obj = null;
        foreach($group_options as $classname)
        {
            $class_name = "group_".$classname."";
            $obj = new $class_name();
            if($obj->load_by_field("uuid",$api_request) == true)
            {
                $found = true;
                $found_obj = $obj;
                break;
            }
        }
        if($found != false)
        {
            $reply = array(
                "status"=>true,
                "found"=>true,
                "name"=>$found_obj->get_name(),
                "uuid"=>$found_obj->get_uuid(),
                "lookingfor"=>$api_request,
                "message"=>"found"
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
                "message"=>"unable to find requested key"
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
            "message"=>"api requires you have a vaild UUID"
        );
    }
}
?>
