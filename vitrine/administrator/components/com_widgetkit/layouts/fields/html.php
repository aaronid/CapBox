<?php
/**
* @package   Widgetkit Component
* @file      html.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// set attributes
$attributes = array();
$attributes['id']    = 'html-editor-'.uniqid();
$attributes['class'] = 'html-editor';
$attributes['name']  = $name;

printf('<textarea %s>%s</textarea>', $this['field']->attributes($attributes), $value);

?>

<script type="text/javascript">

	jQuery(function($){
		
		var id = '<?php echo $attributes["id"]; ?>';
		var editor = window['WFEditor'] || window['JContentEditor'] || window['tinyMCE'];
		
		if (!editor || $('#' + id + '_tbl').length) {
			return;
		}

		new tinymce.Editor(id, $.extend(editor.settings, {'forced_root_block': ''})).render();

		$('#' + id).bind({
			'editor-action-start': function() {
				tinyMCE.execCommand('mceRemoveControl', false, id);
			},
			'editor-action-stop': function() {
				tinyMCE.execCommand('mceAddControl', true, id);
			}
		});

	});

</script>