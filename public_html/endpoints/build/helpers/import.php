<?php
set_time_limit (240);
ini_set('memory_limit', '8095M');
if(isset($_GET["page"]) == true)
{
    $page = $_GET["page"];
    $all_ok = true;
    if(($page >= 0) && ($page <= 5))
    {
        output("importing dataset ".($page+1)." of 6<br/>");
        $group_options[] = "other";
        $counter = 0;
        foreach($group_options as $option)
        {
            set_time_limit (480);
            $import_file = "../required/sql_dataset/".$page."_group_".$option.".sql";
            if(file_exists($import_file) == true)
            {
                output("group ".$option."/".$subgroups." -");
                output(print_r($sql->RawSQL($import_file),true));
                output(" DONE <br/>");
            }
            $counter++;
            if($counter==3)
            {
                $counter = 0;
                output("<br/>Saving now please wait");
                if($sql->sqlSave() == false)
                {
                    $all_ok = false;
                }
            }
        }
        sleep(1);
        output("<br/>Saving now please wait");
    }
}
?>
