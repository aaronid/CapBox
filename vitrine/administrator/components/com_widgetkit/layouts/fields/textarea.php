<?php
/**
* @package   Widgetkit Component
* @file      textarea.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// set attributes
$attributes = array();
$attributes['name']  = $name;
$attributes['class'] = isset($node->attributes()->class) ? (string)$node->attributes()->class : '';

printf('<textarea %s>%s</textarea>', $this['field']->attributes($attributes, array('label', 'description', 'default')), $value);