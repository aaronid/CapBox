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
 * Joomla! Content Page
 * 
 * @version 1.5.15
 */
class cdfaq_com_content {
	
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
		if ($instance == null) $instance = new cdfaq_com_content($catid, $secid);
		
		return $instance;
	}
	
	/**
	 * Assign articles to variables
	 * 
	 * @param 	array			$catid
	 * @param 	array			$secid
	 * @return	array
	 */
	function cdfaq_com_content($catid = array(), $secid = array()) {
		
		$this->catid = $catid;
		$this->secid = $secid;
		
		$this->plgname = 'cdfaq';
		$this->plugin = &JPluginHelper::getPlugin('content', $this->plgname);
		$this->params = new JParameter($this->plugin->params);
	}
	
	/**
	 * Get Articles
	 * 
	 * @return	mixed	array, boolean		Array if success.
	 */
	function getArticles() {
		global $mainframe;
		
		$db =& JFactory::getDBO();
		
		$user = &JFactory::getUser();
		$aid = $user->get('aid', 0);
		
		$contentConfig	= &JComponentHelper::getParams( 'com_content' );
		$noauth			= !$contentConfig->get('shownoauth');
		
		$now 	 = date('Y-m-d H:i:s', time() + $mainframe->getCfg('offset') * 60 * 60);
		$nullDate = $db->getNullDate();
		
		// category ordering
		$cc_ordering = 'cc.id'; // default
		switch ($this->params->get('cc_ordering', 'cc.id')) {
			case 'alpha' :
				$cc_ordering = 'cc.title';
				break;
			case 'ralpha' :
				$cc_ordering = 'cc.title DESC';
				break;
			case 'order' :
				$cc_ordering = 'cc.ordering';
				break;
			default :
				$cc_ordering = 'cc.id';
				break;
		}
		
		// ordering
		$a_ordering = 'a.id'; // default
		switch ($this->params->get('a_ordering', 'a.id')) {
			case 'date' :
				$a_ordering = 'a.created ASC';
				break;
			case 'rdate' :
				$a_ordering = 'a.created DESC';
				break;
			case 'alpha' :
				$a_ordering = 'a.title';
				break;
			case 'ralpha' :
				$a_ordering = 'a.title DESC';
				break;
			case 'order' :
				$a_ordering = 'a.ordering';
				break;
			default :
				$a_ordering = 'a.id';
				break;
		}
		
		// section specified
		$secCondition = '';
		if ($this->secid) {
			JArrayHelper::toInteger( $this->secid );
			$secCondition = ' AND (s.id=' . implode( ' OR s.id=', $this->secid ) . ')';
		}
		
		// category specified
		$catCondition = '';
		if ($this->catid) {
			JArrayHelper::toInteger( $this->catid );
			$catCondition = ' AND (cc.id=' . implode( ' OR cc.id=', $this->catid ) . ')';
		}
		
		$where = '';
		
		// ensure should be published
		$where .= " AND ( a.publish_up = ".$db->Quote($nullDate)." OR a.publish_up <= ".$db->Quote($now)." )";
		$where .= " AND ( a.publish_down = ".$db->Quote($nullDate)." OR a.publish_down >= ".$db->Quote($now)." )";
		
		// Content Items only
    	$query = 'SELECT a.*, ' .
    		' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
    		' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
    		' FROM #__content AS a' .
    		' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
    		' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
    		' WHERE a.state = 1'. $where .' AND s.id > 0' .
    		($noauth ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
    		($this->catid ? $catCondition : '').
    		($this->secid ? $secCondition : '').
    		' AND s.published = 1' .
    		' AND cc.published = 1' .
    		' ORDER BY ' . $cc_ordering . ', ' . $a_ordering;
		$db->setQuery($query);
		
		$rows = $db->loadObjectList();
		
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
			$category = &JTable::getInstance('Category');
			$category->load($catid);
			
			$temp_object->id = $category->id;
			$temp_object->title = $category->title;
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