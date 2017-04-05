<?php
/**
 * Core Design Web Gallery plugin for Joomla! 1.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla
 * @subpackage	Content
 * @category   	Plugin
 * @version		1.0.9
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


class joomgalleryWebGalleryIntegration {

	/**
	 * Check the pre-requirements
	 * 
	 * @return string	Error message.
	 */
	function preRequirements() {
		$message = '';

		if (!joomgalleryWebGalleryIntegration::installed()) $message = JText::_('CDWEBGALLERY_NO_JOOMGALLERY');
		return $message;
	}

	/**
	 * Integration
	 *
	 * @return array	Image set parameters.
	 */
	function integration($match = '') {
		require_once(JPATH_ROOT.DS.'components'.DS.'com_joomgallery'.DS.'classes'.DS.'interface.class.php');
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomgallery'.DS.'common.joomgallery.php');
    	$joomgallery_config = Joom_getConfig();
    	$joomgallery_config->_jg_config = $joomgallery_config;
    	
		
		// get user object
	    $user = &JFactory::getUser();
	
	    // create interface object
	    $jinterface = new joominterface();
	    
  		$origpicturepath  = $joomgallery_config->jg_pathoriginalimages;
  		$thumbpicturepath  = $joomgallery_config->jg_paththumbs;
  		
	    $image_set = array();
	    
	    $category = (int) trim($match);
	    
	    $db = & JFactory::getDBO();
	    
	    $query = 'SELECT ' . $db->nameQuote('id') .
	    ' FROM ' . $db->nameQuote('#__joomgallery') .
	    ' WHERE ' . $db->nameQuote('catid') . ' = ' . $category . ' ORDER BY ' . $db->nameQuote('ordering') . ' DESC';

		$db->setQuery($query);
		$ids = $db->loadResultArray();
		
		foreach ($ids as $key=>$id) {
			// get image object
			$pic_obj = $jinterface->getPicture($id, $user->get('aid'));
			
			if(!is_null($pic_obj)) {  // image found
	        	$thumb_src = _JOOM_LIVE_SITE . $thumbpicturepath . $pic_obj->catpath . '/' . $pic_obj->imgfilename;
	        	$img_src = _JOOM_LIVE_SITE . $origpicturepath . $pic_obj->catpath . '/' . $pic_obj->imgfilename;
	        	
	        	$image_set[$key]->img_tag = '';
				$image_set[$key]->img_src = $img_src;
				$image_set[$key]->img_src_path = JPath::clean(plgContentCdWebGallery::absPath() . DS . $origpicturepath . $pic_obj->catpath . DS . $pic_obj->imgfilename);
				$image_set[$key]->img_alt = $pic_obj->imgtitle;
				$image_set[$key]->img_title = $pic_obj->imgtext;
				$image_set[$key]->thumb_name = basename($thumb_src);
				$image_set[$key]->thumb_path = JPath::clean(plgContentCdWebGallery::absPath() . DS . $thumbpicturepath . $pic_obj->catpath . DS . $pic_obj->imgfilename);
				$image_set[$key]->thumb_src = $thumb_src;
				
				$imagesize = getimagesize($image_set[$key]->thumb_path);
				$image_set[$key]->thumb_width = $imagesize[0];
				$image_set[$key]->thumb_height = $imagesize[1];
	        	
			}
		}
	    
		return $image_set;
	}

	/**
	 * Check if PhocaGallery is installed
	 *
	 * @return boolean	True if exists.
	 */
	function installed() {
		if (JComponentHelper::isEnabled('com_joomgallery', true)) return true;
		return false;
	}

}

?>