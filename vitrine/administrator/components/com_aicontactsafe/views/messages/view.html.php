<?php
/**
 * @version     $Id$ 2.0.0 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// define the messages view class of aiContactSafe
class AiContactSafeViewMessages extends AiContactSafeViewDefault {

	// toolbar to display in front-end
	var $toolbar = null;

	// construct function, it will iniaize the class variables
	function __construct( $default = array() )	{
		switch(true) {
			case $default['_task'] == 'display' :
				$this->_help_id = 'messages_display';
				break;
			case $default['_task'] == 'view' :
				$this->_help_id = 'messages_view';
				break;
			case $default['_task'] == 'delete' :
				$this->_help_id = 'messages_delete';
				break;
			case $default['_task'] == 'ban_ip' :
				$this->_help_id = 'messages_ban_ip';
				break;
			case $default['_task'] == 'reply' :
				$this->_help_id = 'messages_reply';
				break;
			case $default['_task'] == 'export' :
				$this->_help_id = 'messages_export';
				break;
			case $default['_task'] == 'delete_selected' :
				$this->_help_id = 'messages_delete_selected';
				break;
			default :
				$this->_help_id = 'messages_display';
		}

		parent::__construct( $default );
	}

	// function to define the toolbar depending on the section
	function setToolbarButtons() {
		if ($this->_backend) {
			switch(true) {
				case $this->_task == 'view' :
					$model = &$this->getModel();
					if ( !$model->hasReply($this->_id) ) {
						JToolBarHelper::custom( 'reply', 'reply_ai.gif', 'reply_ai.gif', JText::_( 'Reply' ), false,  false );
					}
					JToolBarHelper::custom( 'cancel', 'cancel_ai.gif', 'cancel_ai.gif', JText::_( 'Close' ), false,  false );
					break;
				case $this->_task == 'reply' :
					JToolBarHelper::custom( 'confirmReply',  'apply_ai.png', 'apply_ai.png', JText::_( 'Send' ), false,  false );
					JToolBarHelper::custom( 'cancel', 'cancel_ai.gif', 'cancel_ai.gif', JText::_( 'Cancel' ), false,  false );
					break;
				case $this->_task == 'export' :
					JToolBarHelper::custom( 'cancel', 'cancel_ai.gif', 'cancel_ai.gif', JText::_( 'Close' ), false,  false );
					break;
				case $this->_task == 'delete_selected' :
					JToolBarHelper::custom( 'confirmDeleteSelected',  'apply_ai.png', 'apply_ai.png', JText::_( 'Confirm' ), false,  false );
					JToolBarHelper::custom( 'cancel', 'cancel_ai.gif', 'cancel_ai.gif', JText::_( 'Cancel' ), false,  false );
					break;
				case $this->_task == 'delete' :
					JToolBarHelper::custom( 'confirmDelete',  'apply_ai.png', 'apply_ai.png', JText::_( 'Confirm' ), true,  false );
					JToolBarHelper::custom( 'cancel', 'cancel_ai.gif', 'cancel_ai.gif', JText::_( 'Cancel' ), false,  false );
					break;
				case $this->_task == 'ban_ip' :
					JToolBarHelper::custom( 'confirmBanIp',  'apply_ai.png', 'apply_ai.png', JText::_( 'Confirm' ), true,  false );
					JToolBarHelper::custom( 'cancel', 'cancel_ai.gif', 'cancel_ai.gif', JText::_( 'Cancel' ), false,  false );
					break;
				case $this->_task == 'display' :
					JToolBarHelper::custom( 'view', 'view_ai.gif', 'view_ai.gif', JText::_( 'View' ), true,  false );
					JToolBarHelper::custom( 'reply', 'reply_ai.gif', 'reply_ai.gif', JText::_( 'Reply' ), true,  false );
					JToolBarHelper::custom( 'export', 'export_ai.gif', 'export_ai.gif', JText::_( 'Export' ), false,  false );
					JToolBarHelper::custom( 'delete', 'delete_ai.gif', 'delete_ai.gif', JText::_( 'Delete' ), true,  false );
					JToolBarHelper::custom( 'delete_selected', 'delete_all_ai.gif', 'delete_all_ai.gif', JText::_( 'Delete selected' ), true,  false );
					if ($this->_config_values['activate_ip_ban']) {
						JToolBarHelper::custom( 'ban_ip', 'ban_ip_ai.gif', 'ban_ip_ai.gif', JText::_( 'Ban IP' ), true,  false );
					}
					break;
			}
		} else {
			// load the toolbar class
			jimport('joomla.html.toolbar');

			$bar = new JToolBar( 'icon-32' );
			switch(true) {
				case $this->_task == 'view' :
					$model = &$this->getModel();
					if ( !$model->hasReply($this->_id) ) {
						$bar->appendButton( 'Standard', 'reply_ai', JText::_( 'Reply' ), 'reply', false );
					}
					$bar->appendButton( 'Standard', 'cancel_ai', JText::_( 'Close' ), 'cancel', false );
					break;
				case $this->_task == 'reply' :
					$bar->appendButton( 'Standard', 'apply_ai', JText::_( 'Send' ), 'confirmReply', false );
					$bar->appendButton( 'Standard', 'cancel_ai', JText::_( 'Cancel' ), 'cancel', false );
					break;
				case $this->_task == 'export' :
					$bar->appendButton( 'Standard', 'cancel_ai', JText::_( 'Close' ), 'cancel', false );
					break;
				case $this->_task == 'delete_selected' :
					$bar->appendButton( 'Standard', 'apply_ai', JText::_( 'Confirm' ), 'confirmDeleteSelected', false );
					$bar->appendButton( 'Standard', 'cancel_ai', JText::_( 'Cancel' ), 'cancel', false );
					break;
				case $this->_task == 'delete' :
					$bar->appendButton( 'Standard', 'apply_ai', JText::_( 'Confirm' ), 'confirmDelete', true );
					$bar->appendButton( 'Standard', 'cancel_ai', JText::_( 'Cancel' ), 'cancel', false );
					break;
				case $this->_task == 'ban_ip' :
					$bar->appendButton( 'Standard', 'apply_ai', JText::_( 'Confirm' ), 'confirmBanIp', true );
					$bar->appendButton( 'Standard', 'cancel_ai', JText::_( 'Cancel' ), 'cancel', false );
					break;
				case $this->_task == 'display' :
					$bar->appendButton( 'Standard', 'view_ai', JText::_( 'View' ), 'view', true );
					$bar->appendButton( 'Standard', 'reply_ai', JText::_( 'Reply' ), 'reply', true );
					$bar->appendButton( 'Standard', 'export_ai', JText::_( 'Export' ), 'export', true );
					$bar->appendButton( 'Standard', 'delete_ai', JText::_( 'Delete' ), 'delete', true );
					$bar->appendButton( 'Standard', 'delete_all_ai', JText::_( 'Delete selected' ), 'delete_selected', true );
					if ($this->_config_values['activate_ip_ban']) {
						$bar->appendButton( 'Standard', 'ban_ip_ai', JText::_( 'Ban IP' ), 'ban_ip', true );
					}
					break;
			}
			$this->toolbar = $bar->render();
		}
	}

	// function to initialize the variables used in the template
	function setVariables() {
		$model = &$this->getModel();

		switch(true) {
			// in case a record is viewed initialize the fields
			case $this->_task == 'view' :
				if ($this->_id > 0) {
					$this->setRowData($this->_id);
				}
				$this->profile = $model->getProfileName($this->profile_id);
				// modify the status of the message accordingly
				$model->changeStatusToRead($this->_id);
				break;
			// in case a reply is sent
			case $this->_task == 'reply' :
				if ($this->_id > 0) {
					$this->setRowData($this->_id);
				}
				$this->reply_email_address = $this->email;
				$this->reply_subject = JText::_( 'RE:' ).$this->subject;
				$this->reply_message = '';
				break;
			// in case the messages are exported
			case $this->_task == 'export' :
				$this->format = JRequest::getCmd( 'format', '' );
				if ($this->format == 'raw') {
					$this->_config_values['activate_help'] = false;
				}
				$this->csv_text = $model->generateCSV();
				break;
			// in case selected records are deleted
			case $this->_task == 'delete_selected' :
			// read the ids of the records seleted for deletion
				$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
				JArrayHelper::toInteger($cid);
				if (count($cid) > 0) {
					$cids = implode(',', $cid);
				} else {
					$cids = '-1';
				}
				$this->cids = $cids;
				break;
			// in case one or more records are deleted
			case $this->_task == 'delete' :
				$this->rows = $model->readDeleteRows();
				break;
			// in case one or more records are deleted
			case $this->_task == 'ban_ip' :
				$this->rows = $model->readSelectedIps();
				break;
			// or else initialize the variables to show a list of records
			case $this->_task == 'display' && strlen($this->_sTask) > 0 :
				$this->filter_order = $model->filter_order;
				$this->filter_order_Dir = $model->filter_order_Dir;
				$this->limit = $model->limit;
				$this->limitstart = $model->limitstart;
				$this->filter_condition = $model->filter_condition;
				$this->filter_string = $model->filter_string;
				$this->filter_profile = $this->selectProfile($model->filter_profile, 'filter_profile', 2, 0, 'class="inputbox" size="1" onchange="document.adminForm.submit();"' );
				$this->filter_status = $this->selectStatus($model->filter_status, 'filter_status', 2, 0, 'class="inputbox" size="1" onchange="document.adminForm.submit();"' );
				$this->filter_email = $model->filter_email;
				$this->filter_subject = $model->filter_subject;
				$this->rows = $model->readRows();
				$this->pageNav = $model->pageNav;
				break;
			default :
				// - nothing
		}
	}

	// function to generate the footer of the template to display
	function getTmplFooter() {
		$footer = '';
		$Itemid = JRequest::getInt( 'Itemid' );
		$footer .= '<input type="hidden" id="Itemid" name="Itemid" value="'.$Itemid.'" />';
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
			case $this->_task == 'view' :
				$footer .= '<input type="hidden" id="option" name="option" value="com_aicontactsafe" />';
				$footer .= '<input type="hidden" id="sTask" name="sTask" value="' . $this->_sTask . '" />';
				$footer .= '<input type="hidden" id="task" name="task" value="save" />';
				$footer .= '<input type="hidden" id="last_task" name="last_task" value="' . $this->_task . '" />';
				$footer .= '<input type="hidden" id="boxchecked" name="boxchecked" value="0" />';
				$footer .= '<input type="hidden" id="cb0" name="cid[]" value="' . $this->id . '" selected="selected" />';
				$footer .= JHTML::_( 'form.token' );
				$footer .= '</form>';
				break;
			case $this->_task == 'reply' :
				$footer .= '<input type="hidden" id="option" name="option" value="com_aicontactsafe" />';
				$footer .= '<input type="hidden" id="sTask" name="sTask" value="' . $this->_sTask . '" />';
				$footer .= '<input type="hidden" id="task" name="task" value="save" />';
				$footer .= '<input type="hidden" id="last_task" name="last_task" value="' . $this->_task . '" />';
				$footer .= '<input type="hidden" id="boxchecked" name="boxchecked" value="0" />';
				$footer .= '<input type="hidden" id="id" name="id" value="' . $this->id . '" />';
				$footer .= JHTML::_( 'form.token' );
				$footer .= '</form>';
				break;
			case $this->_task == 'delete_selected' :
				$footer .= '<input type="hidden" id="option" name="option" value="com_aicontactsafe" />';
				$footer .= '<input type="hidden" id="sTask" name="sTask" value="' . $this->_sTask . '" />';
				$footer .= '<input type="hidden" id="task" name="task" value="save" />';
				$footer .= '<input type="hidden" id="last_task" name="last_task" value="' . $this->_task . '" />';
				$footer .= '<input type="hidden" id="boxchecked" name="boxchecked" value="0" />';
				$footer .= '<input type="hidden" id="cids" name="cids" value="' . $this->cids . '" />';
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
				if ( $this->_task == 'display' ) {
					$this->change_status = $this->selectStatus(0, 'new_status', 0 );
					$footer .= '<table id="changeStatus" border="0" cellpadding="0" cellspacing="2">';
					$footer .= '<tr>';
					$footer .= '<td>'.JText::_( 'Change status to' ).'</td>';
					$footer .= '<td>&nbsp;&nbsp;&nbsp;</td>';
					$footer .= '<td>'.$this->change_status.'</td>';
					$footer .= '<td>&nbsp;&nbsp;&nbsp;</td>';
					$footer .= '<td><button onclick="javascript:if (document.adminForm.boxchecked.value == 0){ alert(\''.JText::_( 'Please make a selection from the list').'\');}else{submitbutton(\'changestatus\')}">'.JText::_( 'Go' ).'</button></td>';
					$footer .= '</tr>';
					$footer .= '</table>';
				}
				$footer .= JHTML::_( 'form.token' );
				$footer .= '</form>';
				break;
		}

		return $footer;
	}

	// function to generate the html code to select a profile
	function selectProfile( $id = 0, $html_name = 'select_profile', $addSelect = 1, $onlyPublished = 0, $html_params = 'class="inputbox" size="1"', $key = 'id', $text = 'name', $idtag = false, $translate = true ) {
		$db = & JFactory::getDBO();
		$query_condition = '';
		if ($onlyPublished) {
			$query_condition = ' WHERE published = 1 ';
		}
		$query = 'SELECT name as ' . $text . ', id as ' . $key . ' FROM #__aicontactsafe_profiles ' . $query_condition . ' ORDER BY ' . $text;
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

}

?>
