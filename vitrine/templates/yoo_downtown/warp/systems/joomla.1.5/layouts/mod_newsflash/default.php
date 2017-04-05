<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

srand((double) microtime() * 1000000);

$flashnum	= rand(0, $items -1);
$item		= $list[$flashnum];

modNewsFlashHelper::renderItem($item, $params, $access);

?>