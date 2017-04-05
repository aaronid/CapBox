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
<ul id="gallery-slider-<?php echo $widget_id; ?>" class="slides">

	<?php foreach ($images as $image) : ?>

		<?php
		
			$lightbox  = '';
			$spotlight = '';
			$overlay   = '';

			/* Prepare Lightbox */
			if ($settings['lightbox'] && !$image['link']) {
				$lightbox = 'data-lightbox="group:'.$widget_id.'"';
	
				$image['caption'] = strip_tags($image['caption']);
				if ($settings['lightbox_caption']) {
					$lightbox .= (strlen($image['caption'])) ? ' title="'.$image['caption'].'"' : ' title="'.$image['filename'].'"';
				}
			}

			/* Prepare Spotlight */
			if ($settings['spotlight']) {
				if ($settings['spotlight_effect'] && strlen($image['caption'])) {
					$spotlight = 'data-spotlight="effect:'.$settings['spotlight_effect'].'"';
					$overlay = '<div class="overlay">'.$image['caption'].'</div>';
				} elseif (!$settings['spotlight_effect']) {
					$spotlight = 'data-spotlight="on"';
				}
			}

			/* Prepare Image */
			$position = ($settings['center']) ? '50%' : '0';
			$background = 'style="background: url('.$image['cache_url'].') '.$position.' 0 no-repeat;"';
			$content = '<div style="height: '.$image['height'].'px; width: '.$image['width'].'px;"></div>'.$overlay;
			
		?>
		
		<?php if ($settings['lightbox'] || $image['link']) : ?>
			<li <?php echo $background; ?>><a class="" style="<?php echo 'width: '.$image['width'].'px;'; ?>" href="<?php echo $image['link'] ? $image['link'] : $image['url']; ?>" <?php echo $lightbox; ?> <?php echo $spotlight; ?>><?php echo $content; ?></a></li>
		<?php elseif ($settings['spotlight']) : ?>
			<li <?php echo $background; ?>><div style="<?php echo 'width: '.$image['width'].'px;'; ?>" <?php echo $spotlight; ?>><?php echo $content; ?></div></li>
		<?php else : ?>		
			<li <?php echo $background; ?>><?php echo $content; ?></li>
		<?php endif; ?>

	<?php endforeach; ?>
	
</ul>

<script type="text/javascript">

	jQuery(function($) {

		$("#gallery-slider-<?php echo $widget_id; ?>").galleryslider(
			<?php echo json_encode($settings); ?>
		);

	});

</script>
	
<?php else : ?>
	<?php echo "No images found."; ?>
<?php endif; ?>