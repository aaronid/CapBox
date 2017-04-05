<?php
/**
 * @version     $Id$ 2.0.7 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// define the statuses view class of aiContactSafe
class AiContactSafeViewStatuses extends AiContactSafeViewDefault {

	// construct function, it will iniaize the class variables
	function __construct( $default = array() )	{
		switch(true) {
			case $default['_task'] == 'display' :
				$this->_help_id = 'statuses_display';
				break;
			case $default['_task'] == 'add' :
				$this->_help_id = 'statuses_edit';
				break;
			case $default['_task'] == 'edit' :
				$this->_help_id = 'statuses_edit';
				break;
			case $default['_task'] == 'delete' :
				$this->_help_id = 'statuses_delete';
				break;
			default :
				$this->_help_id = 'statuses_display';
		}

		parent::__construct( $default );
	}

	// function to define the toolbar depending on the section
	function setToolbarButtons() {
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
				break;
		}
	}

	// function to initialize the variables used in the template
	function setVariables() {
		parent::setVariables();
		if ( $this->_task == 'add' ) {
			$model = &$this->getModel();
			$this->color = '#000000';
			$this->published = 1;
			$this->ordering = $model->getNextOrdering();
		}
		if ( $this->_task == 'add' or $this->_task == 'edit' ) {
			$document = &JFactory::getDocument();
			$document->addScript( JURI::root().'administrator/components/com_aicontactsafe/includes/fcp/201a.js' );
		}
	}

}

?>
