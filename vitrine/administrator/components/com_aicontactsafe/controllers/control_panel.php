<?php
/**
 * @version     $Id$ 2.0.0 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// define the control_panel controller class of aiContactSafe
class AiContactSafeControllerControl_panel extends AiContactSafeController {

	// get the layout to use - always use the same layout
	function getSTaskLayout($sTask = '') {
		switch(true) {
			// in case a delete for database tables and uploaded files was requested, ask for a confirmation
			case $this->_task == 'confirm_delete_all' :
				$layout = 'confirm_delete_all';
				break;
			// or else use the default layout
			case $this->_task == 'display' :
			default :
				$layout = 'control_panel';
		}
		return $layout;
	}

	// function to get the confirmation message when the data is saved
	function getConfirmationMessage() {
		return JText::_('Configuration saved !');
	}

	// function to delete all tables and files uploaded by aiContactSafe
	function delete_all_accepted() {
		// get the model for the current controller
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		// delete tables and files
		$model->deleteTablesAndFiles();
		// redirect the page after the tables and files were deleted
		$model->resetFormFields();
		$link = 'index.php?option=com_installer&task=manage&type=components';
		$this->setRedirect($link);
	}

	// function to discard all changes and return to the section defined in return_task
	function cancel() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->resetFormFields();
		$new_values = array('sTask'=>'default');
		$link = $model->getReturnLink($new_values);
		$this->setRedirect($link);
	}

	// function to activate aiContactSafe in Artio
	function activate_artio() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->activate_artio();
		$link = $model->getReturnLink();
		$msg = JText::_( 'Artio activated' );
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to deactivate aiContactSafe in Artio
	function deactivate_artio() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->deactivate_artio();
		$link = $model->getReturnLink();
		$msg = JText::_( 'Artio deactivated' );
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to activate aiContactSafe in Joom!Fish
	function activate_joomfish() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->activate_joomfish();
		$link = $model->getReturnLink();
		$msg = JText::_( 'Joom!Fish activated' );
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to deactivate aiContactSafe in Joom!Fish
	function deactivate_joomfish() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->deactivate_joomfish();
		$link = $model->getReturnLink();
		$msg = JText::_( 'Joom!Fish deactivated' );
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to check language files
	function check_language() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$response = $model->check_language();
		$link = $model->getReturnLink();
		$msg = JText::_( 'Language files checked' ).'<br/>'.$response;
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to install aiContactSafeModule
	function installAiContactSafeModule() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		if ($model->installAiContactSafeModule()) {
			$msg = 'aiContactSafeModule '.JText::_( 'installed' );
			$msgType = 'message';
		} else {
			$msg = 'aiContactSafeModule '.JText::_( 'installation failed' );
			$msgType = 'error';
		}
		$link = $model->getReturnLink();
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to uninstall aiContactSafeModule
	function uninstallAiContactSafeModule() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		if ($model->uninstallAiContactSafeModule()){
			$msg = 'aiContactSafeModule '.JText::_( 'uninstalled' );
			$msgType = 'message';
		} else {
			$msg = 'aiContactSafeModule '.JText::_( 'uninstalling failed' );
			$msgType = 'error';
		}
		$link = $model->getReturnLink();
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to reinstall aiContactSafeModule
	function reinstallAiContactSafeModule() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		if ($model->reinstallAiContactSafeModule()){
			$msg = 'aiContactSafeModule '.JText::_( 'upgraded' );
			$msgType = 'message';
		} else {
			$msg = 'aiContactSafeModule '.JText::_( 'upgrade failed' );
			$msgType = 'error';
		}
		$link = $model->getReturnLink();
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to install aiContactSafeForm
	function installAiContactSafeForm() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->installAiContactSafeForm();
		$link = $model->getReturnLink();
		$msg = 'aiContactSafeForm '.JText::_( 'installed' );
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to uninstall aiContactSafeForm
	function uninstallAiContactSafeForm() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->uninstallAiContactSafeForm();
		$link = $model->getReturnLink();
		$msg = 'aiContactSafeForm '.JText::_( 'uninstalled' );
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to reinstall aiContactSafeForm
	function reinstallAiContactSafeForm() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		if ($model->reinstallAiContactSafeForm()){
			$msg = 'aiContactSafeForm '.JText::_( 'upgraded' );
			$msgType = 'message';
		} else {
			$msg = 'aiContactSafeForm '.JText::_( 'upgrade failed' );
			$msgType = 'error';
		}
		$link = $model->getReturnLink();
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to install aiContactSafeLink
	function installAiContactSafeLink() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->installAiContactSafeLink();
		$link = $model->getReturnLink();
		$msg = 'aiContactSafeLink '.JText::_( 'installed' );
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to uninstall aiContactSafeLink
	function uninstallAiContactSafeLink() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->uninstallAiContactSafeLink();
		$link = $model->getReturnLink();
		$msg = 'aiContactSafeLink '.JText::_( 'uninstalled' );
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

	// function to reinstall aiContactSafeLink
	function reinstallAiContactSafeLink() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		if ($model->reinstallAiContactSafeLink()){
			$msg = 'aiContactSafeLink '.JText::_( 'upgraded' );
			$msgType = 'message';
		} else {
			$msg = 'aiContactSafeLink '.JText::_( 'upgrade failed' );
			$msgType = 'error';
		}
		$link = $model->getReturnLink();
		$this->setRedirect($link, $msg, $msgType);
	}

}

?>
