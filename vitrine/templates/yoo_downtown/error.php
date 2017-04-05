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

// set messages
$title   = $this->title;
$error   = $this->error->code;
$message = $this->error->message;

// set 404 messages
if ($error == '404') {
	$title   = JText::_('404 PAGE TITLE');
	$message = JText::sprintf('404 PAGE MESSAGE', $warp['system']->url, $warp['config']->get('site_name'));
}

// render error layout
echo $warp['template']->render('error', compact('title', 'error', 'message'));