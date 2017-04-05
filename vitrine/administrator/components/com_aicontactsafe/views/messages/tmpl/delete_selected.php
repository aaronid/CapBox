<?php
/**
 * @version     $Id$ 2.0.5 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<?php 
	// header of the adminForm
	// don't remove this line
	echo $this->getTmplHeader();
?>

<fieldset class="adminform">
	<legend><?php echo JText::_( 'Delete selected' ); ?></legend>
	<div>
		<?php echo JText::_( 'Please confirm you want to delete selected messages.' ); ?><br />
		<br />
		<font color="#FF0000"><strong><?php echo JText::_( 'Warning !!!' ); ?></strong></font><br />
		<?php echo JText::_( 'You will not be able to restore the deleted messages.' ); ?><br />
		<br />
	</div>
</fieldset>
	
<?php 
	// footer of the adminForm
	// don't remove this line
	echo $this->getTmplFooter();
?>
