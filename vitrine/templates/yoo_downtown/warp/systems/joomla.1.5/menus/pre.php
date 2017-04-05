<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

/*
	Class: WarpMenuPre
		Menu base class
*/
class WarpMenuPre extends WarpMenu {
	
	/*
		Function: process

		Returns:
			Object
	*/		
	public function process($module, $element) {

		// has ul ?
		if (!$element->first('ul:first')) {
			return false;
		}

		// init vars
		$menu   = JSite::getMenu();
		$images = strpos($module->parameter->get('class_sfx'), 'images-off') === false;        

		foreach ($element->find('li') as $li) {

			// get menu item
			if (preg_match('/item(\d+)/', $li->attr('class'), $matches)) {
				$item   = $menu->getItem($matches[1]);
				$params = new JParameter($item->params);
			}

			// set id
			if (isset($item)) {
				$li->attr('data-id', $item->id);
			}

			// set current and active
			if ($li->hasClass('active')) {
				$li->attr('data-menu-active', $li->attr('id') == 'current' ? 2 : 1);
			}

			// set columns and width
			if (isset($item) && strpos($item->params, 'column') !== false) {

				if (preg_match('/columns-(\d+)/', $params->get('pageclass_sfx'), $matches)) {
					$li->attr('data-menu-columns', $matches[1]);
				}
				
				if (preg_match('/columnwidth-(\d+)/', $params->get('pageclass_sfx'), $matches)) {
					$li->attr('data-menu-columnwidth', $matches[1]);
				}
				
			}
			
			// set image
			if (isset($item) && $images && ($image = $params->get('menu_image'))) {
				if ($image != -1) {
					$li->attr('data-menu-image', JURI::base().'images/stories/'.$image);
				}
			}
		
			$li->removeAttr('id')->removeAttr('class');
		}
				
		return $element;
	}

}