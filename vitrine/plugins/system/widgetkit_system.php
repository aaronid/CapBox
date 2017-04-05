<?php
/**
* @package   Widgetkit Component
* @file      widgetkit_system.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemWidgetkit_System extends JPlugin {

	public function onAfterDispatch() {

		// load widgetkit
		require_once(JPATH_ADMINISTRATOR.'/components/com_widgetkit/widgetkit.php');

	}

}