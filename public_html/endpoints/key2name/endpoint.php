<?php
if(defined("entrypoint") == true)
{
    if(strlen($api_request) == 36)
    {
        $testing_with = array("group1","group2","group3","groupother");
        $found = false;
        $found_obj = null;
        foreach($testing_with as $classname)
        {
            $obj = new $$classname();
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
