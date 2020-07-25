<?php
function output($str) {
    echo $str;
    ob_end_flush();
    ob_flush();
    flush();
    ob_start();
}
set_time_limit (240);
ini_set('memory_limit', '4095M');
if(defined("entrypoint") == true)
{
    output("emptying db<br/>");
    $sql->RawSQL("../required/db_layout/installdb.sql");

    $groupa = array("a","s","c","b","g","n","q","v","y");
    $groupb = array("m","k","j","d","h","o","t","w","z");
    $groupc = array("e","l","r","f","i","p","u","x");
    output("cleaning up<br/>");
    $all_ok = true;
    if(file_exists("../required/csv_dataset/tmp/name2key.csv") == false)
    {
        if(file_exists("../required/csv_dataset/name2key.csv.zip") == false)
        {
            output("downloading name2key csv<br/>");
            file_put_contents("../required/csv_dataset/name2key.csv.zip", fopen("http://w-hat.com/name2key.csv.zip","r"));
            if(file_exists("../required/csv_dataset/name2key.csv.zip") == true)
            {
                output("unpacking<br/>");
                $zip = new ZipArchive;
                $res = $zip->open("../required/csv_dataset/name2key.csv.zip");
                $zip->extractTo("../required/csv_dataset");
                $zip->close();
            }
            else
            {
                $all_ok = false;
                output("Unable to download<br/>");
            }
        }
        else
        {
            output("Skipping download already have local copy<br/>");
        }
    }
    else
    {
        output("Skipping unzip already have local copy<br/>");
    }

    if($all_ok == true)
    {
        $handle = fopen("../required/csv_dataset/tmp/name2key.csv", "r");
        if ($handle)
        {
            $counter = 0;
            $twitcher = 0;
            $clicker = 0;
            output("There are about 1600000 entrys this will take awhile!<br/>");

            $group1_id = 1;
            $group2_id = 1;
            $group3_id = 1;
            $groupother_id = 1;

            $group1_sql = "";
            $group2_sql = "";
            $group3_sql = "";
            $groupother_sql = "";

            $group1_open = 0;
            $group2_open = 0;
            $group3_open = 0;
            $groupother_open = 0;

            $group1_addon = "";
            $group2_addon = "";
            $group3_addon = "";
            $groupother_addon = "";

            while (($line = fgets($handle)) !== false)
            {
                set_time_limit (30);
                //00000000-0000-0000-0000-000000000001,Fake01 Resident

                $bits = explode(",",$line);
                if(count($bits) == 2)
                {
                    $firstbit = strtolower(($bits[1])[0]);
                    if(in_array($firstbit,$groupa) == true)
                    {
                        if($group1_open == 0)
                        {
                            $group1_open = 1;
                            $group1_sql .= " INSERT INTO \"group1\" (\"id\", \"uuid\", \"name\") VALUES \n\r";
                        }
                        $group1_sql .= $group1_addon;
                        $group1_sql .= " (".$group1_id.",\"".$bits[0]."\",\"".$bits[1]."\") \n\r";
                        $group1_addon = " , \n\r";
                        if(($group1_id%200)==1)
                        {
                            $group1_sql .= ";\n\r";
                            $group1_addon = "";
                            $group1_open = 0;
                        }
                        $group1_id++;
                    }
                    else if(in_array($firstbit,$groupb) == true)
                    {
                        if($group2_open == 0)
                        {
                            $group2_open = 1;
                            $group2_sql .= " INSERT INTO \"group2\" (\"id\", \"uuid\", \"name\") VALUES \n\r";
                        }
                        $group2_sql .= $group2_addon;
                        $group2_sql .= " (".$group2_id.",\"".$bits[0]."\",\"".$bits[1]."\") \n\r";
                        $group2_addon = " , \n\r";
                        if(($group2_id%200)==1)
                        {
                            $group2_sql .= ";\n\r";
                            $group2_addon = "";
                            $group2_open = 0;
                        }
                        $group2_id++;
                    }
                    else if(in_array($firstbit,$groupc) == true)
                    {
                        if($group3_open == 0)
                        {
                            $group3_open = 1;
                            $group3_sql .= " INSERT INTO \"group3\" (\"id\", \"uuid\", \"name\") VALUES \n\r";
                        }
                        $group3_sql .= $group3_addon;
                        $group3_sql .= " (".$group3_id.",\"".$bits[0]."\",\"".$bits[1]."\") \n\r";
                        $group3_addon = " , \n\r";
                        if(($group3_id%200)==1)
                        {
                            $group3_sql .= ";\n\r";
                            $group3_addon = "";
                            $group3_open = 0;
                        }
                        $group3_id++;
                    }
                    else
                    {
                        if($groupother_open == 0)
                        {
                            $groupother_open = 1;
                            $groupother_sql .= " INSERT INTO \"groupother\" (\"id\", \"uuid\", \"name\") VALUES \n\r";
                        }
                        $groupother_sql .= $groupother_addon;
                        $groupother_sql .= " (".$groupother_id.",\"".$bits[0]."\",\"".$bits[1]."\") \n\r";
                        $groupother_addon = " , \n\r";
                        if(($groupother_id%200)==1)
                        {
                            $groupother_sql .= ";\n\r";
                            $groupother_addon = "";
                            $groupother_open = 0;
                        }
                        $groupother_id++;
                    }
                }
                $counter++;
                if(($counter%1000) == 1)
                {
                    output("<script type=\"text/javascript\">document.body.innerHTML = '';</script>");
                    output("Working on step: ".$counter." of about 1600000");
                }
            }
            sleep(2);
            output("<script type=\"text/javascript\">document.body.innerHTML = '';</script>");
            if($groupother_open == 1)
            {
                $groupother_sql .= ";";
            }
            if($group1_open == 1)
            {
                $group1_sql .= ";";
            }
            if($group2_open == 1)
            {
                $group2_sql .= ";";
            }
            if($group3_open == 1)
            {
                $group3_sql .= ";";
            }
            fclose($handle);
            output("<br/>Building SQL files<br/>");
            output("<br/>Report: Group 1: ".($group1_id-1)."<br/>Group 2: ".($group2_id-1)."<br/>Group 3: ".($group3_id-1)."<br/>Group Other: ".($groupother_id-1)."<br/><hr/>");
            if(file_exists("../required/csv_dataset/group1.sql") == true)
            {
                unlink("../required/csv_dataset/group1.sql");
            }
            file_put_contents("../required/csv_dataset/group1.sql",$group1_sql);
            unset($group1_sql);
            if(file_exists("../required/csv_dataset/group2.sql") == true)
            {
                unlink("../required/csv_dataset/group2.sql");
            }
            file_put_contents("../required/csv_dataset/group2.sql",$group2_sql);
            unset($group2_sql);
            if(file_exists("../required/csv_dataset/group3.sql") == true)
            {
                unlink("../required/csv_dataset/group3.sql");
            }
            file_put_contents("../required/csv_dataset/group3.sql",$group3_sql);
            unset($group3_sql);
            if(file_exists("../required/csv_dataset/groupother.sql") == true)
            {
                unlink("../required/csv_dataset/groupother.sql");
            }
            file_put_contents("../required/csv_dataset/groupother.sql",$groupother_sql);
            unset($groupother_sql);
            output("importing datasets<br/>");
            if($group1_id > 1)
            {
                set_time_limit (480);
                output("group 1 -");
                $sql->RawSQL("../required/csv_dataset/group1.sql");
                output(" DONE <br/>");
            }
            if($group2_id > 1)
            {
                set_time_limit (480);
                output("group 2 -");
                $sql->RawSQL("../required/csv_dataset/group2.sql");
                output(" DONE <br/>");
            }
            if($group3_id > 1)
            {
                set_time_limit (480);
                output("group 3 -");
                $sql->RawSQL("../required/csv_dataset/group3.sql");
                output(" DONE <br/>");
            }
            if($groupother_id > 1)
            {
                set_time_limit (480);
                output("group others -");
                $sql->RawSQL("../required/csv_dataset/groupother.sql");
                output(" DONE <br/>");
            }
            $sql->sqlSave();
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
