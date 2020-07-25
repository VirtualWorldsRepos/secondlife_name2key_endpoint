<?php
function output($str) {
    echo $str;
    ob_end_flush();
    ob_flush();
    flush();
    ob_start();
}
$group_options = array("a","b","c","d","e","f","g","h","i","j","k",
"l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
"1","2","3","4","5","6","7","8","9","0");
set_time_limit (240);
ini_set('memory_limit', '4095M');
if(defined("entrypoint") == true)
{
    output("emptying db<br/>");
    output(print_r($sql->RawSQL("framework/db_layout/installdb.sql"),true));
    output("<br/>");
    output("cleaning up<br/>");
    $all_ok = true;

    $need_unzip = false;
    $need_download = false;
    $need_sql_build = false;
    if(file_exists("../required/sql_dataset/group_a.sql") == false)
    {
        $need_sql_build = true;
        if(file_exists("../required/csv_dataset/tmp/name2key.csv") == false)
        {
            $need_unzip = true;
            if(file_exists("../required/csv_dataset/name2key.csv.zip") == false)
            {
                $need_download = true;
            }
            else
            {
                output("Skipping download have the zip already<br/>");
            }
        }
        else
        {
            output("Skipping unzip already have the file<br/>");
        }
    }
    else
    {

        output("Hardwork done just need to import<br/>");
    }

    if($need_download == true)
    {
        output("downloading name2key csv<br/>");
        file_put_contents("../required/csv_dataset/name2key.csv.zip", fopen("http://w-hat.com/name2key.csv.zip","r"));
    }
    if($need_unzip == true)
    {
        output("unpacking<br/>");
        $zip = new ZipArchive;
        $res = $zip->open("../required/csv_dataset/name2key.csv.zip");
        $zip->extractTo("../required/csv_dataset");
        $zip->close();
    }

    if($need_sql_build == true)
    {
        $handle = fopen("../required/csv_dataset/tmp/name2key.csv", "r");
        if ($handle)
        {
            $counter = 0;
            $twitcher = 0;
            $clicker = 0;
            output("There are about 1600000 entrys this will take awhile!<br/>");

            $group_data = array();

            foreach($group_options as $option)
            {
                $group_data[$option] = array(
                    "sql" => "",
                    "open" => 0,
                    "next_id" => 1,
                    "table" => "group_".$option."",
                    "addon" => "",
                );
            }
            $group_data["other"] = array(
                "sql" => "",
                "open" => 0,
                "next_id" => 1,
                "table" => "group_other",
                "addon" => "",
            );

            while (($line = fgets($handle)) !== false)
            {
                set_time_limit (30);
                //00000000-0000-0000-0000-000000000001,Fake01 Resident
                $line = trim($line);
                $bits = explode(",",$line);
                if(count($bits) == 2)
                {
                    $firstbit = strtolower(($bits[1])[0]);
                    $use_group = "other";
                    if(in_array($firstbit,$group_options) == true)
                    {
                        $use_group = $firstbit;
                    }
                    if($group_data[$use_group]["open"] == 0)
                    {
                        $group_data[$use_group]["open"] = 1;
                        $group_data[$use_group]["sql"] .= " INSERT INTO `".$group_data[$use_group]["table"]."` (`id`,`uuid`, `name`) VALUES \n\r";
                    }
                    $group_data[$use_group]["sql"] .= $group_data[$use_group]["addon"];
                    $group_data[$use_group]["addon"] = " , \n\r";
                    $group_data[$use_group]["sql"] .= " (".$group_data[$use_group]["next_id"].",\"".$bits[0]."\",\"".$bits[1]."\") ";
                    $group_data[$use_group]["next_id"] = $group_data[$use_group]["next_id"] + 1;
                    if(($group_data[$use_group]["next_id"]%400)==0)
                    {
                        $group_data[$use_group]["open"] = 0;
                        $group_data[$use_group]["addon"] = "";
                        $group_data[$use_group]["sql"] .= ";\n\r";
                    }
                }
                $counter++;
                if(($counter%1000) == 1)
                {
                    output("<script type=\"text/javascript\">document.body.innerHTML = '';</script>");
                    output("Working on step: ".$counter." of about 1600000");
                }
            }
            sleep(6);
            output("<script type=\"text/javascript\">document.body.innerHTML = '';</script>");
            fclose($handle);
            output("<br/>Building SQL files<br/>Report:<br/>");
            foreach(array_keys($group_data) as $key)
            {
                if($group_data[$key]["open"] == 1)
                {
                    $group_data[$key]["sql"] .= ";\n\r";
                }
                echo "Group ".$key." has ".($group_data[$key]["next_id"]-1)." entrys<br/>";
                $file = "../required/sql_dataset/group_".$key.".sql";
                if(file_exists($file) == true)
                {
                    unlink($file);
                }
                file_put_contents($file,$group_data[$key]["sql"]);
                unset($group_data[$key]);
            }
        }
        else
        {
            output("skipping SQL build - already have files<br/>");
        }
    }
    output("importing datasets<br/>");
    $group_options[] = "other";
    foreach($group_options as $option)
    {
        set_time_limit (480);
        output("group ".$option." -");
        output(print_r($sql->RawSQL("../required/sql_dataset/group_".$option.".sql"),true));
        output(" DONE <br/>");
    }
    output(print_r($sql->sqlSave(),true));
    $reply = array("status"=>true,"message"=>"all done");
}
else
{
    $reply = array("status"=>false,"message"=>"please do not call this file directly!");
}
?>
