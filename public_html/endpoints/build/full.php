<?php
set_time_limit (120);
if(defined("entrypoint") == true)
{
    $sql_obj->RawSQL("../required/db_layout/installdb.sql");

    $groupa = array("a","s","c","b","g","n","q","v","y");
    $groupb = array("m","k","j","d","h","o","t","w","z");
    $groupc = array("e","l","r","f","i","p","u","x");
    if(file_exists("../required/csv_dataset/name2key.csv") == true)
    {
        unlink("../required/csv_dataset/name2key.csv");
    }
    if(file_exists("../required/csv_dataset/name2key.csv.zip") == true)
    {
        unlink("../required/csv_dataset/name2key.csv.zip");
    }
    file_put_contents("../required/csv_dataset/name2key.csv.zip", fopen("http://w-hat.com/name2key.csv.zip","r"));
    if(file_exists("../required/csv_dataset/name2key.csv.zip") == true)
    {
        $zip = new ZipArchive;
        $res = $zip->open("../required/csv_dataset/name2key.csv.zip");
        $zip->extractTo("../required/csv_dataset");
        $zip->close();
        $handle = fopen("../required/csv_dataset/name2key.csv", "r");
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
            $reply = array("status"=>true,"message"=>"local CSV file missing");
        }
    }
    else
    {
        $reply = array("status"=>true,"message"=>"local zip file missing");
    }
}
else
{
    $reply = array("status"=>false,"message"=>"please do not call this file directly!");
}
?>
