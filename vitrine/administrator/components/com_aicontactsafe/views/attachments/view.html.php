<?php
/**
 * @version     $Id$ 2.0.7 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// define the about view class of aiContactSafe
class AiContactSafeViewAttachments extends AiContactSafeViewDefault {

	// construct function, it will iniaize the class variables
	function __construct( $default = array() )	{
		$this->_help_id = 'attachments';

		parent::__construct( $default );
	}

	// deactivate the buttons on this page
	function setToolbarButtons() {
		switch(true) {
			case $this->_task == 'delete' :
				JToolBarHelper::custom( 'confirmDelete',  'apply_ai.png', 'apply_ai.png', JText::_( 'Confirm' ), true,  false );
				JToolBarHelper::custom( 'cancel', 'cancel_ai.gif', 'cancel_ai.gif', JText::_( 'Cancel' ), false,  false );
				break;
			case $this->_task == 'display' :
				JToolBarHelper::custom( 'delete', 'delete_ai.gif', 'delete_ai.gif', JText::_( 'Delete' ), true,  false );
				break;
		}
	}

	// function to initialize the variables used in the template
	function setVariables() {
		$model = &$this->getModel();

		$this->filter_order = $model->filter_order;
		$this->filter_order_Dir = $model->filter_order_Dir;
		$this->limit = $model->limit;
		$this->limitstart = $model->limitstart;
		$this->filter_condition = $model->filter_condition;
		$this->filter_string = $model->filter_string;

		$this->rows = $model->getAttachments();
		$this->pageNav = $model->pageNav;

		$script = "
			//<![CDATA[
			<!--
				function submitbutton(pressbutton) {
					if(confirm('".JText::_( 'Please confirm you want to delete the selected files!' )."')){
						document.adminForm.task.value=pressbutton;
						submitform(pressbutton);
					}
				}
			//-->
			//]]>
		";
		$document =& JFactory::getDocument();
		$document->addScriptDeclaration($script);


	}

}

?>