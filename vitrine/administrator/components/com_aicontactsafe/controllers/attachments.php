<?php
/**
 * @version     $Id$ 2.0.7 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// define the default aiContactSafe controller class
class AiContactSafeControllerAttachments extends AiContactSafeController {

	// function to delete one or more attached files
	function delete() {
		$model = &$this->getModel( $this->_sTaskModel, '', $this->_parameters );
		$model->delete();
		$link = $model->getReturnLink();
		$msg = JText::_('Attachments deleted !');
		$msgType = 'message';
		$this->setRedirect($link, $msg, $msgType);
	}

}

?>
