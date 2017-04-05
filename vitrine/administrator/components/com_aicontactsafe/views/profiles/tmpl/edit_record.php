<?php
/**
 * @version     $Id$ 2.0.10 b
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * added/fixed in version 2.0.10.b
 * - added buttons to edit the contact information, profile's CSS and email template into the edit profile window
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

<script type="text/javascript" language="javascript">
	function checkFields() {
		all = document.getElementById('all_fields').checked;
		var count_fields = document.getElementById('select_fields_count').value;
		for (i = 0; i < count_fields; i++) {
			if ( document.getElementById('select_field_'+i) ) {
				if ( all ) {
					$('select_field_'+i).setProperty('checked', false);
				}
				$('select_field_'+i).setProperty('disabled', all);
			}
		}
		if ( document.getElementById('select_all') ) {
			$('select_all').setProperty('disabled', all);
		}
		if ( document.getElementById('select_none') ) {
			$('select_none').setProperty('disabled', all);
		}
	}
	function changeAll( checked ) {
		var count_fields = document.getElementById('select_fields_count').value;
		for (i = 0; i < count_fields; i++) {
			if ( document.getElementById('select_field_'+i) ) {
				$('select_field_'+i).setProperty('checked', checked);
			}
		}
	}
	function sortAll() {
		var count_fields = document.getElementById('select_fields_count').value;
		var fields = new Array();
		for (i = 0; i < count_fields; i++) {
			fields[i] = pad(parseInt($('order_field_'+i).value),10)+':'+i;
		}
		fields.sort();
		for (i = 0; i < count_fields; i++) {
			var j = parseInt(fields[i].substr(11));
			var up_link = '<a class="up_order_fields" href="javascript:void(0);" onclick="moveRow( -1, '+j+' )"><img border="0" src="<?php echo JURI::root(); ?>administrator/components/com_aicontactsafe/images/uparrow.png" /></a>';
			var down_link = '<a class="up_order_fields" href="javascript:void(0);" onclick="moveRow( 1, '+j+' )"><img border="0" src="<?php echo JURI::root(); ?>administrator/components/com_aicontactsafe/images/downarrow.png" /></a>';
			var fld = $('field_'+j);
			$('field_'+j).remove();
			$('select_fields_tbody').adopt(fld);
			switch(true) {
				case i == 0:
					$('up_order_fields_'+j).setHTML('&nbsp;');
					$('down_order_fields_'+j).setHTML(down_link);
					break;
				case i == count_fields - 1:
					$('up_order_fields_'+j).setHTML(up_link);
					$('down_order_fields_'+j).setHTML('&nbsp;');
					break;
				default:
					$('up_order_fields_'+j).setHTML(up_link);
					$('down_order_fields_'+j).setHTML(down_link);
			}
			$('order_field_'+j).value = i+1;
		}
		var fld = $('fields_bottom');
		$('fields_bottom').remove();
		$('select_fields_tbody').adopt(fld);
		var fld = $('fields_buttons');
		$('fields_buttons').remove();
		$('select_fields_tbody').adopt(fld);
	}
	function pad(number, length) {
		var str = '' + number;
		while (str.length < length) {
			str = '0' + str;
		}
		return str;
	}
	function moveRow( move, row_id ) {
		var current_order = parseInt($('order_field_'+row_id).value);
		var moved_order = current_order + move;
		var count_fields = document.getElementById('select_fields_count').value;
		for (i = 0; i < count_fields; i++) {
			if ($('order_field_'+i).value == moved_order) {
				$('order_field_'+i).value = current_order;
			}
		}
		$('order_field_'+row_id).value = moved_order;
		sortAll();
	}
	function reset_notification() {
		$('required_field_notification').value='Fields marked with %mark% are required.';
	}
</script>

<fieldset class="adminform">
	<legend><?php echo JText::_( 'Profile' ); ?></legend>
	<table id="profile">
		<tr>
			<td class="key">
				<?php echo JText::_( 'Profile name' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="name" id="name" value="<?php echo $this->name;?>" />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<?php if ($this->_id) { ?>
		<tr>
			<td class="key">
				&nbsp;
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
            	<table id="edit_other_fields">
                	<tr>
						<td>
							<a class="edit_other_fields" href="index.php?option=com_aicontactsafe&sTask=profiles&task=edit_contact&id=<?php echo $this->_id; ?>">
								<div class="edit_other_fields" style="text-align:center">
									<img class="edit_other_fields" border="0" src="components/com_aicontactsafe/images/contact.gif" /><br />
									<?php echo JText::_( 'Edit contact' ); ?>
								</div>
							</a>
						</td>
						<td>&nbsp;</td>
						<td>
							<a class="edit_other_fields" href="index.php?option=com_aicontactsafe&sTask=profiles&task=edit_css&id=<?php echo $this->_id; ?>">
								<div class="edit_other_fields" style="text-align:center">
									<img class="edit_other_fields" border="0" src="components/com_aicontactsafe/images/css.gif" /><br />
									<?php echo JText::_( 'Edit CSS' ); ?>
								</div>
							</a>
						</td>
						<td>&nbsp;</td>
						<td>
							<a class="edit_other_fields" href="index.php?option=com_aicontactsafe&sTask=profiles&task=edit_email&id=<?php echo $this->_id; ?>">
								<div class="edit_other_fields" style="text-align:center">
									<img class="edit_other_fields" border="0" src="components/com_aicontactsafe/images/email.gif" /><br />
									<?php echo JText::_( 'Edit email' ); ?>
								</div>
							</a>
						</td>
					</tr>
                </table>
            </td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<?php } ?>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Field used as name' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboField_name; ?>&nbsp;<?php echo $this->selected_fields_info; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Field used as email' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboField_email; ?>&nbsp;<?php echo $this->selected_fields_info; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Field used as subject' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboField_subject; ?>&nbsp;<?php echo $this->selected_fields_info; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Field used as send to sender' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboField_send_to_sender; ?>&nbsp;<?php echo $this->selected_fields_info; ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Use AJAX to submit the form' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="use_ajax" id="use_ajax" value="1" <?php echo ($this->use_ajax)?'checked="checked"':''; ?>  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Contact form width' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="contact_form_width" id="contact_form_width" value="<?php echo $this->contact_form_width;?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Space after a row' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="bottom_row_space" id="bottom_row_space" value="<?php echo $this->bottom_row_space;?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Align buttons' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboAlignButtons; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Contact information width' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="contact_info_width" id="contact_info_width" value="<?php echo $this->contact_info_width;?>" />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Use security code (captcha) in frontend' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboUseCaptcha; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Select the type of CAPTCHA to use' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboTypeOfCaptcha; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Align captcha' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboAlignCaptcha; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Captcha width' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="captcha_width" id="captcha_width" value="<?php echo $this->captcha_width;?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Captcha height' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="captcha_height" id="captcha_height" value="<?php echo $this->captcha_height;?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Captcha background color' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="captcha_bgcolor" id="captcha_bgcolor" value="<?php echo $this->captcha_bgcolor;?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Captcha background transparent' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="checkbox" name="captcha_backgroundTransparent" id="captcha_backgroundTransparent" value="1" <?php echo $this->captcha_backgroundTransparent?'checked="checked"':''; ?> />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Captcha colors' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="captcha_colors" id="captcha_colors" value="<?php echo $this->captcha_colors;?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Use random letters for the CAPTCHA code' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="use_random_letters" id="use_random_letters" value="1" <?php echo ($this->use_random_letters)?'checked="checked"':''; ?>  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Mininum word length' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="min_word_length" id="min_word_length" value="<?php echo $this->min_word_length; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Maximum word length' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="max_word_length" id="max_word_length" value="<?php echo $this->max_word_length; ?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Email address' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="email_address" id="email_address" value="<?php echo $this->email_address; ?>"  />&nbsp;<?php echo JHTML::_('tooltip', JText::_( "Leave blank to use the default one in joomla" )); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Always send to this email address' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="always_send_to_email_address" id="always_send_to_email_address" value="1" <?php echo ($this->always_send_to_email_address)?'checked="checked"':''; ?>  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Email subject prefix' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="subject_prefix" id="subject_prefix" value="<?php echo $this->subject_prefix; ?>"  />&nbsp;<?php echo JHTML::_('tooltip', JText::_( "Leave blank to use the site name" )); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Email mode' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboEmail_mode; ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Record the messages in the database' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="record_message" id="record_message" value="1" <?php echo ($this->record_message)?'checked="checked"':''; ?>  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Record the fields of the message separately in the database' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="record_fields" id="record_fields" value="1" <?php echo ($this->record_fields)?'checked="checked"':''; ?>  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Custom field date format' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboField_custom_date_format; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Number of years to go back' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="custom_date_years_back" id="custom_date_years_back" value="<?php echo $this->custom_date_years_back; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Number of years to go forward' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="custom_date_years_forward" id="custom_date_years_forward" value="<?php echo $this->custom_date_years_forward; ?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Mark required fields character' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="required_field_mark" id="required_field_mark" value="<?php echo $this->required_field_mark; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Required fields notification' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="required_field_notification" id="required_field_notification" value="<?php echo $this->required_field_notification; ?>"  />
				&nbsp;
				<input class="button" type="button" name="notification_reset" id="notification_reset" value="<?php echo JText::_( 'Reset' ); ?>" onclick="reset_notification();" />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Meta description' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<textarea name="meta_description" id="meta_description" cols="60" rows="6"><?php echo $this->meta_description; ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Meta keywords' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<textarea name="meta_keywords" id="meta_keywords" cols="60" rows="6"><?php echo $this->meta_keywords; ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Meta robots' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<textarea name="meta_robots" id="meta_robots" cols="60" rows="6"><?php echo $this->meta_robots; ?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Thank you message' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="thank_you_message" id="thank_you_message" value="<?php echo $this->thank_you_message; ?>"  />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Redirect on succes URL' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="textbox" type="text" name="redirect_on_success" id="redirect_on_success" value="<?php echo $this->redirect_on_success; ?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Default message status' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboDefaultStatus; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Message status after read' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboReadStatus; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Message status after reply' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<?php echo $this->comboReplyStatus; ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Default' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="set_default" id="set_default" value="1" <?php echo ($this->set_default)?'checked="checked"':'' ?> />
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Published' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<input class="checkbox" type="checkbox" name="published" id="published" value="1" <?php echo ($this->published)?'checked="checked"':'' ?> />
			</td>
		</tr>
		<tr>
			<td colspan="3" class="space">&nbsp;</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Fields' ); ?>:
			</td>
			<td class="space">&nbsp;</td>
			<td class="value">
				<table id="select_fields_table" border="0" cellpadding="0" cellspacing="0">
					<tbody id="select_fields_tbody">
						<tr>
							<td><?php echo JText::_( 'All' ); ?></td>
							<td>&nbsp;</td>
							<td><input type="checkbox" name="all_fields" class="select_fields" id="all_fields" value="1" <?php echo ($this->all_fields)?'checked="checked"':'' ?> onclick="checkFields()" /></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr id="fields_top">
							<td colspan="3">&nbsp;</td>
						</tr>
						<?php
						$i_poz = 0;
						$no_poz = count($this->select_fields);
						foreach($this->select_fields as $i=>$field) {
							$i_poz += 1;
						?>
						<tr id="field_<?php echo $i; ?>">
							<td><?php echo $field['name'] . ((strlen(trim($field['field_label'])) > 0)?' - ' . $field['field_label']:''); ?></td>
							<td>&nbsp;</td>
							<td><input type="checkbox" name="select_fields[]" class="select_fields" id="select_field_<?php echo $i; ?>" value="<?php echo $field['id']; ?>" <?php echo (($field['selected'])?'checked="checked"':'') ?> /></td>
							<td>&nbsp;</td>
							<td>
								<table border="0" cellpadding="2" cellspacing="0">
									<tr id="order_row_<?php echo $i; ?>">
										<td class="sep_order_fields">
											<input type="text" name="order_field_<?php echo $i; ?>" class="order_fields" id="order_field_<?php echo $i; ?>" value="<?php echo $i_poz; ?>" style="width:30px !important; text-align:right !important;" />
											<input type="hidden" name="order_field_id_<?php echo $i; ?>" class="order_fields_id" id="order_field_id_<?php echo $i; ?>" value="<?php echo $field['id']; ?>" />
										</td>
										<td class="up_order_fields" id="up_order_fields_<?php echo $i; ?>">
											<?php if( $i_poz > 1 ) { ?>
											<a class="up_order_fields" href="javascript:void(0);" onclick="moveRow( -1, <?php echo $i; ?> )"><img border="0" src="<?php echo JURI::root(); ?>administrator/components/com_aicontactsafe/images/uparrow.png" /></a>
											<?php } else { echo '&nbsp;'; } ?>
										</td>
										<td class="down_order_fields" id="down_order_fields_<?php echo $i; ?>">
											<?php if( $i_poz < $no_poz ) { ?>
											<a class="down_order_fields" href="javascript:void(0);" onclick="moveRow( 1, <?php echo $i; ?> )"><img border="0" src="<?php echo JURI::root(); ?>administrator/components/com_aicontactsafe/images/downarrow.png" /></a>
											<?php } else { echo '&nbsp;'; } ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php } ?>
						<tr id="fields_bottom">
							<td colspan="5">&nbsp;</td>
						</tr>
						<tr id="fields_buttons">
							<td colspan="3" align="right">
								<input type="button" name="select_all" id="select_all" value="<?php echo JText::_( 'Select all' ); ?>" onClick="changeAll(true)" />
								&nbsp;&nbsp;&nbsp;
								<input type="button" name="select_none" id="select_none" value="<?php echo JText::_( 'Select none' ); ?>" onClick="changeAll(false)" />					
							</td>
							<td>&nbsp;</td>
							<td><input type="button" name="sort_all" id="sort_all" value="<?php echo JText::_( 'Sort all' ); ?>" onClick="sortAll()" /></td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" value="<?php echo count($this->select_fields); ?>" id="select_fields_count" name="select_fields_count" />
			</td>
		</tr>
	</table>
</fieldset>

<script type="text/javascript" language="javascript">
	checkFields();
</script>
	
<?php 
	// footer of the adminForm
	// don't remove this line
	echo $this->getTmplFooter();
?>
