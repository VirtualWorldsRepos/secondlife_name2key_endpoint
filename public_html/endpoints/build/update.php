<?php
set_time_limit (120);
function bunzip2 ($in, $out)
{
    if (!file_exists ($in) || !is_readable ($in))
        return false;
    if ((!file_exists ($out) && !is_writeable (dirname ($out)) || (file_exists($out) && !is_writable($out)) ))
        return false;

    $in_file = bzopen ($in, "rb");
    $out_file = fopen ($out, "wb");

    while ($buffer = bzread ($in_file, 4096)) {
        fwrite ($out_file, $buffer, 4096);
    }

    bzclose ($in_file);
    fclose ($out_file);

    return true;
}
if(defined("entrypoint") == true)
{

    file_put_contents("name2key.new.csv.bz2", fopen("http://w-hat.com/name2key.new.csv.bz2", 'r'));
    if (bunzip2("name2key.new.csv.bz2","name2key.new.csv") == true)
    {
        $groupa = array("a","s","c","b","g","n","q","v","y");
        $groupb = array("m","k","j","d","h","o","t","w","z");
        $groupc = array("e","l","r","f","i","p","u","x");
        $handle = fopen("name2key.new.csv", "r");
        if ($handle)
        {
            while (($line = fgets($handle)) !== false)
            {
                //00000000-0000-0000-0000-000000000001,Fake01 Resident
                $bits = explode(",",$line);
                if(count($bits) == 2)
                {
                    $firstbit = strtolower(($bits[1])[0]);
                    $obj = new groupother();
                    if(in_array($firstbit,$groupa) == true)
                    {
                        $obj = new group1();
                    }
                    else if(in_array($firstbit,$groupb) == true)
                    {
                        $obj = new group2();
                    }
                    else if(in_array($firstbit,$groupc) == true)
                    {
                        $obj = new group3();
                    }
                    $obj->set_field("uuid",$bits[0]);
                    $obj->set_field("name",$bits[1]);
                    $obj->create_entry();
                }
            }
            fclose($handle);
            $reply = array("status"=>true,"message"=>"all done");
        }
        else
        {
            $reply = array("status"=>false,"message"=>"File missing?");
        }
    }
    else
    {
        $reply = array("status"=>false,"message"=>"Extract failed");
    }
}
else
{
    $reply = array("status"=>false,"message"=>"please do not call this file directly!");
}
?>
