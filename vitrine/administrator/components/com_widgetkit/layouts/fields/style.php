<?php
/**
* @package   Widgetkit Component
* @file      style.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

printf('<select %s>', $this['field']->attributes(compact('name')));

foreach ($this['path']->dirs((string) $node->attributes()->path) as $option) {

	// set attributes
	$attributes = array('value' => $option);
	
	// is checked ?
	if ($option == $value) {
		$attributes = array_merge($attributes, array('selected' => 'selected'));
	}

	printf('<option %s>%s</option>', $this['field']->attributes($attributes), $option);
}

printf('</select>');