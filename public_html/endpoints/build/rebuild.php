<?php
$group_options = array("a","b","c","d","e","f","g","h","i","j","k",
"l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
"1","2","3","4","5","6","7","8","9","0","other");
foreach($group_options as $entry)
{
    $file = "../required/sql_dataset/group_".$entry.".sql";
    if(file_exists($file) == true)
    {
        unlink($file);
    }
}
if(file_exists("../required/csv_dataset/tmp/name2key.csv") == false)
{
    unlink("../required/csv_dataset/tmp/name2key.csv");
}
if(file_exists("../required/csv_dataset/name2key.csv.zip") == false)
{
    unlink("../required/csv_dataset/name2key.csv.zip");
}
include("endpoints/build/full.php");
?>
