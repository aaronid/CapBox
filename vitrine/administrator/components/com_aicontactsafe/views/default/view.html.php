<?php
/**
 * @version     $Id$ 2.0.1 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * added/fixed in version 2.0.1
 * reset the form field session variables after it is displayed
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// load the default component view class
jimport('joomla.application.component.view');

// define the default aiContactSafe view class
class AiContactSafeViewDefault extends JView {
	// component version
	var $_version = null;
	// mainframe (application) reference
	var $_app = null;
	// current task
	var $_task = null;
	// current aiContactSafe section
	var $_sTask = null;
	// this class is used in backend (1) or frontend(0)
	var $_backend = null;
	// id of the current user logged in
	var $_user_id = null;
	// css file used with this view
	var $_cssFile = null;
	// id of the current record
	var $_id = null;
	// configuration values
	var $_config_values = null;
	// sef is activated or not
	var $_sef = null;
	// order in which to place the records
	var $filter_order = null;

	// id of the help to display
	var $_help_id = '0';
	// parameters array
	var $_parameters = array();

	// construct function, it will iniaize the class variables
	function __construct( $default = array() )	{
		$this->_parameters = $default;

		$this->_version = $default['_version'];
		$this->_app = $default['_app'];
		$this->_task = $default['_task'];
		$this->_sTask = $default['_sTask'];
		$this->_backend = $default['_backend'];
		$this->_user_id = $default['_user_id'];
		$this->_sef = $default['_sef'];
		$this->_config_values = $default['_config_values'];
		$this->_cssFile = $this->getCssFile($this->_sTask);
		$this->_id = $this->getCurrentId();

		parent::__construct( $default );
	}

	// function to read the current id
	function getCurrentId() {
		// check for the id variable
		$id = JRequest::getVar('id', 0, 'request', 'int');
		// if the id was not sent, check for the cid variable
		if ($id == 0) {
			$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
			if (is_array($cid)) {
				$id = (int)implode('',array_slice($cid, 0, 1));
			}
		}
		return $id;
	}
	
	// function to get the name of the css file used with this view
	function getCssFile($sTask = '') {
		// if no sTask is called use the default css file
		if (strlen($sTask) == 0) {
			$cssFile = 'default';
		} else {
			$cssFile = $sTask;
		}
		// check for the css extension
		if (substr($cssFile,-4) != '.css') {
			$cssFile = $cssFile.'.css';
		}
		return $cssFile;
	}

	// function to call the css file used with this view
	function callCssFile($cssFile = '') {
		// check if css is activated/deactivated in control_panel
		$use_css = true;
		// check if this class is used from backend or frontend
		if ($this->_backend) {
			$use_css = $this->_config_values['use_css_backend'];
			$component_path = 'administrator/components';
		} else {
			$use_css = true;
			$component_path = 'components';
		}
		// if no cssFile is named call the default one of the class
		if (strlen($cssFile) == 0) {
			$cssFile = $this->_cssFile;
		}
		// if css is activated and there is a css file to call, continue the function
		if ($use_css) {
			$document =& JFactory::getDocument();
			$nameCssGeneral = JURI::root().$component_path.'/com_aicontactsafe/includes/css/aicontactsafe_general.css';
			$document->addStyleSheet($nameCssGeneral);

			if (strlen($cssFile) > 0) {
				// import joomla clases to manage file system
				jimport('joomla.filesystem.file');
				// determine if to use the css from the template or from the component
				$template_name = $this->_app->getTemplate();
				$tPath = JPATH_ROOT.DS.'templates'.DS.$template_name.DS.'html'.DS.'com_aicontactsafe'.DS.$cssFile;		
				if (JFile::exists($tPath)) {
					$nameCssFile = JURI::root().'templates/'.$template_name.'/html/com_aicontactsafe/'.$cssFile;
				} else {
					$nameCssFile = JURI::root().$component_path.'/com_aicontactsafe/views/'.$this->_sTask.'/tmpl/'.$cssFile;
				}
				$document->addStyleSheet($nameCssFile);
			}

		}
	}

	// function to define the toolbar depending on the section
	function setToolbarButtons() {
		if ($this->_backend) {
			switch(true) {
				case $this->_sTask == '' or $this->_sTask == 'default' :
					JToolBarHelper::custom( 'control_panel', 'control_panel.gif', 'control_panel.gif', JText::_( 'Control Panel' ), false,  false );
					break;
				case $this->_task == 'add' or $this->_task == 'edit' :
					JToolBarHelper::custom( 'save', 'save_ai.gif', 'save_ai.gif', JText::_( 'Save' ), false,  false );
					JToolBarHelper::custom( 'apply', 'apply_ai.gif', 'apply_ai.gif', JText::_( 'Apply' ), false,  false );
					JToolBarHelper::custom( 'cancel', 'cancel_ai.gif', 'cancel_ai.gif', JText::_( 'Cancel' ), false,  false );
					break;
				case $this->_task == 'delete' :
					JToolBarHelper::custom( 'confirmDelete',  'apply_ai.png', 'apply_ai.png', JText::_( 'Confirm' ), true,  false );
					JToolBarHelper::custom( 'cancel', 'cancel_ai.gif', 'cancel_ai.gif', JText::_( 'Cancel' ), false,  false );
					break;
				case $this->_task == 'display' :
					JToolBarHelper::custom( 'add', 'add_ai.gif', 'add_ai.gif', JText::_( 'Add new' ), false,  false );
					JToolBarHelper::custom( 'edit', 'edit_ai.gif', 'edit_ai.gif', JText::_( 'Edit' ), true,  false );
					JToolBarHelper::custom( 'delete', 'delete_ai.gif', 'delete_ai.gif', JText::_( 'Delete' ), true,  false );
					JToolBarHelper::custom( 'publish', 'publish_ai.gif', 'publish_ai.gif', JText::_( 'Publish' ), true,  false );
					JToolBarHelper::custom( 'unpublish', 'unpublish_ai.gif', 'unpublish_ai.gif', JText::_( 'Unpublish' ), true,  false );
					break;
			}
		}
	}

	// function to define the toolbar depending on the section
	function setToolbar() {
		if ($this->_backend) {
			// set the title with a link to the default section
			JToolBarHelper::title( '<a href="' . JRoute::_('index.php?option=com_aicontactsafe') . '">' . '<span style="color:#003366;">ai</span><span style="color:#FEB01C;">ContactSafe</span>' . '</a><span id="ai_version" style="font-size:9px; margin-left:5px; color:#003366;">v.'.$this->_version.'</span>','generic_ai.png' );
		}
		// set the rest of the buttons
		$this->setToolbarButtons();
	}

	// function to determine where to return the control when the current view is closed
	function setTaskReturn() {
		$return_task = array();
		switch(true) {
			case $this->_task == 'add' or $this->_task == 'edit' or $this->_task == 'delete' or $this->_task == 'confirmDelete' :
				$last_task = $this->_app->_session->get( 'last_task' );
				$return_task = $last_task;
				unset($return_task['task']);
				unset($return_task['id']);
				break;
			case $this->_task == 'display' :
			default :
				$return_task['sTask'] = $this->_sTask;
				break;
		}
		// record the section to return to
		$this->_app->_session->set( 'return_task:' . $this->_sTask, $return_task );
	}

	// function to initialize the variables used in the template
	function setVariables() {
		$model = &$this->getModel();

		switch(true) {
			// in case a record is added initialize the fields from postData in case of error
			case $this->_task == 'add' :
				$this->setRowData();
			// in case a record is modified initialize the fields
			case $this->_task == 'edit' :
				$this->setRowData($this->_id);
				break;
			// in case one or more records are deleted
			case $this->_task == 'delete' :
				$this->rows = $model->readDeleteRows();
				break;
			// or else initialize the variables to show a list of records
			case $this->_task == 'display' && strlen($this->_sTask) > 0 :
				$this->filter_order = $model->filter_order;
				$this->filter_order_Dir = $model->filter_order_Dir;
				$this->limit = $model->limit;
				$this->limitstart = $model->limitstart;
				$this->filter_condition = $model->filter_condition;
				$this->filter_string = $model->filter_string;
				$this->rows = $model->readRows();
				$this->pageNav = $model->pageNav;
				break;
			default :
				// - nothing
		}
	}

	// function to add to this view all the fields returned by the function getRowData from the module
	function setRowData($id = 0) {
		$model = &$this->getModel();
		if ( $this->_app->_session->get( 'isOK:' . $this->_sTask ) ) {
			$fields = $model->getRowData($id);
		} else {
			$fields = $model->readPostDataFromSession();
		}
		if (count($fields) > 0) {
			foreach($fields as $field_name => $field_value) {
				if (substr($field_name,0,1) != '_') {
					$this->$field_name = $field_value;
				}
			}
		}
	}

	// function to display the default template
	function viewDefault() {
		// add javascript
		$document =& JFactory::getDocument();
		$document->addScript( JURI::root(true).'/includes/js/joomla.javascript.js');
		// set the toolbar buttons
		$this->setToolbar();
		// initialize the template variables
		$this->setVariables();
		// call the css file
		$this->callCssFile();
		// determine to what section to return to
		$this->setTaskReturn();
		if ($this->_backend) {
			$activate_help = $this->_config_values['activate_help'];
		} else {
			$activate_help = false;
		}
		// display the view template
		if ($activate_help) {
			echo '<table id="aicontactsafe_with_help" border="0" cellpadding="0" cellspacing="0" width="100%">';
			echo '<tr><td id="aicontactsafe_main"><div id="aicontactsafe_main">';
			parent::display();
			echo '</div></td><td id="aicontactsafe_help"><div id="aicontactsafe_help">';
			echo $this->displayHelp();
			echo '</div></td></tr></table>';
		} else {
			parent::display();
		}
		// reset the form fields after the form was displayed
		$model = &$this->getModel( $this->_sTask, '', $this->_parameters );
		$model->resetFormFields();
	}

	// function to set the text added to a combobox
	// 1 - Select...
	// 2 - All
	function setSelectText( $addSelect = 1 ) {
		$txtSelect = '';
		switch($addSelect) {
			case 1:
				$txtSelect = JText::_( 'Select ...' );
				break;
			case 2:
				$txtSelect = JText::_( 'All' );
				break;
			case 3:
				$txtSelect = JText::_( '- root -' );
				break;
			case 4:
				$txtSelect = JText::_( '- none -' );
				break;
			case 5:
				$txtSelect = JText::_( 'Default' );
				break;
			case 6:
				$txtSelect = JText::_( 'Always' );
				break;
		}
		return $txtSelect;
	}

	// function to generate the html code to select a status
	function selectStatus( $id = 0, $html_name = 'select_status', $addSelect = 1, $onlyPublished = 0, $html_params = 'class="inputbox" size="1"', $key = 'id', $text = 'name', $idtag = false, $translate = true ) {
		$db = & JFactory::getDBO();
		$query_condition = '';
		if ($onlyPublished) {
			$query_condition = ' where published = 1 ';
		}
		$query = 'SELECT name as ' . $text . ', id as ' . $key . ' FROM #__aicontactsafe_statuses ' . $query_condition . ' ORDER BY ordering';
		$db->setQuery($query);
		$select_combo = $db->loadObjectList();
		if ($addSelect > 0) {
			$txtSelect = new stdClass;
			$txtSelect->$text = $this->setSelectText($addSelect);
			$txtSelect->$key = 0;
			array_unshift($select_combo, $txtSelect);
		}
		$html_select_combo = JHTML::_('select.genericlist',  $select_combo, $html_name, $html_params, $key, $text, $id, $idtag, $translate);

		return $html_select_combo;
	}

	// function to generate the html code to select a field
	function selectField( $id = 0, $html_name = 'select_field', $addSelect = 1, $onlyPublished = 0, $html_params = 'class="inputbox" size="1"', $key = 'id', $text = 'name', $idtag = false, $translate = true ) {
		$db = & JFactory::getDBO();
		$query_condition = '';
		if ($onlyPublished) {
			$query_condition = ' where published = 1 ';
		}
		$query = 'SELECT concat(name,\' - \',field_label) as ' . $text . ', id as ' . $key . ' FROM #__aicontactsafe_fields ' . $query_condition . ' ORDER BY '.$text;
		$db->setQuery($query);
		$select_combo = $db->loadObjectList();
		if ($addSelect > 0) {
			$txtSelect = new stdClass;
			$txtSelect->$text = $this->setSelectText($addSelect);
			$txtSelect->$key = 0;
			array_unshift($select_combo, $txtSelect);
		}
		$html_select_combo = JHTML::_('select.genericlist',  $select_combo, $html_name, $html_params, $key, $text, $id, $idtag, $translate);

		return $html_select_combo;
	}

	// function to generate the header of the template to display
	function getTmplHeader() {
		$header = '<form action="index.php" method="post" name="adminForm">';
		return $header;
	}

	// function to generate the footer of the template to display
	function getTmplFooter() {
		$footer = '';
		switch(true) {
			case $this->_task == 'add' or $this->_task == 'edit' :
				$footer .= '<input type="hidden" id="option" name="option" value="com_aicontactsafe" />';
				$footer .= '<input type="hidden" id="sTask" name="sTask" value="' . $this->_sTask . '" />';
				$footer .= '<input type="hidden" id="task" name="task" value="save" />';
				$footer .= '<input type="hidden" id="last_task" name="last_task" value="' . $this->_task . '" />';
				$footer .= '<input type="hidden" id="id" name="id" value="' . $this->id . '" />';
				$footer .= JHTML::_( 'form.token' );
				$footer .= '</form>';
				break;
			case $this->_task == 'delete' :
				$footer .= '<input type="hidden" id="option" name="option" value="com_aicontactsafe" />';
				$footer .= '<input type="hidden" id="sTask" name="sTask" value="' . $this->_sTask . '" />';
				$footer .= '<input type="hidden" id="task" name="task" value="save" />';
				$footer .= '<input type="hidden" id="last_task" name="last_task" value="' . $this->_task . '" />';
				$footer .= '<input type="hidden" id="boxchecked" name="boxchecked" value="0" />';
				$footer .= JHTML::_( 'form.token' );
				$footer .= '</form>';
				break;
			case $this->_task == 'display' :
			default:
				$footer .= '<input type="hidden" id="option" name="option" value="com_aicontactsafe" />';
				$footer .= '<input type="hidden" id="sTask" name="sTask" value="' . $this->_sTask . '" />';
				$footer .= '<input type="hidden" id="task" name="task" value="' . $this->_task . '" />';
				$footer .= '<input type="hidden" id="last_task" name="last_task" value="' . $this->_task . '" />';
				$footer .= '<input type="hidden" id="boxchecked" name="boxchecked" value="0" />';
				$footer .= '<input type="hidden" id="filter_order" name="filter_order" value="' . $this->filter_order . '" />';
				$footer .= '<input type="hidden" id="filter_order_Dir" name="filter_order_Dir" value="" />';
				$Itemid = JRequest::getInt( 'Itemid' );
				$footer .= '<input type="hidden" id="Itemid" name="Itemid" value="'.$Itemid.'" />';
				$footer .= JHTML::_( 'form.token' );
				$footer .= '</form>';
				break;
		}

		return $footer;
	}

	// function to generate the help instructions displayed with the aiContactSafe main content
	function displayHelp() {
		// load the help language
		$language =& JFactory::getLanguage();
		$language->load('com_aicontactsafe.help');

		$help_header = JPATH_COMPONENT.DS.'includes'.DS.'help'.DS.'header.php';
		if ( file_exists($help_header) ) {
			include($help_header);
		}
		$help_file = JPATH_COMPONENT.DS.'includes'.DS.'help'.DS.'help_'.$this->_help_id.'.php';
		if ( file_exists($help_file) ) {
			include($help_file);
		} else {
			$help_file = JPATH_COMPONENT.DS.'includes'.DS.'help'.DS.'help_0.php';
			if ( file_exists($help_file) ) {
				include($help_file);
			}
		}
		$help_footer = JPATH_COMPONENT.DS.'includes'.DS.'help'.DS.'footer.php';
		if ( file_exists($help_footer) ) {
			include($help_footer);
		}
		echo '<br /><div style="margin-left:auto; margin-right:auto; width:120px; height:90px;"><iframe src="http://www.algisinfo.com/donate/" style="width:120px; height:90px; border:0px solid #FFFFFF;"><a href="http://www.algisinfo.com/donate/" target="_blank">You can help us</a></iframe></div>';
	}

	// function to revert the special chars encoding
	function revert_specialchars( $source_string = '' ) {
		$source_string = str_replace('&quot;','"',$source_string);
		$source_string = str_replace('&#039;','\'',$source_string);
		$source_string = str_replace('&lt;','<',$source_string);
		$source_string = str_replace('&gt;','>',$source_string);
		return $source_string;
	}

}

?>
