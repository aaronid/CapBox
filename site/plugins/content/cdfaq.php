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

// Import library dependencies
jimport('joomla.plugin.plugin');
jimport('joomla.utilities.arrayhelper');

class plgContentCdFaq extends JPlugin
{

	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @param object $params  The object that holds the plugin parameters
	 * @since 1.5
	 */
	function plgContentCdFaq(&$subject)
	{
		parent::__construct($subject);
		
		// load plugin parameters
		$this->plgname = 'cdfaq';
		$this->plugin = &JPluginHelper::getPlugin('content', $this->plgname);
		$this->params = new JParameter($this->plugin->params);
		
		$this->livepath = JURI::root(true);
		
		// define language
		JPlugin::loadLanguage('plg_content_' . $this->plgname, JPATH_ADMINISTRATOR);
	}

	/**
	 * Call the prepare function
	 *
	 * Method is called by the view
	 *
	 * @param 	object		The article object.  Note $article->text is also available
	 * @param 	object		The article params
	 * @param 	int			The 'page' number
	 */
	function onPrepareContent(&$article, &$params, $limitstart=0)
	{
		
		// define the regular expression
		$regex = '#{faq(?:\s?(.*?)?)?}#is';

		if (!preg_match($regex, $article->text)) return false;
		
		// Scriptegrator check
		if (!class_exists('JScriptegrator')) {
			JError::raiseNotice('', JText::_('CDFAQ_ENABLE_SCRIPTEGRATOR'));
			return false;
		} else {
			$message = JScriptegrator::check('1.4.0', 'jquery', 'site');
			if ($message)  {
			   JError::raiseNotice('', $message);
			   return false;
      		}
		}
		
		$document = &JFactory::getDocument(); // set document
		
		$document->addStyleSheet($this->livepath . '/plugins/content/' . $this->plgname . '/css/' . $this->plgname . '.css');
		
		$document->addScript($this->livepath . '/plugins/content/' . $this->plgname . '/js/' . $this->plgname . '.js');
		
		$document->addScriptDeclaration("
		<!--
			jQuery(document).ready(function($){
				if ($.$this->plgname) {
					
					// settings
					$.$this->plgname.settings = {
						filterSlideSpeed : " . $this->params->get('filterSlideSpeed', 200) . ",
						scrollSpeed : " . $this->params->get('scrollSpeed', 750) . "
					};
					
					// language
					$.$this->plgname.language = {
						CDFAQ_MORE_INFO : '" . JText::_('CDFAQ_MORE_INFO') . "',
						CDFAQ_LESS_INFO : '" . JText::_('CDFAQ_LESS_INFO') . "'
					};
					
					// run application
					$.$this->plgname.initiator();
				}
			});
		// -->
		");
		
		$article->text = preg_replace_callback($regex, array($this, 'replacer'), $article->text);
		
	}
	
	/**
	 * Plugin replacer
	 * 
	 * @return string
	 */
	function replacer(&$match) {
		
		$this->extension = JRequest::getCmd('option', 'com_content', 'get');
		
		$overrides = (isset($match[1]) ? $match[1] : '');
		
		$secid = $this->getParam('section', $overrides, 0); // for Joomla! items
		$catid = $this->getParam('category', $overrides, 0); // for CCK based items and Joomla!
		
		// no section
		if ($this->extension === 'com_content' and !$secid) {
			// no category
			if (!$catid) {
				JError::raiseNotice('', JText::_('CDFAQ_NO_CATEGORY_OR_SECTION'));
				return false;
			}
		}
		
		// make array
		if ($secid) $secid = array_map('trim', explode(',', $secid));
		if ($catid) $catid = array_map('trim', explode(',', $catid));
		
		if (!$category_instance = $this->getArticles($catid, $secid, $overrides)) {
			$category_instance = array();
		}
		
		$uitheme = $this->getParam('uitheme', $overrides, $this->params->get('uitheme', 'ui-lightness'));
		if ($uitheme == '-1') $uitheme = 'ui-lightness';
		JScriptegrator::importUITheme($uitheme, 'ui.accordion');
		JScriptegrator::importUI('ui.accordion');
		
		$id = $this->getParam('id', $overrides, $this->randomString(5));
		
		$autoheight = (int) $this->getParam('autoheight', $overrides, $this->params->get('autoheight', 0));
		$autoheight = (string) ($autoheight === 0 ? 'false' :  'true');
		
		$event = $this->getParam('event', $overrides, $this->params->get('event', 'click'));
		
		$collapsible = (int) $this->getParam('collapsible', $overrides, $this->params->get('collapsible', 1));
		$collapsible = (string) ($collapsible === 1 ? 'true' :  'false');
		
		$ui_icon_header = $this->getParam('icon_header', $overrides, $this->params->get('ui_icon_header', 'ui-icon-circle-arrow-e'));
		$ui_icon_header_selected = $this->getParam('icon_header_selected', $overrides, $this->params->get('ui_icon_header_selected', 'ui-icon-circle-arrow-s'));
		
		$tmpl = '';
		
		// PRINT view
		if (JRequest::getInt('print', 0) and $category_instance) {
			if (!$layoutpath_print = $this->getLayoutPath('print')) return false;
			
			ob_start();
				require($layoutpath_print);
				$tmpl .= ob_get_contents();
			ob_end_clean();
			
			return $tmpl;
		}
		// @end
		
		$document = &JFactory::getDocument(); // set document
		
		$document->addScriptDeclaration( "
        <!--
			jQuery(function($) {
				// accordion element
				$('." . $this->plgname . "_$id').accordion({
					active: false,
					header: '.header',
					animated: 'slide',
					autoHeight: $autoheight,
					event: '$event',
					collapsible: $collapsible,
					icons: {
		    			header: '$ui_icon_header',
		   				headerSelected: '$ui_icon_header_selected'
					}
				});
				
				// autoopen if hash enabled
				var hash = $('." . $this->plgname . "_$id').find('h3.header[id=\"' + $.cdfaq.substr(location.hash, 1) + '\"]');
				if (hash.length === 1) hash.click();
			});
		//-->"
		);
		
		
		if (!$layoutpath_navigation = $this->getLayoutPath('navigation')) return false;
		if (!$layoutpath_filter = $this->getLayoutPath('filter')) return false;
		if (!$layoutpath_view = $this->getLayoutPath('view')) return false;
		
		// display navigation at top
		if ($category_instance and $this->params->get('display_navigation', 0)) {
			// navigation tmpl - once !!!
			static $once_navigation = 0;
			if (!$once_navigation) {
				ob_start();
					require($layoutpath_navigation);
					$tmpl .= ob_get_contents();
				ob_end_clean();
				$once_navigation = 1;
			}
		}
		
		if ($category_instance) {
			
			// filter tmpl - once !!!
			static $once_filter = 0;
			if (!$once_filter and $this->params->get('display_filter', 0)) {
				ob_start();
					require($layoutpath_filter);
					$tmpl .= ob_get_contents();
				ob_end_clean();
				$once_filter = 1;
			}
			
			// view tmpl
			ob_start();
				require($layoutpath_view);
				$tmpl .= ob_get_contents();
			ob_end_clean();
		}
		
		return $tmpl;
	}
	
	/**
     * Create a Random String
     * 
     * @param $length
     * @return string
     */
    function randomString($length = 5)
    {
        $alphanum = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $var_random = '';
        mt_srand(10000000 * (double)microtime());
        for ($i = 0; $i < (int)$length; $i++)
            $var_random .= $alphanum[mt_rand(0, 61)];
        unset($alphanum);
        return $var_random;
    }
	
	/**
	 * Load Articles
	 * 
	 * @param 	array	$catid
	 * @param 	array	$secid
	 * @param	string	$overrides
	 * @return 	array
	 */
	function getArticles($catid = array(), $secid = array(), $overrides = '') {
		$classfile = dirname(__FILE__) . DS . 'cdfaq' . DS . 'extension' . DS . 'cdfaq_' . $this->extension . '.php';
		
		if (!JFile::exists($classfile)) return false;
		
		$classname = 'cdfaq_' . $this->extension;
		
		require_once($classfile);
		
		if (is_callable(array(&$classname, 'getInstance'))) {
			$getInstance = call_user_func(array(&$classname, 'getInstance'), $catid, $secid);
			$getInstance->overrides = $overrides;
			
			if ($articles = $getInstance->getArticles($overrides)) return $articles;
		}
		
		return false;
	}
	
	/**
	 * Ge param from $match
	 * 
	 * @param $param
	 * @param $match
	 * @param $default
	 * @return string
	 */
	function getParam($param, $match, $default = '') {
		if (!$param or !$match) return $default;
		
		// no param founded
		if (JString::strpos($match, $param) === false) return $default;
		
		preg_match('#(?:^|\s)' . $param . '\s?=\s?"(.*?)?"#', $match, $found);
		
		return (isset($found[1]) ? $found[1] : $default);
	}
	
    /**
     * Get Layout
     * 
     * @param $file
     * @return string
     */
    function getLayoutPath($file = '') {
    	if (!$file) return false;
    	
    	$filepath = dirname(__FILE__) . DS . $this->plgname . DS . 'tmpl' . DS . $this->extension . DS . $file . '.php';
    	if (!JFile::exists($filepath)) return false;
		
		return $filepath;
    }
}
?>