<?php

if(file_exists("../required/csv_dataset/tmp/name2key.csv") == true)
{
    unlink("../required/csv_dataset/tmp/name2key.csv");
}
if(file_exists("../required/csv_dataset/name2key.csv.zip") == true)
{
    unlink("../required/csv_dataset/name2key.csv.zip");
}
?>
