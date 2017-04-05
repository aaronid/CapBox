<?php
	function startsWith($haystack, $needle)
	{
		return strncmp($haystack, $needle, strlen($needle)) === 0;
	}
	
	function endsWith($haystack, $needle)
	{
		return $needle === '' || substr_compare($haystack, $needle, -strlen($needle)) === 0;
	}

?>