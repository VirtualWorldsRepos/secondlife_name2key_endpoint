<?php
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$bits = array_values(array_diff(explode("/",$uri_parts[0]),array("")));
if(count($bits) > 0)
{
	if(strpos($bits[0],"php") !== false)
	{
		array_shift($bits);
	}
}
if(count($bits) >= 3)
{
	if(count($bits) >= 1) $api_name = $bits[0];
    if(count($bits) >= 2) $api_request = $bits[1];
	if(count($bits) >= 3) $api_key = $bits[2];
	if(count($bits) >= 4) $api_replytype = $bits[3];
}
else
{
	$status = false;
	$message = "api request format invaild";
}
?>
