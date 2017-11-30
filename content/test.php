<?php
	function logToFile($filename, $msg)
	{
		// open file
		$fd = fopen($filename, "a");
		// append date/time to message
		$str = "[" . date("Y/m/d h:i:s", time()) . "] " . $msg;
		// write string
		fwrite($fd, $str . "\n");
		// close file
		fclose($fd);
	}
	
	if ($_POST) {
		logToFile('post.txt', var_export($_POST, true));
	} elseif ($_GET) { 
		logToFile('get.txt', var_export($_GET, true));
	} else {
		logToFile('error.txt', 'abc');
	}