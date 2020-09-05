<?php
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
?>
