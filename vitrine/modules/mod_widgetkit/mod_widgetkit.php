<?php
/**
* @package   Widgetkit Component
* @file      mod_widgetkit.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// load widgetkit
require_once(JPATH_ADMINISTRATOR.'/components/com_widgetkit/widgetkit.php');

// render widget
if ($widget_id = (int) $params->get('widget_id', '')) {

	// get widgetkit
	$widgetkit = Widgetkit::getInstance();

	// render output
	$output = $widgetkit['widget']->render($widget_id);
	echo ($output === false) ? "Could not load widget with the id $widget_id." : $output;

}