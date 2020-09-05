<?php
if($need_sql_build == true)
{
    $subgroup = -1;

    $skip_lines = 0;
    $repeat = TRUE;
    output("There are about 1600000 entrys this will take awhile!<br/>");
    while($repeat == TRUE)
    {
        $subgroup++;
        $repeat = FALSE;
        $handle = fopen("../required/csv_dataset/tmp/name2key.csv", "r");
        if ($handle)
        {
            $counter = 0;
            $twitcher = 0;
            $clicker = 0;
            $group_data = array();
            foreach($group_options as $option)
            {
                $group_data[$option] = array(
                    "pairs" => array(),
                    "sql" => "",
                    "open" => 0,
                    "next_id" => 1,
                    "table" => "group_".$option."",
                    "addon" => "",
                );
            }
            $group_data["other"] = array(
                "sql" => "",
                "pairs" => array(),
                "open" => 0,
                "next_id" => 1,
                "table" => "group_other",
                "addon" => "",
            );
            $exit = FALSE;
            $twitch = 0;
            $linenum = 0;
            while ((($line = fgets($handle)) !== false) && ($exit == false))
            {
                set_time_limit (30);
                $linenum++;
                if($linenum >= $skip_lines)
                {
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
                        $group_data[$use_group]["pairs"][$bits[0]] = $bits[1];
                    }
                    $counter++;
                    if(($counter%5000) == 1)
                    {
                        output("<script type=\"text/javascript\">document.body.innerHTML = '';</script>");
                        output("Sorting: Working on step: ".$linenum." of about 1600000");
                        $twitch++;
                    }
                    if($twitch == 400)
                    {
                        $skip_lines = $linenum;
                        $exit = true;
                    }
                }
            }
            fclose($handle);
            output("<script type=\"text/javascript\">document.body.innerHTML = '';</script>");
            output("Sorting: Working on step: ".$linenum." of about 1600000");
            sleep(2);
            if($exit == true)
            {
                $repeat = true;
                output("<br/>Splitting load due to memory issues [Group: ".$subgroup."]");
                sleep(2);
            }
            foreach(array_keys($group_data) as $key)
            {
                set_time_limit (30);
                if(count($group_data[$key]["pairs"]) > 0)
                {
                    foreach($group_data[$key]["pairs"] as $uuid => $name)
                    {
                        if($group_data[$key]["open"] == 0)
                        {
                            $group_data[$key]["open"] = 1;
                            $group_data[$key]["sql"] .= " INSERT INTO `".$group_data[$key]["table"]."` (`id`,`uuid`, `name`) VALUES \n\r";
                        }
                        $group_data[$key]["sql"] .= $group_data[$key]["addon"];
                        $group_data[$key]["addon"] = " , \n\r";
                        $group_data[$key]["sql"] .= " (".$group_data[$key]["next_id"].",\"".$uuid."\",\"".$name."\") ";
                        $group_data[$key]["next_id"] = $group_data[$key]["next_id"] + 1;
                        if(($group_data[$key]["next_id"]%400)==0)
                        {
                            $group_data[$key]["open"] = 0;
                            $group_data[$key]["addon"] = "";
                            $group_data[$key]["sql"] .= ";\n\r";
                        }
                    }
                    if($group_data[$key]["open"] == 1)
                    {
                        $group_data[$key]["sql"] .= ";\n\r";
                    }
                    $group_data[$key]["pairs"] = array();
                    echo "Group ".$key."/".$subgroup." has ".($group_data[$key]["next_id"]-1)." entrys<br/>";
                    $file = "../required/sql_dataset/".$subgroup."_group_".$key.".sql";
                    if(file_exists($file) == true)
                    {
                        unlink($file);
                    }
                    file_put_contents($file,$group_data[$key]["sql"]);
                }
                unset($group_data[$key]);
            }
        }
        else
        {
            output("Failed to open file giving up<br/>");
        }
    }
}
else
{
    output("skipping SQL build - already have files<br/>");
}
?>
