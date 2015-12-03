<?php
/*
	status -> new status case
	caso -> caso id
*/
$fp = fopen('callback.txt', 'a');
fputs($fp, json_encode($_POST)."\n");
fclose($fp);
