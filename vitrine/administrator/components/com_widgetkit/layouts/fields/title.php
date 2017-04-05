<?php
/**
* @package   Widgetkit Component
* @file      title.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// set attributes
$attributes = array();
$attributes['type']  = 'text';
$attributes['name']  = $name;
$attributes['value'] = $value;
$attributes['class'] = 'title widefat '.(isset($class) ? $class : '');

printf('<input %s />', $this['field']->attributes($attributes, array('label', 'description', 'default')));

?>

<script type="text/javascript">

jQuery(function($){
	
	$('input.title').die('keyup.title').live('keyup.title', function() {
		$(this).trigger('update');
	});

});

</script>