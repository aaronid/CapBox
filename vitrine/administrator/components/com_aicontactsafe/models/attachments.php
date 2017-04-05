<?php
/**
 * @version     $Id$ 2.0.7 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// define the control_panel model class of aiContactSafe
class AiContactSafeModelAttachments extends AiContactSafeModelDefault {

	// function to read all the attachments used by aiContactSafe
	function getAttachments() {
		$files = array();

		// initialize the database
		$db = &JFactory::getDBO();

		// get the files from the databse
		$query = 'SELECT mf.*, ms.name as ms_name, ms.email as ms_email, ms.subject as ms_subject, ms.sender_ip as ms_sender_ip FROM #__aicontactsafe_messagefiles mf LEFT JOIN #__aicontactsafe_messages ms ON mf.message_id = ms.id ORDER by mf.name';
		$db->setQuery( $query );
		$recorded_files = $db->loadObjectList();

		// import joomla clases to manage the folder
		jimport('joomla.filesystem.folder');
		// import joomla clases to manage file system
		jimport('joomla.filesystem.file');

		// get the path to attachments upload
		$upload_folder = str_replace('\\',DS,$this->_config_values['upload_attachments']);
		$upload_folder = str_replace('/',DS,$upload_folder);
		$upload_folder = str_replace('&#92;',DS,$upload_folder);
		$path_upload = JPATH_ROOT.DS.$upload_folder;

		// an array to record the files in the database and exclude them from the array with the files from the upload folder 
		// so I get only the files not in the database when I read files from the upload folder
		$exclude_files = array('.htaccess', 'index.html');

		// check the files in the databse
		foreach($recorded_files as $recorded_file) {
			// check if the file exists
			$file = $path_upload.DS.$recorded_file->name;
			if (JFile::exists($file)) {
				if ($recorded_file->message_id > 0) {
					$recorded_file->recorded = 1;
					$recorded_file->recorded_text = '<font color="#006600">' . JText::_( 'OK' ) . '</font>';
				} else {
					$recorded_file->recorded = 4;
					$recorded_file->recorded_text = '<font color="#FFCC00">' . JText::_( 'Not sent in a message' ) . '</font>';
				}
				$files[] = $recorded_file;
				$exclude_files[] = $recorded_file->name;
			} else {
				$recorded_file->recorded = 2;
				$recorded_file->recorded_text = '<font color="#FF0000">' . JText::_( 'Only in the database' ) . '</font>';
				$files[] = $recorded_file;
			}
		}

		// get the files from the attachments folder
		$not_recorded_files = JFolder::files($path_upload, '.', false, false, $exclude_files );

		// check the files in the upload folder
		foreach($not_recorded_files as $not_recorded_file) {
			$file = new stdClass;
			$file->id = null;
			$file->message_id = null;
			$file->name = $not_recorded_file;
			$file->r_id = null;
			$file->date_added = null;
			$file->last_update = null;
			$file->published = null;
			$file->checked_out = null;
			$file->checked_out_time = null;
			$file->ms_name = null;
			$file->ms_email = null;
			$file->ms_subject = null;
			$file->ms_sender_ip = null;
			$file->recorded = 0;
			$file->recorded_text = '<font color="#FF0000">' . JText::_( 'Only as file' ) . '</font>';
			$files[] = $file;
		}

		if ( strlen($this->filter_string) > 0 ) {
			$files = $this->filterFiles($files, $this->filter_string);
		}
		if (strlen($this->filter_order) > 0) {
			$files = $this->sortFiles($files, $this->filter_order, $this->filter_order_Dir);
		}

		$files_to_display = array();

		// import the pagination class
		jimport('joomla.html.pagination');

		$total = count($files);
		$this->pageNav = new JPagination( $total, $this->limitstart, $this->limit );
		if ( $this->limit > 0 ) {
			for($i=$this->limitstart;$i<$this->limitstart+$this->limit;$i++) {
				if (array_key_exists($i,$files)) {
					$files_to_display[] = $files[$i];
				}
			}
		} else {
			$files_to_display = $files;
		}

		return $files_to_display;
	}

	// function to filter files by a string
	function filterFiles($files, $string) {
		$string = strtolower($string);
		foreach($files as $key=>$file) {
			if (strpos(strtolower($file->name), $string) === false) {
				unset($files[$key]);
			}
		}
		return $files;
	}

	// function to sort the files array
	function sortFiles($files, $field, $order_Dir) {
		if (strtolower(trim($order_Dir)) == 'desc') {
			usort($files, create_function('$a,$b', 'if ($a->' . $field . '== $b->' . $field .') return 0; return ($a->' . $field . '> $b->' . $field .') ? -1 : 1;'));
		} else {
			usort($files, create_function('$a,$b', 'if ($a->' . $field . '== $b->' . $field .') return 0; return ($a->' . $field . '< $b->' . $field .') ? -1 : 1;'));
		}
		return $files;
	}

	// function to delete one or more attached files
	function delete() {
		// initialize the database
		$db = &JFactory::getDBO();

		// import joomla clases to manage file system
		jimport('joomla.filesystem.file');

		// get the path to attachments upload
		$upload_folder = str_replace('\\',DS,$this->_config_values['upload_attachments']);
		$upload_folder = str_replace('/',DS,$upload_folder);
		$upload_folder = str_replace('&#92;',DS,$upload_folder);
		$path_upload = JPATH_ROOT.DS.$upload_folder;

		// read the ids of the records seleted for deletion
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		
		// delete files from the database and from the upload folder
		foreach($cid as $id) {
			// get the file name
			$file_name = JRequest::getVar( 'file_'.$id, '', 'post', 'string' );
			// delete it from the database
			$query = 'DELETE FROM #__aicontactsafe_messagefiles WHERE name = \''.$file_name.'\' AND id = '.$id.';';
			$db->setQuery( $query );
			$db->query();
			// delete it from the upload folder
			$file = $path_upload.DS.$file_name;
			if (JFile::exists($file)) {
				JFile::delete($file);
			}
		}
	}

}
?>
