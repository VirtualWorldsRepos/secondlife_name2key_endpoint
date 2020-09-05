<?php
$subgroups = 0;
$group_options = array("a","b","c","d","e","f","g","h","i","j","k",
"l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
"1","2","3","4","5","6","7","8","9","0","other");
while($subgroups <= 20)
{
    foreach($group_options as $entry)
    {
        $file = "../required/sql_dataset/".$subgroups."_group_".$entry.".sql";
        if(file_exists($file) == true)
        {
            unlink($file);
        }
    }
    $subgroups++;
}
?>
