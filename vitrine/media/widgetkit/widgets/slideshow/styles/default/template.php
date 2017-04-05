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
	$tabs      = array();
	$captions  = array();

?>

<div id="slideshow-<?php echo $widget_id; ?>" class="wk-slideshow wk-slideshow-default">
	<div>
		<ul class="slides">

			<?php foreach ($widget->items as $key => $item) : ?>
			<?php $tabs[]     = '<li><span></span></li>'; ?>
			<?php $captions[] = '<li>'.(isset($item['caption']) ? $item['caption']:"").'</li>'; ?>
			<li>
				<article><?php echo $item['content']; ?></article>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php if ($settings['buttons']): ?><div class="next"></div><div class="prev"></div><?php endif; ?>
		<div class="caption"></div><ul class="captions"><?php echo implode('', $captions);?></ul>
	</div>
	<?php echo ($settings['navigation'] && count($tabs)) ? '<ul class="nav">'.implode('', $tabs).'</ul>' : '';?>
</div>

<script type="text/javascript">

	jQuery(function($) {

		$("#slideshow-<?php echo $widget_id; ?>").slideshow(
			<?php echo json_encode($settings); ?>
		);

	});

</script>