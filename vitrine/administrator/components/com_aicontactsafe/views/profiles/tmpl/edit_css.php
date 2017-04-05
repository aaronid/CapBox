<?php
/**
 * @version     $Id$ 2.0.9 0
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

<script type="text/javascript" language="javascript">
	function setProfileCSS(css_type) {
		var id = document.getElementById('id').value;
		var url = '<?php echo JURI::base(); ?>index.php?option=com_aicontactsafe&sTask=profiles&task=setcss&id='+id+'&css_type='+css_type+'&format=raw';

		new Ajax(url, {
			method: 'get',
			onRequest: function(){ $('wait_for_css_change').setHTML('<?php echo JText::_( 'Please wait ...') . '&nbsp;&nbsp;<img id="imgLoading" border="0" src="'.JURI::root().'administrator/components/com_aicontactsafe/images/load.gif" />&nbsp;&nbsp;'; ?>'); },
			onComplete: function(){ $('profile_css_code').value=this.response.text;$('wait_for_css_change').setHTML('&nbsp;'); }
		}).request();
	}
</script>

<fieldset class="adminform">
	<legend><?php echo JText::_( 'Edit the CSS of the profile' ); ?></legend>
	<table id="edit_css">
		<tr>
			<td class="key">
				<?php echo JText::_( 'Use aiContactSafe CSS in frontend' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="use_message_css" id="use_message_css" value="1" <?php echo ($this->use_message_css)?'checked="checked"':''; ?>  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Align label and fields' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<table border="0" id="aiContactSafe_align_label_and_fields" border="0" cellpadding="0" cellspacing="2">
					<tr>
						<td><a href="javascript:void(0);" onclick="setProfileCSS('align_margin');"><img src="<?php echo JURI::root().'administrator/components/com_aicontactsafe/images/align_margin.gif'; ?>" border="0" alt="<?php echo JText::_( 'To margin' ); ?>" title="<?php echo JText::_( 'To margin' ); ?>" /></a></td>
						<td><a href="javascript:void(0);" onclick="setProfileCSS('align_center');"><img src="<?php echo JURI::root().'administrator/components/com_aicontactsafe/images/align_center.gif'; ?>" border="0" alt="<?php echo JText::_( 'To center' ); ?>" title="<?php echo JText::_( 'To center' ); ?>" /></a></td>
						<td><a href="javascript:void(0);" onclick="setProfileCSS('align_left');"><img src="<?php echo JURI::root().'administrator/components/com_aicontactsafe/images/align_left.gif'; ?>" border="0" alt="<?php echo JText::_( 'To left' ); ?>" title="<?php echo JText::_( 'To left' ); ?>" /></a></td>
						<td><a href="javascript:void(0);" onclick="setProfileCSS('align_right');"><img src="<?php echo JURI::root().'administrator/components/com_aicontactsafe/images/align_right.gif'; ?>" border="0" alt="<?php echo JText::_( 'To right' ); ?>" title="<?php echo JText::_( 'To right' ); ?>" /></a></td>
						<td><a href="javascript:void(0);" onclick="setProfileCSS('align_all_left');"><img src="<?php echo JURI::root().'administrator/components/com_aicontactsafe/images/align_all_left.gif'; ?>" border="0" alt="<?php echo JText::_( 'All left' ); ?>" title="<?php echo JText::_( 'All left' ); ?>" /></a></td>
						<td><a href="javascript:void(0);" onclick="setProfileCSS('align_all_right');"><img src="<?php echo JURI::root().'administrator/components/com_aicontactsafe/images/align_all_right.gif'; ?>" border="0" alt="<?php echo JText::_( 'All right' ); ?>" title="<?php echo JText::_( 'All right' ); ?>" /></a></td>
						<td><a href="javascript:void(0);" onclick="setProfileCSS('align_all_center');"><img src="<?php echo JURI::root().'administrator/components/com_aicontactsafe/images/align_all_center.gif'; ?>" border="0" alt="<?php echo JText::_( 'All center' ); ?>" title="<?php echo JText::_( 'All center' ); ?>" /></a></td>
						<td><div id="wait_for_css_change">&nbsp;</div></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'CSS code of the profile' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<textarea name="profile_css_code" id="profile_css_code" cols="60" rows="60"><?php echo $this->profile_css_code; ?></textarea>
			</td>
		</tr>
	</table>
</fieldset>

<?php 
	// footer of the adminForm
	// don't remove this line
	echo $this->getTmplFooter();
?>
