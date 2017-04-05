<?php
/**
* @package   Widgetkit Component
* @file      editor.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

jimport('joomla.html.editor');

/*
	Class: EditorWidgetkitHelper
		Editor helper class, to integrate the Joomla Editor Plugins.
*/
class EditorWidgetkitHelper extends WidgetkitHelper {

	/*
		Function: init
			Init System Editor
	*/
	public function init() {
		
		if (is_a($this['system']->document, 'JDocumentRAW')) {
			return;
		}
		
		$editor = JFactory::getConfig()->getValue('config.editor');
		
		if (in_array(strtolower($editor), array('tinymce', 'jce'))) {
			JEditor::getInstance($editor)->_loadEditor();
		}
	}
	
}