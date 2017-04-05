<?php
/**
 * @version     $Id$ 2.0.10 b
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * added/fixed in version 2.0.10.b
 * - replaced sufix with prefix as it is the correct order
 * - added the posibility to use either fixed or procentual width for the contact form and the contact information ( you can specify it in the profile )
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

function writeContactForm( $_this ) {
?>
	<?php if (!$_this->returnAjaxForm) {
		// header of the adminForm
		// don't remove this line
		echo $_this->getTmplHeader();
		?>
		<div id="displayAiContactSafeForm_<?php echo $_this->profile->id; ?>">
	<?php } ?>
	<?php 
		if ($_this->returnAjaxForm) {
			$doc =& JDocument::getInstance( );
			$renderer =& $doc->loadRenderer( 'message' );
			echo '<div class="error">';
			echo $renderer->render();
			echo '</div>';
			if ($_this->_app->_session->get( 'isOK:' . $_this->_sTask )) {
				$message = $_this->_app->_session->get( 'confirmationMessage:' . $_this->_sTask . '_' . $_this->r_id );
				if (strlen($message) > 0) {
					echo '<input type="hidden" id="ajax_message_sent" name="ajax_message_sent" value="1" />';
				}
			}
		}
	?>
		<div class="aiContactSafe" id="aiContactSafe_contact_form">
		<?php if ($_this->requested_fields) { ?>
		<div class="aiContactSafe" id="aiContactSafe_info"><?php echo $_this->contactinformations['required_field_notification']; ?></div>
		<?php } ?>
		<?php
			foreach($_this->fields as $field) {
				if (is_null($field->html_label)) {
			?>
					<div class="aiContactSafe_row_hidden" id="aiContactSafe_row_<?php echo $field->name; ?>"><div class="aiContactSafe_contact_form_field_right"><?php echo $field->html_tag; ?></div></div>
			<?php
				} else {
					if ($_this->profile->bottom_row_space > 0) {
						$row_space = '<div class="row_space" style="clear:both; height:'.$_this->profile->bottom_row_space.'px; line-height:'.$_this->profile->bottom_row_space.'px;">&nbsp;</div>';
					} else {
						$row_space = '';
					}
					if ($field->label_after_field) {
			?>
						<div class="aiContactSafe_row" id="aiContactSafe_row_<?php echo $field->name; ?>"><div class="aiContactSafe_contact_form_field_left"><?php echo $field->html_tag; ?></div><div class="aiContactSafe_contact_form_field_label_right"><?php echo $field->html_label; ?>&nbsp;<?php echo (($field->field_required)?'<label class="required_field">' . $_this->profile->required_field_mark . '</label>':''); ?></div><?php echo $row_space; ?></div>
			<?php
					} else {
			?>
						<div class="aiContactSafe_row" id="aiContactSafe_row_<?php echo $field->name; ?>"><div class="aiContactSafe_contact_form_field_label_left"><?php echo $field->html_label; ?>&nbsp;<?php echo (($field->field_required)?'<label class="required_field">' . $_this->profile->required_field_mark . '</label>':''); ?></div><div class="aiContactSafe_contact_form_field_right"><?php echo $field->html_tag; ?></div><?php echo $row_space; ?></div>
			<?php
					}
				}
			}
		?>
		</div>
		<?php if ($_this->returnAjaxForm) { ?>
			<br clear="all" />
		<?php } else { ?>
			</div>
			<br clear="all" />
			<?php $_this->writeCaptcha(); ?>
			<br clear="all" />
			<div id="aiContactSafeBtns"><?php echo $_this->buttons; ?></div>
			<br clear="all" />
		<?php
			// footer of the adminForm
			// don't remove this line
			echo $_this->getTmplFooter();
		}
		?>
	<?php
}
?>

<?php if ($this->show_page_title && !$this->returnAjaxForm) { ?>
<div class="componentheading<?php echo $this->pageclass_sfx; ?>"><?php echo $this->page_title; ?></div>
<?php } ?>
<div class="contentpaneopen<?php echo $this->pageclass_sfx; ?>">
<?php

if ($this->returnAjaxForm) {
	writeContactForm( $this );
} else {
	switch($this->profile->display_format) {
		case 1 :
	?>
			<table id="aiContactSafeForm" border="0" cellpadding="0" cellspacing="5">
				<tr><td valign="top" <?php echo $this->profile->contact_info_width>0?'style="width:'.$this->profile->contact_info_width.';"':''; ?> ><?php echo $this->contactinformations['contact_info']; ?></td></tr>
				<tr>
					<td valign="top" <?php echo $this->profile->contact_form_width>0?'style="width:'.$this->profile->contact_form_width.';"':''; ?> >
						<br clear="all" />
						<?php writeContactForm( $this ); ?>
					</td>
				</tr>
			</table>
	<?php
			break;
		case 2 :
	?>
			<table id="aiContactSafeForm" border="0" cellpadding="0" cellspacing="5">
				<tr>
					<td valign="top" <?php echo $this->profile->contact_form_width>0?'style="width:'.$this->profile->contact_form_width.';"':''; ?> >
						<?php writeContactForm( $this ); ?>
					</td>
					<td valign="top" <?php echo $this->profile->contact_info_width>0?'style="width:'.$this->profile->contact_info_width.';"':''; ?> ><?php echo $this->contactinformations['contact_info']; ?></td>
				</tr>
			</table>
	<?php
			break;
		case 3 :
	?>
			<table id="aiContactSafeForm" border="0" cellpadding="0" cellspacing="5">
				<tr>
					<td valign="top" <?php echo $this->profile->contact_form_width>0?'style="width:'.$this->profile->contact_form_width.';"':''; ?> >
						<?php writeContactForm( $this ); ?>
					</td>
				</tr>
				<tr><td valign="top" <?php echo $this->profile->contact_info_width>0?'style="width:'.$this->profile->contact_info_width.';"':''; ?> ><?php echo $this->contactinformations['contact_info']; ?></td></tr>
			</table>
	<?php
			break;
		case 4 :
	?>
			<table id="aiContactSafeForm" border="0" cellpadding="0" cellspacing="5">
				<tr>
					<td valign="top" <?php echo $this->profile->contact_info_width>0?'style="width:'.$this->profile->contact_info_width.';"':''; ?> ><?php echo $this->contactinformations['contact_info']; ?></td>
					<td valign="top" <?php echo $this->profile->contact_form_width>0?'style="width:'.$this->profile->contact_form_width.';"':''; ?> >
						<?php writeContactForm( $this ); ?>
					</td>
				</tr>
			</table>
	<?php
			break;
		case 5 :
	?>
			<div id="aiContactSafeForm">
				<div id="aiContactSafeForm_contact_info" <?php echo $this->profile->contact_info_width>0?'style="width:'.$this->profile->contact_info_width.';"':''; ?> ><?php echo $this->contactinformations['contact_info']; ?></div>
				<div id="aiContactSafeForm_contact_form" <?php echo $this->profile->contact_form_width>0?'style="width:'.$this->profile->contact_form_width.';"':''; ?> >
					<?php writeContactForm( $this ); ?>
				</div>
			</div>
	<?php
			break;
		case 6 :
	?>
			<div id="aiContactSafeForm">
				<div id="aiContactSafeForm_contact_form" <?php echo $this->profile->contact_form_width>0?'style="width:'.$this->profile->contact_form_width.';"':''; ?> >
					<?php writeContactForm( $this ); ?>
				</div>
				<div id="aiContactSafeForm_contact_info" <?php echo $this->profile->contact_info_width>0?'style="width:'.$this->profile->contact_info_width.';"':''; ?> ><?php echo $this->contactinformations['contact_info']; ?></div>
			</div>
	<?php
			break;
		case 0 :
		default :
	?>
			<div id="aiContactSafeForm" <?php echo $this->profile->contact_form_width>0?'style="width:'.$this->profile->contact_form_width.';"':''; ?> >
			<?php writeContactForm( $this ); ?>
			</div>
	<?php
	}
}
?>
</div>
