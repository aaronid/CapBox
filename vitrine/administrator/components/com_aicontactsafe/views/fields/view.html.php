<?php
/**
 * @version     $Id$ 2.0.1 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * added/fixed in version 2.0.1
 * - added new field types Checkbox - List, Radio - List, Date, Email, Email - List, Joomla Contacts, Joomla Users, Hidden, Separator
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// define the fields view class of aiContactSafe
class AiContactSafeViewFields extends AiContactSafeViewDefault {

	// construct function, it will iniaize the class variables
	function __construct( $default = array() )	{
		switch(true) {
			case $default['_task'] == 'display' :
				$this->_help_id = 'fields_display';
				break;
			case $default['_task'] == 'add' :
				$this->_help_id = 'fields_edit';
				break;
			case $default['_task'] == 'edit' :
				$this->_help_id = 'fields_edit';
				break;
			case $default['_task'] == 'delete' :
				$this->_help_id = 'fields_delete';
				break;
			default :
				$this->_help_id = 'fields_display';
		}

		parent::__construct( $default );
	}

	// function to initialize the variables used in the template
	function setVariables() {
		parent::setVariables();
		if ( $this->_task == 'add' ) {
			$model = &$this->getModel();
			$this->send_message = 1;
			$this->field_in_message = 1;
			$this->published = 1;
			$this->ordering = $model->getNextOrdering();
		}
		if ( $this->_task == 'add' or $this->_task == 'edit' ) {
			// generate the field type combo
			$select_combo = array();
			// textbox - TX
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Textbox' );
			$txtSelect->type = 'TX';
			$select_combo[] = $txtSelect;
			// checkbox - CK
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Checkbox' );
			$txtSelect->type = 'CK';
			$select_combo[] = $txtSelect;
			// combobox - CB
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Combobox' );
			$txtSelect->type = 'CB';
			$select_combo[] = $txtSelect;
			// editbox - ED
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Editbox' );
			$txtSelect->type = 'ED';
			$select_combo[] = $txtSelect;
			// checkbox list - CL
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Checkbox - List' );
			$txtSelect->type = 'CL';
			$select_combo[] = $txtSelect;
			// radio list - RL
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Radio - List' );
			$txtSelect->type = 'RL';
			$select_combo[] = $txtSelect;
			// date - DT
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Date' );
			$txtSelect->type = 'DT';
			$select_combo[] = $txtSelect;
			// email - EM
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Email' );
			$txtSelect->type = 'EM';
			$select_combo[] = $txtSelect;
			// email - EL
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Email - List' );
			$txtSelect->type = 'EL';
			$select_combo[] = $txtSelect;
			// contact - JC
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Joomla Contacts' );
			$txtSelect->type = 'JC';
			$select_combo[] = $txtSelect;
			// contact - JU
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Joomla Users' );
			$txtSelect->type = 'JU';
			$select_combo[] = $txtSelect;
			// contact - SB
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'SOBI2 Entries' );
			$txtSelect->type = 'SB';
			$select_combo[] = $txtSelect;
			// hidden - HD
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Hidden' );
			$txtSelect->type = 'HD';
			$select_combo[] = $txtSelect;
			// hidden - SP
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Separator' );
			$txtSelect->type = 'SP';
			$select_combo[] = $txtSelect;
			// file - FL
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'File' );
			$txtSelect->type = 'FL';
			$select_combo[] = $txtSelect;
			// file - NO
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Number' );
			$txtSelect->type = 'NO';
			$select_combo[] = $txtSelect;
			// file - HE
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Hidden Email' );
			$txtSelect->type = 'HE';
			$select_combo[] = $txtSelect;

			// generate the html tag
			$this->comboField_type = JHTML::_('select.genericlist',  $select_combo, 'field_type', 'class="inputbox" size="1" onchange="checkFieldValues();"', 'type', 'name', $this->field_type, false, false);
	
			$script = "
				function checkFieldValues() {
					var field_type = document.getElementById('field_type').value;
					if (field_type == 'CB' || field_type == 'CL' || field_type == 'RL' || field_type == 'EL' || field_type == 'SB' || field_type == 'HD' || field_type == 'SP' || field_type == 'HE') {
						document.getElementById('field_values').removeAttribute('disabled');
					} else {
						document.getElementById('field_values').value = '';
						document.getElementById('field_values').setAttribute('disabled', true); 
					}
					if (field_type == 'EM' || field_type == 'EL' || field_type == 'JC' || field_type == 'JU' || field_type == 'SB' || field_type == 'SB') {
						document.getElementById('send_message').removeAttribute('disabled');
					} else {
						document.getElementById('send_message').checked = true;
						document.getElementById('send_message').setAttribute('disabled', true); 
					}
				}
				function copyLabel() {
					var field_label_message = document.getElementById('field_label_message').value;
					if ( field_label_message.length == 0 && document.getElementById('id').value == 0 ) {
						document.getElementById('field_label_message').value = document.getElementById('field_label').value;
					}
				}
				function copyParameters() {
					var label_message_parameters = document.getElementById('label_message_parameters').value;
					if ( label_message_parameters.length == 0 && document.getElementById('id').value == 0 ) {
						document.getElementById('label_message_parameters').value = document.getElementById('label_parameters').value;
					}
				}";

			$document =& JFactory::getDocument();
			$document->addScriptDeclaration($script);

			// generate the field type combo
			$select_combo = array();
			// none
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( '- none -' );
			$txtSelect->type = '';
			$select_combo[] = $txtSelect;
			// Joomla User name
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Joomla user name' );
			$txtSelect->type = 'UN';
			$select_combo[] = $txtSelect;
			// Joomla User email
			$txtSelect = new stdClass;
			$txtSelect->name = JText::_( 'Joomla user email' );
			$txtSelect->type = 'UE';
			$select_combo[] = $txtSelect;

			// generate the html tag
			$this->comboAutoFill = JHTML::_('select.genericlist',  $select_combo, 'auto_fill', 'class="inputbox" size="1"', 'type', 'name', $this->auto_fill, false, false);

		}
		if ( $this->_task == 'display' ) {
			$countRows = count($this->rows);
			for ($i = 0; $i<$countRows; $i++) {
				switch($this->rows[$i]->field_type) {
					case 'TX' :
						$this->rows[$i]->field_type_text = JText::_( 'Textbox' );
						break;
					case 'CK' :
						$this->rows[$i]->field_type_text = JText::_( 'Checkbox' );
						break;
					case 'CB' :
						$this->rows[$i]->field_type_text = JText::_( 'Combobox' );
						break;
					case 'ED' :
						$this->rows[$i]->field_type_text = JText::_( 'Editbox' );
						break;
					case 'CL' :
						$this->rows[$i]->field_type_text = JText::_( 'Checkbox - List' );
						break;
					case 'RL' :
						$this->rows[$i]->field_type_text = JText::_( 'Radio - List' );
						break;
					case 'DT' :
						$this->rows[$i]->field_type_text = JText::_( 'Date' );
						break;
					case 'EM' :
						$this->rows[$i]->field_type_text = JText::_( 'Email' );
						break;
					case 'EL' :
						$this->rows[$i]->field_type_text = JText::_( 'Email - List' );
						break;
					case 'JC' :
						$this->rows[$i]->field_type_text = JText::_( 'Joomla Contacts' );
						break;
					case 'JU' :
						$this->rows[$i]->field_type_text = JText::_( 'Joomla Users' );
						break;
					case 'SB' :
						$this->rows[$i]->field_type_text = JText::_( 'SOBI2 Entries' );
						break;
					case 'HD' :
						$this->rows[$i]->field_type_text = JText::_( 'Hidden' );
						break;
					case 'SP' :
						$this->rows[$i]->field_type_text = JText::_( 'Separator' );
						break;
					case 'FL' :
						$this->rows[$i]->field_type_text = JText::_( 'File' );
						break;
					case 'NO' :
						$this->rows[$i]->field_type_text = JText::_( 'Number' );
						break;
					case 'HE' :
						$this->rows[$i]->field_type_text = JText::_( 'Hidden Email' );
						break;
				}
			}
		}
	}

}

?>
