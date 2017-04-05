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
$images    = $this['gallery']->images($widget);

?>

<?php if (count($images)) : ?>
<div id="gallery-<?php echo $widget_id; ?>" class="wk-gallery wk-gallery-default">
	<div>
		<ul class="slides">

			<?php foreach ($images as $image) : ?>
            
				<?php
				
					$tabs[]     = '<li><span></span></li>';
					$captions[] = '<li>'.(strlen($image['caption']) ? $image['caption']:"").'</li>';
					$lightbox  = '';

					/* Prepare Lightbox */
					if ($settings['lightbox'] && !$image['link']) {
						$lightbox = 'data-lightbox="group:'.$widget_id.'"';
					}
					
					/* Prepare Image */
					$content = '<img src="'.$image['cache_url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="'.$image['filename'].'" />';
					
				?>

				<?php if ($settings['lightbox'] || $image['link']) : ?>
					<li><article><a class="" href="<?php echo $image['link'] ? $image['link'] : $image['url']; ?>" <?php echo $lightbox; ?>><?php echo $content; ?></a></article></li>
				<?php else : ?>		
					<li><article><?php echo $content; ?></article></li>
				<?php endif; ?>
			
			<?php endforeach; ?>
			
		</ul>
        <?php if ($settings['buttons']): ?><div class="next"></div><div class="prev"></div><?php endif; ?>
		<div class="caption"></div><ul class="captions"><?php echo implode('', $captions);?></ul>
	</div>
	<?php echo ($settings['navigation'] && count($tabs)) ? '<ul class="nav">'.implode('', $tabs).'</ul>' : '';?>
</div>

<script type="text/javascript">

	jQuery(function($) {

		$("#gallery-<?php echo $widget_id; ?>").galleryslideshow(
			<?php echo json_encode($settings); ?>
		);
	});

</script>
	
<?php else : ?>
	<?php echo "No images found."; ?>
<?php endif; ?>