<?php
$subgroups = 0;
while($subgroups <= 1000)
{
    output("importing datasets<br/>");
    $group_options[] = "other";
    foreach($group_options as $option)
    {
        set_time_limit (480);
        $import_file = "../required/sql_dataset/".$subgroups."_group_".$option.".sql";
        if(file_exists($import_file) == true)
        {
            output("group ".$option."/".$subgroups." -");
            output(print_r($sql->RawSQL($import_file),true));
            output(" DONE <br/>");
        }
    }
    sleep(1);
    output("<script type=\"text/javascript\">document.body.innerHTML = '';</script>");
    $subgroups++;
}
output(print_r($sql->sqlSave(),true));
?>
