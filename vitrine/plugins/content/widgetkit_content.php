<?php
/**
* @package   Widgetkit Component
* @file      widgetkit_content.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.plugin.plugin' );

class plgContentWidgetkit_Content extends JPlugin {

	public function onPrepareContent(&$article, &$params, $limitstart) {

		preg_match_all('#\[widgetkit id=(\d+)\]#', $article->text, $matches);

		if (count($matches[1])) {

			// load widgetkit
			require_once(JPATH_ADMINISTRATOR.'/components/com_widgetkit/widgetkit.php');	

			// get widgetkit
			$widgetkit = Widgetkit::getInstance();

			// render output
			foreach ($matches[1] as $i => $widget_id) {
				$output = $widgetkit['widget']->render($widget_id);
				$output = ($output === false) ? "Could not load widget with the id $widget_id." : $output;
				$article->text = str_replace($matches[0][$i], $output, $article->text);
			}
		}

		return '';
	}

}