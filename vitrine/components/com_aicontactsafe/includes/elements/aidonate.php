<?php
/**
 * @version     $Id$ 2.0.3 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class JElementAiDonate extends JElement {

	var	$_name = 'aiDonate';

	function fetchElement($name, $value, &$node, $control_name) {
		$htmlTag = '<div style="margin-left:auto; margin-right:auto; width:120px; height:90px;"><iframe src="http://www.algisinfo.com/donate/" style="width:120px; height:90px; border:0px solid #FFFFFF;"><a href="http://www.algisinfo.com/donate/" target="_blank">You can help us</a></iframe></div>';
		return $htmlTag;
	}

}

?>
