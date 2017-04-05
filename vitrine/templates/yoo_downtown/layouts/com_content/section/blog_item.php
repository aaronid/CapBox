<?php
/**
* @package   yoo_downtown
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$canEdit = ($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own'));

?>

<article class="item">

	<?php if ($this->item->params->get('show_title')) : ?>
	<header>
	
		<?php if ($this->item->params->get('show_email_icon')) : ?>
		<div class="icon email"><?php echo JHTML::_('icon.email', $this->item, $this->item->params, $this->access); ?></div>
		<?php endif; ?>
	
		<?php if ( $this->item->params->get( 'show_print_icon' )) : ?>
		<div class="icon print"><?php echo JHTML::_('icon.print_popup', $this->item, $this->item->params, $this->access); ?></div>
		<?php endif; ?>
	
		<?php if ($this->item->params->get('show_pdf_icon')) : ?>
		<div class="icon pdf"><?php echo JHTML::_('icon.pdf', $this->item, $this->item->params, $this->access); ?></div>
		<?php endif; ?>
		
		<h1 class="title">
			<?php if ($this->item->params->get('show_create_date')) : ?>
			<time datetime="<?php echo substr($this->item->created, 0,10); ?>" pubdate>
				<span class="month"><?php echo JHTML::_('date', $this->item->created, JText::_('%b')); ?></span>
				<span class="day"><?php echo JHTML::_('date', $this->item->created, JText::_('%d')); ?></span>
			</time>
			<?php endif; ?>
			
			<?php if ($this->item->params->get('link_titles') && $this->item->readmore_link != '') : ?>
				<a href="<?php echo $this->item->readmore_link; ?>" title="<?php echo $this->escape($this->item->title); ?>"><?php echo $this->escape($this->item->title); ?></a>
			<?php else : ?>
				<?php echo $this->escape($this->item->title); ?>
			<?php endif; ?>
		</h1>
		
		<?php if (($this->item->params->get('show_author') && $this->item->author != "") || ($this->item->params->get('show_section') && $this->item->sectionid) || ($this->item->params->get('show_category') && $this->item->catid)) : ?>
		
		<p class="meta">
	
			<?php
				
				if (($this->item->params->get('show_author')) && ($this->item->author != "")) {
					JText::printf( 'Written by', ($this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author));
					echo '. ';
				}

				if (($this->item->params->get('show_section') && $this->item->sectionid) || ($this->item->params->get('show_category') && $this->item->catid)) {
					echo JText::_('Posted in').' ';
					if ($this->item->params->get('show_section') && $this->item->sectionid && isset($this->section->title)) {
						if ($this->item->params->get('link_section')) echo '<a href="'.JRoute::_(ContentHelperRoute::getSectionRoute($this->item->sectionid)).'">';
						echo $this->section->title;
						if ($this->item->params->get('link_section')) echo '</a>';
						if ($this->item->params->get('show_category')) echo ' - ';
					}
					if ($this->item->params->get('show_category') && $this->item->catid) {
						if ($this->item->params->get('link_category')) echo '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug, $this->item->sectionid)).'">';
						echo $this->item->category;
						if ($this->item->params->get('link_category')) echo '</a>';
					}
				}
			
			?>	
		
		</p>
		<?php endif; ?>

	</header>
	<?php endif; ?>

	<?php
	
		if (!$this->item->params->get('show_intro')) {
			echo $this->item->event->afterDisplayTitle;
		}
	
		echo $this->item->event->beforeDisplayContent;
		
		if (isset ($this->item->toc)) {
			echo $this->item->toc;
		}
		
	?>
	
	<div class="content clearfix"><?php echo $this->item->text; ?></div>
	
	<?php if ($this->item->params->get('show_readmore') && $this->item->readmore) : ?>
	<p class="links">
		<a href="<?php echo $this->item->readmore_link; ?>" title="<?php echo $this->escape($this->item->title); ?>">
			<?php
				
				if ($this->item->readmore_register) {
					echo JText::_('Register to read more');
				} elseif ($readmore = $this->item->params->get('readmore')) {
					echo $readmore;
				} else {
					echo JText::_('Lire la suite');
				}
				
			?>
		</a>
	</p>
	<?php endif; ?>

	<?php if ($canEdit) : ?>
	<p class="edit"><?php echo JHTML::_('icon.edit', $this->item, $this->item->params, $this->access); ?> <?php echo JText::_('Edit this article.'); ?></p>
	<?php endif; ?>

	<?php echo $this->item->event->afterDisplayContent; ?>

</article>