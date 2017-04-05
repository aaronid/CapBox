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

/**
 * K2
 * 
 * @version 2.2
 */
class cdfaq_com_k2 {
	
	var $catid = array();
	var $secid = array();
	
	var $overrides = '';
	
	
	/**
	 * Get Instance
	 * 
	 * @param	array		$catid
	 * @param	array		$secid
	 * @return 	instance
	 */
	function &getInstance($catid = array(), $secid = array()) {
		static $instance;
		if ($instance == null) $instance = new cdfaq_com_k2($catid, $secid);
		
		return $instance;
	}
	
	/**
	 * Assign articles to variables
	 * 
	 * @param 	array			$catid
	 * @param 	array			$secid
	 * @return	array
	 */
	function cdfaq_com_k2($catid = array(), $secid = array()) {
		
		$this->secid = $secid;
		$this->catid = $catid;
		
		$this->plgname = 'cdfaq';
		$this->plugin = &JPluginHelper::getPlugin('content', $this->plgname);
		$this->params = new JParameter($this->plugin->params);
		
		return false;
	}
	
	/**
	 * Get Articles
	 * 
	 * @return	mixed	array, boolean		Array if success.
	 */
	function getArticles() {
		
		require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DS . 'modules' . DS . 'mod_k2_content' . DS . 'helper.php');
		
		$moduleid = (int) plgContentCdFaq::getParam('moduleid', $this->overrides, 0);
		
		$module = & JTable::getInstance('module');
		$module->load($moduleid);
		
		// no module
		if (!$module->params) {
			JError::raiseNotice('', JText::sprintf('CDFAQ_SPECIFIED_MODULE_DOESNT_EXISTS', $moduleid));
		   	return false;
		}
		
		$params = new JParameter( $module->params );
		
		if (!$rows = modK2ContentHelper::getItems($params, 'html')) return false;
		
		// get categories id
		$category_ids = array();
		foreach ($rows as $row) {
			$category_ids []= $row->catid;
		}
		$category_ids = array_unique($category_ids);
		
		$articles_instance = array();
		foreach ($category_ids as $catid) {
			$temp_object = new stdClass();
			
			// get category info
			JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
			$category = &JTable::getInstance('K2Category', 'Table');
            $category->load($catid);
            
			$temp_object->id = $category->id;
			$temp_object->title = $category->name;
			$temp_object->description = $category->description;
			
			foreach ($rows as $row) {
				if ($row->catid == $catid) {
					$temp_object->articles []= $row;
				}
			}
			$articles_instance [] = $temp_object;
			unset($temp_object);
		}
		
		return $articles_instance;
	}
	
}

?>