<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<div id="system">

	<?php if ($this->params->get('show_page_title', 1)) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_title')); ?></h1>
	<?php endif; ?>

	<?php
	
	// init vars
	$articles = '';
	$count = 1;
	
	// if leading articles
	if ($this->params->def('num_leading_articles', 1)) {
		for ($i = $this->pagination->limitstart; $i < ($this->pagination->limitstart + $this->params->get('num_leading_articles')); $i++) {
			if ($i >= $this->total) break; 
			$this->item =& $this->getItem($i, $this->params);
			$articles .= '<div class="grid-box width100 leading">'.$this->loadTemplate('item').'</div>';
		}
	} else {
		$i = $this->pagination->limitstart;
	}
	
	// articles
	if ($i < $this->total) {

		// init vars
		$count   = min($this->params->get('num_intro_articles', 4), ($this->total - $i));
		$rows    = ceil($count / $this->params->get('num_columns', 2));
		$columns = array();
		$row     = 0;
		$column  = 0;
		
		// create intro columns
		for ($j = 0; $j < $count; $j++, $i++) { 

			if ($this->params->get('multi_column_order', 1) == 0) {
				// order down
				if ($row >= $rows) {
					$column++;
					$row  = 0;
					$rows = ceil(($count - $j) / ($this->params->get('num_columns', 2) - $column));
				}
				$row++;
			} else {
				// order across
				$column = $j % $this->params->get('num_columns', 2);
			}

			if (!isset($columns[$column])) {
				$columns[$column] = '';
			}

			$this->item =& $this->getItem($i, $this->params);
			$columns[$column] .= $this->loadTemplate('item');
		}

		// render intro columns
		if ($count = count($columns)) {
			for ($j = 0; $j < $count; $j++) {
				$articles .= '<div class="grid-box width'.intval(100 / $count).'">'.$columns[$j].'</div>';
			}
		}
	}
	
	if ($articles) {
		echo '<div class="items items-col-'.$count.' grid-block">'.$articles.'</div>';
	}
	
	?>

	<?php if ($this->params->def('num_links', 4) && ($i < $this->total)) : ?>
	<div class="item-list">
		<?php $this->links = array_splice($this->items, $i - $this->pagination->limitstart); ?>
		<h3><?php echo JText::_('More Articles...'); ?></h3>
		<ul>
			<?php foreach ($this->links as $link) : ?>
			<li>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($link->slug, $link->catslug, $link->sectionid)); ?>"><?php echo $link->title; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<?php echo $this->pagination->getPagesLinks(); ?>
	<?php endif; ?>

</div>