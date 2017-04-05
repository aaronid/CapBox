<?php
/**
* @package   Widgetkit Component
* @file      uninstall.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// load installer
require_once(dirname(__FILE__).'/installer.php');

// run installer script
$script = new InstallerScript();
$script->uninstall($this);