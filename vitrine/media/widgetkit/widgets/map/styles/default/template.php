<?php
/**
* @package   Widgetkit Component
* @file      template.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/
	
	$widget_id = $widget->id.'-'.uniqid();
	$settings  = $widget->settings;
	$init      = array();
	$adresses  = array();
	
	foreach ($widget->items as $item) {
		if (!count($init)) {
			$init = $item;
			$init['text'] = strlen(trim($item['popup'])) ? '<div class="wk-map-popup">'.$item['popup'].'</div>': '';
			$init['mainIcon'] = $item['icon'];
		} else {
			$adresses[] = $item;
		}
	}
	
	$width = $settings['width'] == "auto" ? "100%": $settings['width']."px";
?>
<div id="map-<?php echo $widget_id; ?>" class="wk-map wk-map-default" style="height: <?php echo $settings['height']; ?>px; width:<?php echo $width; ?>;"></div>

<script type="text/javascript">
	
	jQuery(function($) {
		
		var map      = $("#map-<?php echo $widget_id; ?>"),
			options  = <?php echo json_encode(array_merge($init, $settings, array("adresses"=>$adresses))); ?>;

		map.googlemaps(options);
	});

</script>