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
			<?php if ($this->params->get('display_category_title', 0)): ?>
				<h2 class="category_title"><?php echo $category->title; ?></h2>
			<?php endif; ?>
			<?php if ($this->params->get('display_category_description', 0)): ?>
				<div class="category_description"><?php echo $category->description; ?></div>
			<?php endif; ?>
			<br />
			<div class="cdfaq_list">
				<?php foreach($category->articles as $key=>$article): ?>
					<h3 class="header" id="<?php echo $id . '_' . $article->catid . '_' . $key; ?>">
						<?php echo $article->title; ?>
					</h3>
					<div>
						<div class="introtext">
							<?php echo $article->introtext; ?>
						</div>
						<?php if ($article->fulltext): ?>
							<div class="fulltext">
								<?php echo $article->fulltext; ?>
							</div>
							<br />
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>