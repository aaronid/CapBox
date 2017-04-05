<?php
/**
 * @version     $Id$ 2.0.12 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * added/fixed in version 2.0.1
 * - added custom field date format
 * - added mark_required_fields character
 * - added always_send_to_defaut
 * - added Artio activation
 * - added Joom!Fish activation
 * - removed all the fields moved to profile
 * added/fixed in version 2.0.8
 * - renamed the button to delete all the tables into the database to be more obvious 
 * - added a test for the GD library used by CAPTCHA
 * added/fixed in version 2.0.12
 * - removed the field to identify the user, the user is indetified by the log-in process
 *
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
	<legend><?php echo JText::_( 'Control Panel' ); ?></legend>
	<table id="control_panel">
		<?php
			if ( count($this->withoutMessageSection) > 0 ) {
		?>
		<tr>
			<td class="key">
				<h3 style="color:#FF0000"><?php echo JText::_( 'Warning' ); ?></h3>
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<table border="0" cellpadding="0" cellspacing="0" style="color:#FF0000">
				<?php
					foreach($this->withoutMessageSection as $template) {
				?>
					<tr><td style="color:#333333; font-weight:bold;"><?php echo $template; ?></td><td>&nbsp;&nbsp;</td><td><?php echo JText::_( 'this template doesn\'t have the section message activated' ); ?></td></tr>
				<?php
					}
				?>
					<tr><td colspan="3">&nbsp;</td></tr>
					<tr><td colspan="3"><?php echo JText::_( 'If a template doesn\'t have the section message activated you can\'t see the component feedback in front end.' ); ?></td></tr>
					<tr><td colspan="3"><?php echo JText::_( 'You need to add this text' ); ?>&nbsp;&lt;jdoc:include type="message" /&gt;&nbsp;<?php echo JText::_( 'somewhere above this text' ); ?>&nbsp;&lt;jdoc:include type="component" /&gt;&nbsp;<?php echo JText::_( 'in the index.php file of the template.' ); ?></td></tr>
					<tr><td colspan="3"><?php echo JText::_( 'For more information see this web page' ); ?> : <a href="http://docs.joomla.org/Jdoc_statements" target="_blank">http://docs.joomla.org/Jdoc_statements</a></td></tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<?php
			}
		?>
		<tr>
			<td class="key">
				<?php echo JText::_( 'GD Library' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php
					if (count($this->gd) > 0) {
						echo '<span style="color:#009900">' . $this->gd['GD Version'] . '</span> ';
						if ($this->gd['FreeType Support']) {
							echo '<span style="color:#009900">' . JText::_( 'with' );
						} else {
							echo '<span style="color:#FF0000">' . JText::_( 'without' );
						}
						echo ' ' . JText::_( 'FreeType Support' ) . '</span>';
					} else {
						echo '<span style="color:#FF0000">' . JText::_( 'Not installed' ) . '</span>';
					}
				?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Use aiContactSafe css in backend' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="use_css_backend" id="use_css_backend" value="1" <?php echo ($this->use_css_backend)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Activate help' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="activate_help" id="activate_help" value="1" <?php echo ($this->activate_help)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Date format' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="date_format" id="date_format" value="<?php echo $this->date_format; ?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Default status filter' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->select_default_status_filter; ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Default Editbox Cols' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="editbox_cols" id="editbox_cols" value="<?php echo $this->editbox_cols; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Default Editbox Rows' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="editbox_rows" id="editbox_rows" value="<?php echo $this->editbox_rows; ?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Default name' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="default_name" id="default_name" value="<?php echo $this->default_name; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Default email' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="default_email" id="default_email" value="<?php echo $this->default_email; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Default subject' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="default_subject" id="default_subject" value="<?php echo $this->default_subject; ?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Activate spam control' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="activate_spam_control" id="activate_spam_control" value="1" <?php echo ($this->activate_spam_control)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Block messages with' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<textarea class="inputbox" name="block_words" id="block_words" rows="6" cols="50"><?php echo $this->block_words; ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Record blocked messages' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="record_blocked_messages" id="record_blocked_messages" value="1" <?php echo ($this->record_blocked_messages)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Activate IP ban' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="activate_ip_ban" id="activate_ip_ban" value="1" <?php echo ($this->activate_ip_ban)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'IPs to ban' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<textarea class="inputbox" name="ban_ips" id="ban_ips" rows="6" cols="50"><?php echo $this->ban_ips; ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Redirect banned IPs to' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="redirect_ips" id="redirect_ips" value="<?php echo $this->redirect_ips; ?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Ban IPs sending messages with blocked words' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="ban_ips_blocked_words" id="ban_ips_blocked_words" value="1" <?php echo ($this->ban_ips_blocked_words)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Maximum blocked messages before IP ban' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="maximum_messages_ban_ip" id="maximum_messages_ban_ip" value="<?php echo $this->maximum_messages_ban_ip; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Minutes to count the blocked messages' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="maximum_minutes_ban_ip" id="maximum_minutes_ban_ip" value="<?php echo $this->maximum_minutes_ban_ip; ?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Email to notify IP ban' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="email_ban_ip" id="email_ban_ip" value="<?php echo $this->email_ban_ip; ?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Set the sender to the default Joomla email address' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="set_sender_joomla" id="set_sender_joomla" value="1" <?php echo ($this->set_sender_joomla)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Upload attachments folder' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo JPATH_ROOT.DS; ?><input class="textbox" type="text" name="upload_attachments" id="upload_attachments" value="<?php echo $this->upload_attachments; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Maximum attachments size (in bytes)' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="maximum_size" id="maximum_size" value="<?php echo $this->maximum_size; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Allowed attachments types' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="attachments_types" id="attachments_types" value="<?php echo $this->attachments_types; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Attach to email' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="attach_to_email" id="attach_to_email" value="1" <?php echo ($this->attach_to_email)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Delete files after the message is sent' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="delete_after_sent" id="delete_after_sent" value="1" <?php echo ($this->delete_after_sent)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Check language files' ); ?>
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<button onclick="document.getElementById('task').value='check_language';this.form.submit();"><?php echo JText::_( 'Check' ); ?></button>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Activate Artio' ); ?>
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->activate_artio; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Activate Joom!Fish' ); ?>
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->activate_joomfish; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				aiContactSafeModule
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->aiContactSafeModule_button; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				aiContactSafeForm
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->aiContactSafeForm_button; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				aiContactSafeLink
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->aiContactSafeLink_button; ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Messages in front end can be seen by' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->gid_list; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Users can see all messages' ); ?>
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="users_all_messages" id="users_all_messages" value="1" <?php echo ($this->users_all_messages)?'checked':'' ?> />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">&nbsp;
				
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<button onclick="document.getElementById('task').value='confirm_delete_all';this.form.submit();" style="color:#FF0000;"><?php echo JText::_( 'Delete database tables' ); ?></button>&nbsp;&nbsp;&nbsp;<font color="#FF0000"><?php echo JText::_( 'DO_NOT_USE' ); ?></font>
			</td>
		</tr>
	</table>
</fieldset>

<?php 
	// footer of the adminForm
	// don't remove this line
	echo $this->getTmplFooter();
?>
