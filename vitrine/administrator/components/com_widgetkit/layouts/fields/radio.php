<?php
/**
* @package   Widgetkit Component
* @file      radio.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

foreach ($node->children() as $option) {

	// set attributes
	$attributes = array('type' => 'radio', 'name' => $name, 'value' => $option->attributes()->value);
	
	// is checked ?
	if ($option->attributes()->value == $value) {
		$attributes = array_merge($attributes, array('checked' => 'checked'));
	}
	
	printf('<input %s /> %s ', $this['field']->attributes($attributes), (string)$option);
}