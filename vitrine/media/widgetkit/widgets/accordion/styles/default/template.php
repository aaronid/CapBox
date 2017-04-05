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
	
?>

<div id="accordion-<?php echo $widget_id;?>" class="wk-accordion wk-accordion-default clearfix" <?php if (is_numeric($settings['width'])) echo 'style="width: '.$settings['width'].'px;"'; ?>>
	<?php foreach ($widget->items as $key => $item) : ?>
		<h3 class="toggler"><?php echo $item['title'];?></h3>
		<div class="content clearfix"><?php echo $item['content'];?></div>
	<?php endforeach; ?>
</div>

<script type="text/javascript">

	jQuery(function($) {
		$("#accordion-<?php echo $widget_id; ?>").accordion(
			<?php echo json_encode($settings); ?>
		);
	});

</script>