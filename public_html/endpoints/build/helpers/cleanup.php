<?php
output("emptying db<br/>");
output(print_r($sql->RawSQL("framework/db_layout/installdb.sql"),true));
output("<br/>");
output("cleaning up<br/>");
?>
