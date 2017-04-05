<?php
/**
 * @version     $Id$ 2.0.12.c
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * added/fixed in version 2.0.1
 * - added new field types Checkbox - List, Radio - List, Date, Emails, Contacts
 * - added mark_required_fields character
 * - added id attribute on div tags for each rows for a better control with css
 * - added the test for captcha activation to profile
 * added/fixed in version 2.0.7
 * - replaced domready with load
 * added/fixed in version 2.0.8
 * - added field parameters to the radio buttons labels and date field combo boxes
 * - fixed the problem with current_url variable when the form is generated from a plugin
 * added/fixed in version 2.0.10.b
 * - replaced sufix with prefix as it is the correct order
 * - added the posibility to use either fixed or procentual width for the contact form and the contact information ( you can specify it in the profile )
 * added/fixed in version 2.0.10.c
 * - fixed the problem with the duplication of the div "aiContactSafe_mainbody" when AJAX is used
 * added/fixed in version 2.0.12
 * - check for the load.gif in the template and use the one delivered with the extension if it is not found
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// define the control_panel view class of aiContactSafe
class AiContactSafeViewMessage extends AiContactSafeViewDefault {
	// fields to display into the contact form
	var $fields = null;
	// the contact form
	var $contact_form = null;
	// the contact informations
	var $contactinformations = array();
	// the profile informations
	var $profile = null;
	// the url to return the form on success
	var $return_to = null;
	// the current url ( sent from the plugin if the form is used like that )
	var $current_url = null;
	// activate or deactivate the back button
	var $back_button = null;
	// display only the contact form ( for AJAX ) without buttons and captcha
	var $returnAjaxForm = false;
	// id of the requested variables registered in the session
	var $r_id = null;
	// check if there are any requested fields to display
	var $requested_fields = 0;
	// lang variable to use
	var $lang = null;

	// function to define the toolbar depending on the section
	function setToolbar() {
		// no toolbar here
	}

	// function to initialize the variables used in the template
	function setVariables() {
		// load the mootools javascript library
		JHTML::_('behavior.mootools');

		$jfcookie = JRequest::getVar('jfcookie', null ,"COOKIE");
		$lang = '';
		if (isset($jfcookie["lang"]) && $jfcookie["lang"] != "") {
			$lang = $jfcookie["lang"];
		}
		if (strlen($lang) == 0) {
			$lang = $this->_app->getUserState('application.lang', 'en');
			$lang = substr($lang,0,2);
		}
		$this->lang = JRequest::getCmd('lang', $lang);

		$pf = 0;
		$this->return_to = '';
		$this->r_id = JRequest::getInt( 'r_id', mt_rand() );

		$model = $this->getModel();

		$uri = & JURI::getInstance();
		$test_return_to = $uri->toString( array('scheme', 'host', 'port', 'path', 'query', 'fragment'));
		$this->current_url = $uri->toString( array('scheme', 'host', 'port', 'path', 'query', 'fragment'));
		// get the Itemid variable
		$menuItemid = JRequest::getInt( 'Itemid' );
		// get the menu variable
		$menu = JSite::getMenu();
		// read the parameters of the menu
		$menuparams = $menu->getParams( $menuItemid );
		$this->page_title = $menuparams->get( 'page_title' );
		$this->show_page_title = $menuparams->get( 'show_page_title' );
		$this->pageclass_sfx = $menuparams->get( 'pageclass_sfx' );

		// initialize the variable that will allow the use of the profile redirect on success
		$use_profile_redirect_on_success = false;

		// if the last send process ended up with an error
		if ($this->_app->_session->get( 'isOK:' . $this->_sTask ) === false) {
			$postData = $model->readPostDataFromSession();
			if (is_array($postData)) {
				$pf = (int)$postData['pf'];
				$this->return_to = str_replace('&#38;','&',$postData['return_to']);
				$this->current_url = str_replace('&#38;','&',(array_key_exists('current_url',$postData)?$postData['current_url']:$this->current_url));
				$this->back_button = array_key_exists('back_button',$postData)?$postData['back_button']:0;
				$this->lang = array_key_exists('lang',$postData)?$postData['lang']:$this->lang;
			}
		}
		if ($pf == 0) {
			// if there is a menulink get the parameters from it
			if ($menuItemid) {
				$pf = $menuparams->get( 'pf' );
				$this->return_to = $menuparams->get( 'redirect_on_success' );
				$test_return_to = $menuparams->get( 'redirect_on_success' );
			}
			// if no profile is specified check for one specified in request
			if ($pf == 0) {
				$pf = JRequest::getVar('pf', 0, 'request', 'int');
			}
			// if no return link is defined check for one in the request variables
			if ( $this->return_to == '' ) {
				$this->return_to = str_replace('&#38;','&',JRequest::getVar('return_to', '', 'request', 'string'));
			}
			// if no return link is found generate one and record if the one in the profile can be used
			if ( $this->return_to == '' ) {
				$this->return_to = $test_return_to;
				$use_profile_redirect_on_success = true;
			}
			// check if the back button will be used
			if ($this->return_to != '' && $this->return_to != $test_return_to) {
				$this->back_button = 1;
			} else {
				$this->back_button = 0;
			}
		}

		$this->profile = $model->getProfile($pf);
		if ($use_profile_redirect_on_success && strlen(trim($this->profile->redirect_on_success)) > 0) {
			$this->return_to = $this->profile->redirect_on_success;
		}
		$this->fields = $model->readFields( $this->profile );
		$this->fields = $this->generateHtmlFields( $this->fields );
		$this->contactinformations['contact_info'] = '';
		$this->contactinformations = $model->readContactInformations( $pf, $this->r_id );
		$this->contactinformations['required_field_notification'] = str_replace('%mark%', $this->profile->required_field_mark,$this->contactinformations['required_field_notification']);
		// check if the contact information width and contact form width specified in the profile have "px" or "%" at the end and add "px" if it is not specified
		if (substr($this->profile->contact_form_width,-2) != 'px' && substr($this->profile->contact_form_width,-1) != '%') {
			$this->profile->contact_form_width .= 'px';
		}
		if (substr($this->profile->contact_info_width,-2) != 'px' && substr($this->profile->contact_info_width,-1) != '%') {
			$this->profile->contact_info_width .= 'px';
		}

		// if the form is not called after a submit with ajax run all the content plugin on contact information
		if ( !$this->returnAjaxForm && $this->profile->plg_contact_info ) {
			$this->contactinformations['contact_info'] = JHTML::_('content.prepare',$this->contactinformations['contact_info']);
		}

		$doc =& JFactory::getDocument();
		if ( array_key_exists('meta_description',$this->contactinformations) && strlen($this->contactinformations['meta_description']) > 0 ) {
			$doc->setMetaData( 'description', $this->contactinformations['meta_description'] );
		}
		if ( array_key_exists('meta_keywords',$this->contactinformations) && strlen($this->contactinformations['meta_keywords']) > 0 ) {
			$doc->setMetaData( 'keywords', $this->contactinformations['meta_keywords'] );
		}
		if ( array_key_exists('meta_robots',$this->contactinformations) && strlen($this->contactinformations['meta_robots']) > 0 ) {
			$doc->setMetaData( 'robots', $this->contactinformations['meta_robots'] );
		}

		switch($this->profile->align_buttons) {
			case 1:
				// left
				$this->buttons = '<div id="aiContactSafeButtons_left" style="clear:both; display:block; width:100%; text-align:left;"><div id="aiContactSafeSend" style="float:left;"><div id="aiContactSafeSend_loading_'.$this->profile->id.'" style="float:left; margin:2px;">&nbsp;</div><input type="submit" id="aiContactSafeSendButton" value="' . JText::_( 'Envoyer' ) . '" style="float:left; margin:2px;" /></div>';
				if ($this->back_button) {
					$this->buttons .= '<div id="aiContactSafeBack" style="float:left;"><input type="button" onclick="javascript:document.getElementById(\'adminForm_'.$this->profile->id.'\').elements[\'send_mail\'].value=2;document.getElementById(\'adminForm_'.$this->profile->id.'\').submit();" value="' . JText::_( 'Back' ) . '" style="float:left; margin:2px;" /></div>';
				}
				$this->buttons .= '</div>';
				break;
			case 2:
				// center
				$this->buttons = '<div id="aiContactSafeButtons_center" style="clear:both; display:block; text-align:center;">';
				$this->buttons .= '<table border="0" cellpadding="2" cellspacing="0" style="margin-left:auto; margin-right:auto;">';
				$this->buttons .= '<tr>';
				$this->buttons .= '<td><div id="aiContactSafeSend_loading_'.$this->profile->id.'">&nbsp;</div></td>';
				$this->buttons .= '<td id="td_aiContactSafeSendButton"><input type="submit" id="aiContactSafeSendButton" value="' . JText::_( 'Send' ) . '" /></td>';
				if ($this->back_button) {
					$this->buttons .= '<td id="td_aiContactSafeBack"><input type="button" onclick="javascript:document.getElementById(\'adminForm_'.$this->profile->id.'\').elements[\'send_mail\'].value=2;document.getElementById(\'adminForm_'.$this->profile->id.'\').submit();" value="' . JText::_( 'Back' ) . '" /></td>';
				}
				$this->buttons .= '</tr>';
				$this->buttons .= '</table>';
				$this->buttons .= '</div>';
				break;
			case 3:
				// right
				$this->buttons = '<div id="aiContactSafeButtons_right" style="clear:both; display:block; width:100%; text-align:right;">';
				if ($this->back_button) {
					$this->buttons .= '<div id="aiContactSafeBack" style="float:right;"><input type="button" onclick="javascript:document.getElementById(\'adminForm_'.$this->profile->id.'\').elements[\'send_mail\'].value=2;document.getElementById(\'adminForm_'.$this->profile->id.'\').submit();" value="' . JText::_( 'Back' ) . '" style="float:right; margin:2px;" /></div>';
				}
				$this->buttons .= '<div id="aiContactSafeSend" style="float:right;"><input type="submit" id="aiContactSafeSendButton" value="' . JText::_( 'Send' ) . '" style="float:right; margin:2px;" /><div id="aiContactSafeSend_loading_'.$this->profile->id.'" style="float:right; margin:2px;">&nbsp;</div></div>';
				$this->buttons .= '</div>';
				break;
			case 0:
			default :
				// none
				$this->buttons = '<div id="aiContactSafeSend"><div id="aiContactSafeSend_loading_'.$this->profile->id.'">&nbsp;</div><input type="submit" id="aiContactSafeSendButton" value="' . JText::_( 'Send' ) . '" /></div>';
				if ($this->back_button) {
					$this->buttons .= '<div id="aiContactSafeBack"><input type="button" onclick="javascript:document.getElementById(\'adminForm_'.$this->profile->id.'\').elements[\'send_mail\'].value=2;document.getElementById(\'adminForm_'.$this->profile->id.'\').submit();" value="' . JText::_( 'Back' ) . '" /></div>';
				}
				break;
		}


		// load the javascript juctions
		require_once( JPATH_ROOT.DS.'components'.DS.'com_aicontactsafe'.DS.'includes'.DS.'js'.DS.'aicontactsafe.js.php' );

		$use_ajax = JRequest::getVar( 'use_ajax', $this->profile->use_ajax, 'request', 'int');
		$script = "
			//<![CDATA[
			<!--
			window.addEvent('load', function() {
				changeCaptcha(".$this->profile->id.",0);\n".($use_ajax?"resetSubmit(".$this->profile->id.");\n":"")."
			});
			//-->
			//]]>
		";
		
		$document =& JFactory::getDocument();
		$document->addScriptDeclaration($script);

	}

	// function to display the default template
	function viewDefault( $returnAjaxForm = false ) {
		// initialize $returnAjaxForm
		$this->returnAjaxForm = $returnAjaxForm;
		// add javascript
		$document =& JFactory::getDocument();
		$document->addScript( JURI::root(true).'/includes/js/joomla.javascript.js');
		// initialize the template variables
		$this->setVariables();
		// generate the css file name based on the profile
		$css_file = 'profile_css_'.$this->profile->id.'.css';
		// call the css file
		$this->callCssFile($css_file);
		// determine to what section to return to
		$this->setTaskReturn();

		if ($returnAjaxForm) {
			parent::display();
		} else {
			echo '<div class="aiContactSafe" id="aiContactSafe_mainbody_'.$this->profile->id.'">';
			parent::display();
			echo '</div>';
		}

		// reset the form fields after the form was displayed
		$model = &$this->getModel( $this->_sTask, '', $this->_parameters );
		$model->resetFormFields();
	}

	// function to generate the header of the template to display
	function getTmplHeader() {
		$header = '<form action="index.php" method="post" id="adminForm_'.$this->profile->id.'" name="adminForm_'.$this->profile->id.'" enctype="multipart/form-data">';
		return $header;
	}

	// function to generate the footer of the template to display
	function getTmplFooter() {
		$footer = '';
		$footer .= '<input type="hidden" id="option" name="option" value="com_aicontactsafe" />';
		$footer .= '<input type="hidden" id="sTask" name="sTask" value="' . $this->_sTask . '" />';
		$footer .= '<input type="hidden" id="task" name="task" value="' . $this->_task . '" />';
		$footer .= '<input type="hidden" id="send_mail" name="send_mail" value="1" />';
		$footer .= '<input type="hidden" id="pf" name="pf" value="'.$this->profile->id.'" />';
		$return_to = $this->return_to;
		if ( strpos($return_to, '&#38;') === false && strpos($return_to, '&') !== false ) {
			$return_to = str_replace('&','&#38;',$return_to);
		}
		$footer .= '<input type="hidden" id="return_to" name="return_to" value="'.$return_to.'" />';
		$uri = & JURI::getInstance();
		$current_url = $this->current_url;
		if ( strpos($current_url, '&#38;') === false && strpos($current_url, '&') !== false ) {
			$current_url = str_replace('&','&#38;',$current_url);
		}
		$footer .= '<input type="hidden" id="current_url" name="current_url" value="'.$current_url.'" />';
		$Itemid = JRequest::getInt( 'Itemid' );
		$footer .= '<input type="hidden" id="Itemid" name="Itemid" value="'.$Itemid.'" />';
		$footer .= '<input type="hidden" id="lang" name="lang" value="'.$this->lang.'" />';
		$footer .= '<input type="hidden" id="back_button" name="back_button" value="'.$this->back_button.'" />';
		$footer .= '<input type="hidden" id="boxchecked" name="boxchecked" value="0" />';
		$use_ajax = JRequest::getVar( 'use_ajax', $this->profile->use_ajax, 'request', 'int');
		$footer .= '<input type="hidden" id="use_ajax" name="use_ajax" value="'.$use_ajax.'" />';
		$footer .= '<input type="hidden" id="r_id" name="r_id" value="'.$this->r_id.'" />';
		$footer .= JHTML::_( 'form.token' );
		$footer .= '</form>';

		// display the version of aiContactSafe
		$veraicontactsafe = JRequest::getVar('veraicontactsafe', 0, 'request', 'int');
		if ($veraicontactsafe) {
			$footer .= '<br clear="all" /><div id="veraicontactsafe">aiContactSafe version : '.$this->_version.'</div><br clear="all" />';
		}

		return $footer;
	}

	// function to generate the html tags for each field type
	function generateHtmlFields( $fields = null ) {
		// initialize the model
		$model = &$this->getModel();
		// check if the fields were read from the database
		if(!$fields) {
			$fields = $this->fields;
		}
		if(!$fields) {
			$this->fields = $model->readFields( $this->profile );
			$fields = $this->fields;
		}

		// get the information entered into the contact form if an error has occured, or generate the default values to use on the form
		$postData = null;
		if ($this->_app->_session->get( 'isOK:' . $this->_sTask ) === false) {
			$postData = $model->readPostDataFromSession();
		} else {
			// check if any parameters were recorded into the session
			$postData = $model->readParametersDataFromSession( $this->r_id );
			if (!is_array($postData)) {
				$postData = null;
			}
		}
		// initialize the db for contacts only once
		$contacts_db_not_initialized = true;

		// get user informations
		if ($this->_user_id > 0) {
			$user = & JFactory::getUser();
			$joomla_user_name = $user->get('name');
			$joomla_user_email = $user->get('email');
		}

		// import joomla clases to manage file system
		jimport('joomla.filesystem.file');
		// generate the path to the load.gif image
		$template_name = $this->_app->getTemplate();
		$tPath = JPATH_ROOT.DS.'templates'.DS.$template_name.DS.'html'.DS.'com_aicontactsafe'.DS.'message'.DS.'load.gif';
		if (JFile::exists($tPath)) {
			$loadImage = JURI::root().'templates/'.$template_name.'/html/com_aicontactsafe/message/load.gif';
		} else {
			$loadImage = JURI::root().'components/com_aicontactsafe/includes/images/load.gif';
		}

		// reset the variable to check if there is any required field
		$this->requested_fields = 0;
		// initialize the form
		foreach($fields as $field_key=>$field) {
			$field->html_tag = '';
			$field->field_label = $this->revert_specialchars($field->field_label);
			$field->label_parameters = $this->revert_specialchars($field->label_parameters);
			$field->field_parameters = $this->revert_specialchars($field->field_parameters);
			// chec if the field is required and modify the varible $this->requested_fields
			if ($field->field_required) {
				$this->requested_fields = 1;
			}

			$postData_field_value = null;
			if ($this->_user_id > 0 && strlen(trim($field->auto_fill)) > 0) {
				switch($field->auto_fill) {
					case 'UN' :
						$postData_field_value = $joomla_user_name;
						break;
					case 'UE' :
						$postData_field_value = $joomla_user_email;
						break;
				}
			}
			if ( $field->field_type == 'HD' && strlen(trim($field->field_values)) > 0 ) {
				$postData_field_value = trim($field->field_values);
			}
			if (is_null($postData_field_value)) {
				$postData_field_value = $field->default_value;
			}
			if (is_array($postData) && array_key_exists($field->name, $postData)) {
				$postData_field_value = $postData[$field->name];
				if (is_array($postData_field_value)) {
					$postData_field_value = implode(';',$postData_field_value);
				}
			}
			$postData_field_value = $model->replace_specialchars($postData_field_value);
			switch($field->field_type) {
				case 'TX' :
					// Textbox
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					$maxlength = '';
					if (substr_count(strtolower($field->field_parameters), 'maxlength') == 0 && $field->field_limit > 0) {
						$maxlength = 'maxlength="'.$field->field_limit.'"';
					}
					$field->html_tag = '<input type="text" name="' . $field->name . '" id="' . $field->name . '" ' . $maxlength . ' ' . $field->field_parameters . ' value="' . $postData_field_value . '" />';
					break;
				case 'CK' :
					// Checkbox
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					$field->html_tag = '<input type="checkbox" name="' . $field->name . '" id="' . $field->name . '" ' . $field->field_parameters . ' ' . ($postData_field_value?'checked="checked"':'') . ' />';
					break;
				case 'CB' :
					// Combobox
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					$field_values = explode(';',$model->revert_specialchars($field->field_values));
					// generate the array with the combovalues
					$select_combo = array();
					if (!is_numeric($field->default_value) && strlen(trim($field->default_value)) > 0) {
						$txtSelect = new stdClass;
						$txtSelect->name = trim($field->default_value);
						$txtSelect->id = -1;
						$select_combo[] = $txtSelect;
					}
					foreach($field_values as $id => $combo_value) {
						$txtSelect = new stdClass;
						$txtSelect->name = $combo_value;
						$txtSelect->id = $id;
						$select_combo[] = $txtSelect;
					}
					// generate the html tag
					$field->html_tag = JHTML::_('select.genericlist', $select_combo, $field->name, $field->field_parameters, 'id', 'name', $postData_field_value, false, false);
					break;
				case 'ED' :
					// Editbox
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					$cols = '';
					if (substr_count(strtolower($field->field_parameters), 'cols') == 0 && $this->_config_values['editbox_cols'] > 0) {
						$cols = 'cols="'.$this->_config_values['editbox_cols'].'"';
					}
					$rows = '';
					if (substr_count(strtolower($field->field_parameters), 'rows') == 0 && $this->_config_values['editbox_rows'] > 0) {
						$rows = 'rows="'.$this->_config_values['editbox_rows'].'"';
					}
					if ($field->field_limit > 0) {
						$field->html_tag = '<textarea name="' . $field->name . '" id="' . $field->name . '" ' . $cols . ' ' . $rows . ' ' . $field->field_parameters . ' onkeydown="checkEditboxLimit('.$this->profile->id.',\''.$field->name.'\', '.$field->field_limit.')" onkeyup="checkEditboxLimit('.$this->profile->id.',\''.$field->name.'\','.$field->field_limit.')" onchange="checkEditboxLimit('.$this->profile->id.',\''.$field->name.'\','.$field->field_limit.')">' . $model->revert_specialchars($postData_field_value) . '</textarea>';
						$field->html_tag .= '<br />';
						$field->html_tag .= '<div class="countdown_div">' . JText::_( 'Il vous reste' ) . '<input type="text" readonly="readonly" class="countdown_editbox" name="countdown_'.$field->name.'" id="countdown_'.$field->name.'" size="'.strlen($field->field_limit).'" value="'.$field->field_limit.'" />' . JText::_( 'caract&egrave;res' ) . '.</div>';
					} else {
						$field->html_tag = '<textarea name="' . $field->name . '" id="' . $field->name . '" ' . $cols . ' ' . $rows . ' ' . $field->field_parameters . '>' . $model->revert_specialchars($postData_field_value) . '</textarea>';
					}
					break;
				case 'CL' :
					// Checkbox - List
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</span>';
					$field_values = explode(';',$model->revert_specialchars($field->field_values));
					$count_values = count($field_values);
					if ((int)strpos($postData_field_value, ';') > 0) {
						$postData_field_value = explode(';',$model->revert_specialchars($postData_field_value));
					}
					for($i=0;$i<$count_values;$i++) {
						if (is_array($postData_field_value)) {
							$postDataValue = $postData_field_value[$i];
						} else {
							$postDataValue = 0;
						}
						$field->html_tag .= '<div id="div_' . $field->name . $i . '" class="' . $field->name . '" ' . $field->field_parameters . '>';
						$field->html_tag .= '<input type="checkbox" id="' . $field->name . '_chk_' . $i . '" class="' . $field->name . '" onchange="clickCheckBox('.$this->profile->id.',\'' . $field->name . $i . '\',this.checked)" ' . $field->field_parameters . ' ' . ($postDataValue?'checked="checked"':'') . ' />';
						$field->html_tag .= '<input type="hidden" value="' . $postDataValue . '" id="' . $field->name . $i . '" name="' . $field->name . '[]" />&nbsp;<label for="' . $field->name . '_chk_' . $i . '">' . $field_values[$i] . '</label></div>';
					}
					break;
				case 'RL' :
					// Radio - List
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</span>';
					$field_values = explode(';',$model->revert_specialchars($field->field_values));
					$count_values = count($field_values);
					for($i=0;$i<$count_values;$i++) {
						$field->html_tag .= '<div id="div_' . $field->name . $i . '" class="' . $field->name . '" ' . $field->field_parameters . '><input type="radio" id="' . $field->name . $i . '" class="' . $field->name . '" name="' . $field->name . '" value="' . $field_values[$i] . '" '.($postData_field_value == $field_values[$i]?'checked="checked"':'').' ' . $field->field_parameters . ' /><label for="' . $field->name . $i . '" ' . $field->field_parameters . ' >&nbsp;' . $field_values[$i] . '</label></div>';
					}
					break;
				case 'DT' :
					// Date
					// modify the field name to use the profile id so the same date field can be used more then once o a web page
					$date_field_name = $field->name . '_' . $this->profile->id;
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $date_field_name . '" ' . $field->label_parameters . '><label for="' . $date_field_name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					if ($postData_field_value) {
						$postDataValue = $postData_field_value;
					} else {
						$postDataValue = date('Y-m-d');
					}
					$year = substr($postDataValue,0,4);
					$month = substr($postDataValue,5,2);
					$day = substr($postDataValue,8,2);

					// generate the day combo
					$select_day = '<select name="day_' . $date_field_name . '" id="day_' . $date_field_name . '" onchange="checkDate('.$this->profile->id.',\'' . $date_field_name . '\')" >';
					for($i = 1; $i<=31; $i++) {
						$select_day .= '<option value="' . str_pad($i, 2, "0", STR_PAD_LEFT) . '" ' . (( str_pad($i, 2, "0", STR_PAD_LEFT) == $day )?'selected="selected"':'') . ' ' . $field->field_parameters . ' >' . str_pad($i, 2, "0", STR_PAD_LEFT) . '</option>';
					}
					$select_day .= '</select>';
					// generate the month combo
					$select_month = '<select name="month_' . $date_field_name . '" id="month_' . $date_field_name . '" onchange="checkDate('.$this->profile->id.',\'' . $date_field_name . '\')" >';
					for($i = 1; $i<=12; $i++) {
						$select_month .= '<option value="' . str_pad($i, 2, "0", STR_PAD_LEFT) . '" ' . (( str_pad($i, 2, "0", STR_PAD_LEFT) == $month )?'selected="selected"':'') . ' ' . $field->field_parameters . ' >' . $model->getMonth($i) . '</option>';
					}
					$select_month .= '</select>';
					// generate the year combo
					$select_year = '<select name="year_' . $date_field_name . '" id="year_' . $date_field_name . '" onchange="checkDate('.$this->profile->id.',\'' . $date_field_name . '\')" >';
					$year_min = (int)$year - $this->profile->custom_date_years_back;
					$year_max = (int)$year + $this->profile->custom_date_years_forward;
					for($i = $year_min; $i<=$year_max; $i++) {
						$select_year .= '<option value="' . str_pad($i, 4, "0", STR_PAD_LEFT) . '" ' . (( str_pad($i, 4, "0", STR_PAD_LEFT) == $year )?'selected="selected"':'') . ' ' . $field->field_parameters . ' >' . str_pad($i, 4, "0", STR_PAD_LEFT) . '</option>';
					}
					$select_year .= '</select>';

					$field->html_tag .= '<div id="div_' . $date_field_name . '" class="' . $date_field_name . '" ' . $field->field_parameters . '><table id="table_' . $date_field_name . '" class="aiContactSafe_date" border="0" cellpadding="0" cellspacing="0"><tr>';
					switch( $this->profile->custom_date_format ) {
						case 'mdy':
							$field->html_tag .= '<td>'. $select_month .'</td><td>'. $select_day .'</td><td>'. $select_year .'</td>';
							break;
						case 'ymd':
							$field->html_tag .= '<td>'. $select_year .'</td><td>'. $select_month .'</td><td>'. $select_day .'</td>';
							break;
						case 'dmy':
						default :
							$field->html_tag .= '<td>'. $select_day .'</td><td>'. $select_month .'</td><td>'. $select_year .'</td>';
							break;
					}
					$field->html_tag .= '<td>'. JHTML::_('calendar', $postDataValue, $date_field_name, $date_field_name, '%Y-%m-%d', array('class'=>'aiContactSafe_dateinputbox', 'size'=>'1', 'onchange'=>'setDate('.$this->profile->id.',this.value,\'' . $date_field_name . '\')', 'style'=>'display:none;')) .'</td>';
					$field->html_tag .= '</tr></table></div>';
					break;
					//
				case 'EM' :
					// Email
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					$maxlength = '';
					if (substr_count(strtolower($field->field_parameters), 'maxlength') == 0 && $field->field_limit > 0) {
						$maxlength = 'maxlength="'.$field->field_limit.'"';
					}
					$field->html_tag = '<input type="text" name="' . $field->name . '" id="' . $field->name . '" ' . $maxlength . ' ' . $field->field_parameters . ' value="' . $postData_field_value . '" />';
					break;
				case 'EL' :
					// Email - List
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					$field_values = explode(';',$model->revert_specialchars($field->field_values));
					// generate the array with the combovalues
					$select_combo = array();
					foreach($field_values as $id => $combo_value) {
						if (strlen($combo_value) > 0) {
							$combo_value = substr($combo_value, 0, strpos($combo_value,':'));
							$txtSelect = new stdClass;
							$txtSelect->name = $combo_value;
							$txtSelect->id = $id;
							$select_combo[] = $txtSelect;
						}
					}
					// generate the html tag
					if (count($select_combo) == 0) {
						$field->html_tag = '<font color="red">' . JText::_( 'No data available !' ) . '</font>';
					} else {
						if (!is_numeric($field->default_value) && strlen(trim($field->default_value)) > 0) {
							$txtSelect = new stdClass;
							$txtSelect->name = trim($field->default_value);
							$txtSelect->id = -1;
							array_unshift($select_combo, $txtSelect);
						}
						$field->html_tag = JHTML::_('select.genericlist', $select_combo, $field->name, $field->field_parameters, 'id', 'name', $postData_field_value, false, false);
					}
					break;
				case 'JC' :
					// Joomla Contacts
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					if ($contacts_db_not_initialized) {
						// initialize different variables
						$db = & JFactory::getDBO();
						$contacts_db_not_initialized = false;
					}
					$query = 'SELECT name, id FROM #__contact_details WHERE published = 1 ORDER BY ordering';
					$db->setQuery($query);
					$select_contacts = $db->loadObjectList();
					// generate the html tag
					if (count($select_contacts) == 0) {
						$field->html_tag = '<font color="red">' . JText::_( 'No data available !' ) . '</font>';
					} else {
						if (!is_numeric($field->default_value) && strlen(trim($field->default_value)) > 0) {
							$txtSelect = new stdClass;
							$txtSelect->name = trim($field->default_value);
							$txtSelect->id = 0;
							array_unshift($select_contacts, $txtSelect);
						}
						$field->html_tag = JHTML::_('select.genericlist', $select_contacts, $field->name, $field->field_parameters, 'id', 'name', $postData_field_value, false, false);
					}
					break;
				case 'JU' :
					// Joomla Users
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					if ($contacts_db_not_initialized) {
						// initialize different variables
						$db = & JFactory::getDBO();
						$contacts_db_not_initialized = false;
					}
					$query = 'SELECT name, id FROM #__users WHERE block = 0 ORDER BY name';
					$db->setQuery($query);
					$select_users = $db->loadObjectList();
					// generate the html tag
					if (count($select_users) == 0) {
						$field->html_tag = '<font color="red">' . JText::_( 'No data available !' ) . '</font>';
					} else {
						if (!is_numeric($field->default_value) && strlen(trim($field->default_value)) > 0) {
							$txtSelect = new stdClass;
							$txtSelect->name = trim($field->default_value);
							$txtSelect->id = 0;
							array_unshift($select_users, $txtSelect);
						}
						$field->html_tag = JHTML::_('select.genericlist', $select_users, $field->name, $field->field_parameters, 'id', 'name', $postData_field_value, false, false);
					}
					break;
				case 'SB' :
					// SOBI2 Entries
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					if ($contacts_db_not_initialized) {
						// initialize different variables
						$db = & JFactory::getDBO();
						$contacts_db_not_initialized = false;
					}
					$query = 'SELECT title, itemid FROM #__sobi2_item WHERE published = 1 AND approved = 1 ORDER BY title';
					$db->setQuery($query);
					$select_sobi = $db->loadObjectList();
					// generate the html tag
					if (count($select_sobi) == 0) {
						$field->html_tag = '<font color="red">' . JText::_( 'No data available !' ) . '</font>';
					} else {
						if (!is_numeric($field->default_value) && strlen(trim($field->default_value)) > 0) {
							$txtSelect = new stdClass;
							$txtSelect->title = trim($field->default_value);
							$txtSelect->itemid = 0;
							array_unshift($select_sobi, $txtSelect);
						}
						$field->html_tag = JHTML::_('select.genericlist', $select_sobi, $field->name, $field->field_parameters, 'itemid', 'title', $postData_field_value, false, false);
					}
					break;
				case 'HD' :
					// Hidden
					if ( strlen(trim($field->field_label)) > 0 ) {
						$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</span>';
					} else {
						$field->html_label = null;
					}
					$field->html_tag = '<input type="hidden" name="' . $field->name . '" id="' . $field->name . '" ' . $field->field_parameters . ' value="' . $postData_field_value . '" />';
					break;
				case 'SP' :
					// Separator
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</span>';
					$field->html_tag = '<div id="sp_' . $field->name . '" ' . $field->field_parameters . '>' . (is_null($postData_field_value)?'':$postData_field_value) . '<input type="hidden" name="' . $field->name . '" id="' . $field->name . '" value="' . $postData_field_value . '" /></div>';
					break;
				case 'FL' :
					// File
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					$field->html_tag = '';
					if ( is_array($postData) ) {
						if ( array_key_exists($field->name.'_attachment_id', $postData) && strlen($postData[$field->name.'_attachment_id']) > 0 ) {
							$field->html_tag .= '<div id="upload_'.$this->profile->id.'_file_'.$field->name.'" style="display:none"><input type="file" name="' . $field->name . '" id="' . $field->name . '" ' . ' onchange="startUploadFile(\''.$field->name.'\','.$this->profile->id.')" /></div>';
							$field->html_tag .= '<div id="cancel_upload_'.$this->profile->id.'_file_'.$field->name.'" style="display:inline">';
							$field->html_tag .= '<input type="text" name="' . $field->name . '_attachment_name" id="' . $field->name . '_attachment_name" ' . $field->field_parameters . ' value="' . (array_key_exists($field->name.'_attachment_name',$postData)?$postData[$field->name.'_attachment_name']:'') . '" readonly="readonly" />';
							$field->html_tag .= '<input type="button" name="' . $field->name . '_attachment_cancel" id="' . $field->name . '_attachment_cancel" value="' . JText::_( 'Cancel' ) . '" onclick="cancelUploadFile(\''.$field->name.'\', '.$this->profile->id.');" />';
							$field->html_tag .= '</div>';
						} else {
							$field->html_tag .= '<div id="upload_'.$this->profile->id.'_file_'.$field->name.'" style="display:inline"><input type="file" name="' . $field->name . '" id="' . $field->name . '" ' . ' onchange="startUploadFile(\''.$field->name.'\','.$this->profile->id.')" /></div>';
							$field->html_tag .= '<div id="cancel_upload_'.$this->profile->id.'_file_'.$field->name.'" style="display:none">';
							$field->html_tag .= '<input type="text" name="' . $field->name . '_attachment_name" id="' . $field->name . '_attachment_name" ' . $field->field_parameters . ' value="' . (array_key_exists($field->name.'_attachment_name',$postData)?$postData[$field->name.'_attachment_name']:'') . '" readonly="readonly" />';
							$field->html_tag .= '<input type="button" name="' . $field->name . '_attachment_cancel" id="' . $field->name . '_attachment_cancel" value="' . JText::_( 'Cancel' ) . '" onclick="cancelUploadFile(\''.$field->name.'\', '.$this->profile->id.');" />';
							$field->html_tag .= '</div>';
						}
					} else {
						$field->html_tag .= '<div id="upload_'.$this->profile->id.'_file_'.$field->name.'" style="display:inline"><input type="file" name="' . $field->name . '" id="' . $field->name . '" ' . ' onchange="startUploadFile(\''.$field->name.'\','.$this->profile->id.')" /></div>';
						$field->html_tag .= '<div id="cancel_upload_'.$this->profile->id.'_file_'.$field->name.'" style="display:none">';
						$field->html_tag .= '<input type="text" name="' . $field->name . '_attachment_name" id="' . $field->name . '_attachment_name" ' . $field->field_parameters . ' value="" readonly="readonly" />';
						$field->html_tag .= '<input type="button" name="' . $field->name . '_attachment_cancel" id="' . $field->name . '_attachment_cancel" value="' . JText::_( 'Cancel' ) . '" onclick="cancelUploadFile(\''.$field->name.'\', '.$this->profile->id.');" />';
						$field->html_tag .= '</div>';
					}
					$field->html_tag .= '<input type="hidden" name="' . $field->name . '_attachment_id" id="' . $field->name . '_attachment_id" value="' . ((is_array($postData) && array_key_exists($field->name.'_attachment_id',$postData))?$postData[$field->name.'_attachment_id']:'') . '" />';
					$field->html_tag .= '<div id="wait_upload_'.$this->profile->id.'_file_'.$field->name.'" style="display:none" ><img id="imgLoading_' . $field->name . '" border="0" src="'.$loadImage.'" />&nbsp;&nbsp;'.JText::_( 'Please wait ...' ).'</div>';
					$field->html_tag .= '<iframe id="iframe_upload_file_' . $this->profile->id.'_file_'.$field->name.'" name="iframe_upload_file_' . $this->profile->id.'_file_'.$field->name.'" src="'.JURI::root().'components/com_aicontactsafe/index.html" style="width:0;height:0;border:0px solid #FFF;display:none;"></iframe>';
					break;
				case 'NO' :
					// Number
					$field->html_label = '<span class="aiContactSafe_label" id="aiContactSafe_label_' . $field->name . '" ' . $field->label_parameters . '><label for="' . $field->name . '" ' . $field->label_parameters . '>' . $field->field_label . '</label></span>';
					$maxlength = '';
					if (substr_count(strtolower($field->field_parameters), 'maxlength') == 0 && $field->field_limit > 0) {
						$maxlength = 'maxlength="'.$field->field_limit.'"';
					}
					$field->html_tag = '<input type="text" name="' . $field->name . '" id="' . $field->name . '" ' . $maxlength . ' ' . $field->field_parameters . ' value="' . $postData_field_value . '" />';
					break;
				case 'HE' :
					// Hidden Email
					// it will generate a field only if it has a post value in it
					if ( strlen(trim($postData_field_value)) > 0 ) {
						$field->html_label = '';
						$he_value = $model->ascunde_sir($postData_field_value);
						$field->html_tag = '<input type="hidden" name="' . $field->name . '" id="' . $field->name . '" value="' . $he_value . '" />';
					} else {
						$field->html_label = null;
						$field->html_tag = null;
					}
					break;
			}
			if (strlen(trim($field->html_tag)) > 0) {
				if (strlen(trim($field->field_prefix)) > 0) {
					$field->html_tag = '<span class="aiContactSafe_prefix" id="' . $field->name . '_prefix">'.trim($field->field_prefix).'</span>'.$field->html_tag;
				}
				if (strlen(trim($field->field_sufix)) > 0) {
					$field->html_tag = $field->html_tag.'<span class="aiContactSafe_sufix" id="' . $field->name . '_sufix">'.trim($field->field_sufix).'</span>';
				}
			}

			$fields[$field_key] = $field;
		}

		return $fields;
	}

	// function to call the css file used with this view
	function callCssFile($cssFile = '') {
		// check if css is activated/deactivated in the current profile
		$use_css = $this->profile->use_message_css;
		// if no cssFile is named call the default one of the class
		if (strlen($cssFile) == 0) {
			$cssFile = $this->_cssFile;
		}
		// if css is activated and there is a css file to call, continue the function
		if ($use_css) {
			$document =& JFactory::getDocument();
			$nameCssGeneral = JURI::root().'components/com_aicontactsafe/includes/css/aicontactsafe_general.css';
			$document->addStyleSheet($nameCssGeneral);

			if (strlen($cssFile) > 0) {
				// import joomla clases to manage file system
				jimport('joomla.filesystem.file');
				// determine if to use the css from the template or from the component
				$template_name = $this->_app->getTemplate();
				$tPath = JPATH_ROOT.DS.'templates'.DS.$template_name.DS.'html'.DS.'com_aicontactsafe'.DS.'message'.DS.$cssFile;
				if (JFile::exists($tPath)) {
					$nameCssFile = JURI::root().'templates/'.$template_name.'/html/com_aicontactsafe/message/'.$cssFile;
				} else {
					$nameCssFile = JURI::root().'media/aicontactsafe/cssprofiles/'.$cssFile;
				}
				$document->addStyleSheet($nameCssFile);
			}
		}
	}

	// function to generate captcha code
	function writeCaptcha() {
		// if captcha is activated, generate the image
		if ($this->profile->use_captcha == 1 || ($this->profile->use_captcha == 2 && $this->_user_id == 0)) {
			switch($this->profile->captcha_type) {
				case 0:
					// native plugin
					$captcha_info = JText::_( 'Merci de rentrer le code de s&#233;curit&#233; ci-dessous ' ) . ':';
					$change_image = JText::_( 'Illisible? Cliquer pour changer de texte.' );
					?>
					<div id="div_captcha">
						<div id="div_captcha_info"><?php echo $captcha_info; ?></div>
						<div id="div_captcha_img"><div id="div_captcha_img_<?php echo $this->profile->id; ?>" style="width:<?php echo $this->profile->captcha_width; ?>px;height:<?php echo $this->profile->captcha_height; ?>px;">...</div></div>
						<div id="div_captcha_new">
							<a href="javascript:void(0);" onclick="changeCaptcha(<?php echo $this->profile->id; ?>,1);"
								id="change-image"><?php echo $change_image; ?></a>
						</div>
						<div style="margin-top:5px;" id="div_captcha_code"><input type="text" name="captcha-code" id="captcha-code" /></div>
					</div>
					<?php
					break;
				case 1:
					// Multiple CAPTCHA Engine
					$captchaPlugin = JPluginHelper::getPlugin('content', 'captcha');
					$captchaPluginParameters = new JParameter($captchaPlugin->params);
					if ( $captchaPluginParameters->get( 'captcha_systems' ) == 'recaptcha' ) {
						?>
						<input type="hidden" id="reCaptchaReset" name="reCaptchaReset" value="1" />
						<input type="hidden" id="reCaptchaPublicKey" name="reCaptchaPublicKey" value="<?php echo $captchaPluginParameters->get( 'captcha_systems-recaptcha-PubKey' ); ?>" />
						<input type="hidden" id="reCaptchaTheme" name="reCaptchaTheme" value="<?php echo $captchaPluginParameters->get( 'captcha_systems-recaptcha-Theme' ); ?>" />
						<?php
					}
					JPluginHelper::importPlugin('content', 'captcha');
					$dispatcher =& JDispatcher::getInstance();
					$dispatcher->trigger('onAfterDisplayForm');
					break;
			}
		}
	}

}

?>

