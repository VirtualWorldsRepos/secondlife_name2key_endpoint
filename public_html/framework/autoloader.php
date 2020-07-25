<?php
function auto_load_model($class_name="")
{
	$try_class_file = "";
	$bits = explode("_",$class_name);
    if(count($bits) >= 2)
    {
        if($bits[count($bits)-1] != "helper")
        {
            if($bits[count($bits)-1] == "set") array_pop($bits);
            $try_class_file = implode("_",$bits).".php";
        }
    }
    else $try_class_file = $bits[0].".php";
	if($try_class_file != "")
	{
		$loadfile = "framework/model/".$try_class_file."";
		if(file_exists($loadfile))
		{
			require_once($loadfile);
		}
	}
}
spl_autoload_register('auto_load_model');
?>
