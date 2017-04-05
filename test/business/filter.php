<?php
	function isIdGrp($var)
	{
	    return preg_match("/^(New)?\d+$/", $var);
	}

	function isNewIdGrp($var)
	{
	    return preg_match("/^New\d+$/", $var);
	}

	function isExistIdGrp($var)
	{
	    return preg_match("/^\d+$/", $var);
	}

	function isIdLine($var)
	{
	    return preg_match("/^(New)?\d+_(New)?\d+$/", $var);
	}

	function isNewIdLine($var)
	{
	    return preg_match("/^(New)?\d+_New\d+$/", $var);
	}

	function isNewIdLineWithoutGrp($var)
	{
	    return preg_match("/^New\d+$/", $var);
	}

	function isExistIdLine($var)
	{
	    return preg_match("/^\d+_\d+$/", $var);
	}

	
?>