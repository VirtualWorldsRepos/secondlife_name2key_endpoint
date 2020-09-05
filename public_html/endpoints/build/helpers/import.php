<?php
set_time_limit (240);
ini_set('memory_limit', '8095M');
if(isset($_GET["page"]) == true)
{
    $page = $_GET["page"];
    if(($page >= 0) && ($page <= 5))
    {
        output("importing dataset ".($page+1)." of 6<br/>");
        $group_options[] = "other";
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
        }
        sleep(1);
        output("<script type=\"text/javascript\">document.body.innerHTML = '';</script>");
    }
}
?>
