<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<div id="system">
	
	<?php if ($this->params->get('show_page_title')) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_title')); ?></h1>
	<?php endif; ?>

	<p><?php echo JText::_('RESET_PASSWORD_REQUEST_DESCRIPTION'); ?></p>

	<form class="submission small" action="<?php echo JRoute::_('index.php?option=com_user&task=requestreset'); ?>" method="post">
		<fieldset>

			<div>
				<label for="email" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_EMAIL_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_EMAIL_TIP_TEXT'); ?>"><?php echo JText::_('Email Address'); ?>:</label>
				<input id="email" name="email" type="text" class="required validate-email" />
			</div>
			
		</fieldset>
		
		<div>
			<button type="submit"><?php echo JText::_('Submit'); ?></button>
		</div>
		
		<?php echo JHTML::_('form.token'); ?>
	</form>

</div>