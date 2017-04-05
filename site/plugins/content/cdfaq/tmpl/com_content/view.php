<?php
/**
 * Core Design FAQ plugin for Joomla! 1.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla
 * @subpackage	Content
 * @category   	Plugin
 * @version		1.0.0
 * @copyright	Copyright (C) 2007 - 2010 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<div class="<?php echo $uitheme; ?> cdfaq">
	<div class="cdfaq_<?php echo $id; ?>">
		<?php foreach($category_instance as $key=>$category): ?>
			<a href="#" name="cdfaq_category_<?php echo $category->id; ?>"></a>
			<?php if ($this->params->get('display_category_title', 0)): ?>
				<h2 class="category_title"><?php echo $category->title; ?></h2>
			<?php endif; ?>
			<?php if ($this->params->get('display_category_description', 0)): ?>
				<div class="category_description"><?php echo $category->description; ?></div>
			<?php endif; ?>
			
			<div class="cdfaq_list">
				<?php foreach($category->articles as $key=>$article): ?>
					<h3 class="header" id="<?php echo $id . '_' . $article->catid . '_' . $key; ?>">
						<a href="#"><?php echo $article->title; ?></a>
					</h3>
					<div>
						<?php if ($this->params->get('display_info', 0)): ?>
							<?php
							$author = &JFactory::getUser($article->created_by);
							$modified = &JFactory::getUser($article->modified_by);
							?>
							<div class="<?php echo $uitheme; ?>">
								<div class="ui-widget-content ui-corner-all cdfaq_info">
									<?php echo JText::_('CDFAQ_ADDEDBY'); ?>: <?php echo $author->name; ?> 
									<span class="addedtime">(<?php echo JHTML::_('date', $article->created, JText::_('DATE_FORMAT_LC2')); ?>)</span>
									<?php if (intval($article->modified) != 0): ?>
										<br />
										<?php echo JText::_('CDFAQ_LAST_MODIFIED'); ?>: <?php echo $modified->name; ?> 
										<span class="addedtime">(<?php echo JHTML::_('date', $article->modified, JText::_('DATE_FORMAT_LC2')); ?>)</span>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						<div class="introtext">
							<?php echo $article->introtext; ?>
						</div>
						<?php if ($article->fulltext): ?>
							<div class="show_less_more">
								<a href="#" title="<?php echo JText::_('CDFAQ_MORE_INFO'); ?>"><?php echo JText::_('CDFAQ_MORE_INFO'); ?></a>
								<hr class="cleaner" />
								<div class="fulltext">
									<?php echo $article->fulltext; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			<?php if ($this->params->get('display_navigation', 0)): ?>
				<div class="goToTop ui-state-default ui-corner-all"><a href="#cdfaq_navigation" class="ui-icon ui-icon-circle-arrow-n" title="<?php echo JText::_('CDFAQ_GOTOTOP'); ?>"></a></div>
				<hr class="cleaner" />
			<?php endif; ?>
			
			</div>
		<?php endforeach; ?>
	</div>
</div>