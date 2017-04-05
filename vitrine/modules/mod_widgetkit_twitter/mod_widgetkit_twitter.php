<?php
/**
* @package   Widgetkit Component
* @file      mod_widgetkit_twitter.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// load widgetkit
require_once(JPATH_ADMINISTRATOR.'/components/com_widgetkit/widgetkit.php');

// get widgetkit
$widgetkit = Widgetkit::getInstance();

// render twitter tweets
echo $widgetkit['twitter']->render($params->toArray());