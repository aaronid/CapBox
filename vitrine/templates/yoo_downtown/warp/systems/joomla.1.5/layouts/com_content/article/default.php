<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$canEdit = ($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own'));

?>

<div id="system">
	
	<?php if ($this->params->get('show_page_title', 1) && $this->params->get('page_title') != $this->article->title) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_title')); ?></h1>
	<?php endif; ?>

	<article class="item">

		<?php if ($this->params->get('show_title')) : ?>
		<header>

			<?php if (!$this->print) : ?>
				<?php if ($this->params->get('show_email_icon')) : ?>
				<div class="icon email"><?php echo JHTML::_('icon.email',  $this->article, $this->params, $this->access); ?></div>
				<?php endif; ?>
			
				<?php if ( $this->params->get( 'show_print_icon' )) : ?>
				<div class="icon print"><?php echo JHTML::_('icon.print_popup',  $this->article, $this->params, $this->access); ?></div>
				<?php endif; ?>
			
				<?php if ($this->params->get('show_pdf_icon')) : ?>
				<div class="icon pdf"><?php echo JHTML::_('icon.pdf',  $this->article, $this->params, $this->access); ?></div>
				<?php endif; ?>
			<?php else : ?>
				<div class="icon printscreen"><?php echo JHTML::_('icon.print_screen',  $this->article, $this->params, $this->access); ?></div>
			<?php endif; ?>

			<h1 class="title"><?php echo $this->escape($this->article->title); ?></h1>

			<?php if ($this->params->get('show_create_date') ||	($this->params->get('show_author') && $this->article->author != "") || ($this->params->get('show_section') && $this->article->sectionid) || ($this->params->get('show_category') && $this->article->catid)) : ?>
			<p class="meta">
		
				<?php
					
					if ($this->params->get('show_author') && ($this->article->author != "")) {
						JText::printf( 'Written by', ($this->article->created_by_alias ? $this->article->created_by_alias : $this->article->author));
					}

					if ($this->params->get('show_create_date')) {
						echo ' '.JText::_('on').' <time datetime="'.substr($this->article->created, 0,10).'" pubdate>'.JHTML::_('date', $this->article->created, JText::_('DATE_FORMAT_LC3')).'</time>';
					}
	
					echo '. ';
				
					if (($this->params->get('show_section') && $this->article->sectionid) || ($this->params->get('show_category') && $this->article->catid)) {
						echo JText::_('Posted in').' ';
						if ($this->params->get('show_section') && $this->article->sectionid && isset($this->article->section)) {
							if ($this->params->get('link_section')) echo '<a href="'.JRoute::_(ContentHelperRoute::getSectionRoute($this->article->sectionid)).'">';
							echo $this->article->section;
							if ($this->params->get('link_section')) echo '</a>';
							if ($this->params->get('show_category')) echo ' - ';
						}
						if ($this->params->get('show_category') && $this->article->catid) {
							if ($this->params->get('link_category')) echo '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->article->catslug, $this->article->sectionid)).'">';
							echo $this->article->category;
							if ($this->params->get('link_category')) echo '</a>';
						}
					}
				
				?>	
			
			</p>
			<?php endif; ?>
	
		</header>
		<?php endif; ?>
	
		<?php
		
			if (!$this->params->get('show_intro')) {
				echo $this->article->event->afterDisplayTitle;
			}
		
			echo $this->article->event->beforeDisplayContent;

			if (isset ($this->article->toc)) {
				echo $this->article->toc;
			}
			
		?>
		
		<div class="content clearfix"><?php echo $this->article->text; ?></div>

		<?php if ($canEdit) : ?>
		<p class="edit"><?php echo JHTML::_('icon.edit', $this->article, $this->params, $this->access); ?> <?php echo JText::_('Edit this article.'); ?></p>
		<?php endif; ?>
		
		<?php echo $this->article->event->afterDisplayContent; ?>

	</article>

</div>