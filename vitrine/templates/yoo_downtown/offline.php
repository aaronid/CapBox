<?php
/**
* @package   yoo_downtown
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// include config	
include_once(dirname(__FILE__).'/config.php');

// get warp
$warp = Warp::getInstance();

// render offline layout
echo $warp['template']->render('offline', array('title' => JText::_('OFFLINE PAGE TITLE'), 'error' => 'Offline', 'message' => JText::_('OFFLINE PAGE MESSAGE')));