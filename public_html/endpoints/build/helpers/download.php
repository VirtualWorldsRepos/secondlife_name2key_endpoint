<?php
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
?>
