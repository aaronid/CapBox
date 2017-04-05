<?php
/**
* @package   Widgetkit Component
* @file      location.php
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
$attributes['class'] = 'location '.(isset($class) ? $class : '');

printf('<input %s />', $this['field']->attributes($attributes, array('label', 'description', 'default')));
printf('<input %s />', $this['field']->attributes(array('type' => 'hidden', 'name' => str_replace("[{$node->attributes()->name}]", "[lat]", $name), 'value' => isset($item, $item['lat']) ? $item['lat'] : '')));
printf('<input %s />', $this['field']->attributes(array('type' => 'hidden', 'name' => str_replace("[{$node->attributes()->name}]", "[lng]", $name), 'value' => isset($item, $item['lng']) ? $item['lng'] : '')));

?>

<script type="text/javascript">

jQuery(function($){
	
	$('input.location').die('focus.location').live('focus.location', function() {

		var $this = $(this);
		var lat   = $(this).nextAll('input[name$="[lat]"]');
		var lng   = $(this).nextAll('input[name$="[lng]"]');

		$this.autocomplete({
			delay: 500,
			minLength: 3,
			source: function(request, response) {
				
				$this.prev('h4').addClass('saving').append('<span />');

				$.getJSON(widgetkitajax+"&task=locate_map", { address: $this.val() },
					function(data) {

						$this.prev('h4').removeClass('saving').find('span').remove();

						var ret = response($.map(data.results, function(item) {
							return {
								label: item.formatted_address,
								value: item.formatted_address,
								lat: item.geometry.location.lat, 
								lng: item.geometry.location.lng 
							}
						}));
					}
				);
			},
			select: function(event, ui) {
                lat.val(ui.item.lat);
                lng.val(ui.item.lng);
			}
		});

	});

});

</script>