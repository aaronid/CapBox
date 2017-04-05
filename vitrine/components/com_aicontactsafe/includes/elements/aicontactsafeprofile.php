<?php
/**
 * @version     $Id$ 2.0.1 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class JElementAiContactSafeProfile extends JElement {

	var	$_name = 'aiContactSafeProfile';

	function fetchElement($name, $value, &$node, $control_name) {
		$db = &JFactory::getDBO();

		$class		= $node->attributes('class');
		if (!$class) {
			$class = "inputbox";
		}

		$query = 'SELECT name, id from `#__aicontactsafe_profiles` WHERE published = 1';
		$db->setQuery($query);
		$profiles = $db->loadObjectList();

		return JHTML::_('select.genericlist',  $profiles, ''.$control_name.'['.$name.']', 'class="'.$class.'"', 'id', 'name', $value, $control_name.$name );
	}

}

?>
