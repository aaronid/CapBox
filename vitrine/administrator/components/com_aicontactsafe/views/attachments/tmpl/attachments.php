<?php
/**
 * @version     $Id$ 2.0.7 0
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

<table>
	<tr><td width="100%"><h3><?php echo JText::_( 'Attachments' ); ?></h3></td></tr>
	<tr><td>
		<input type="text" name="filter_string" id="filter_string" value="<?php echo $this->filter_string;?>" class="text_area" onchange="document.adminForm.submit();" title="<?php echo JText::_( 'Filter by name' );?>"/>
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('filter_string').value='';document.getElementById('filter_order').value='';document.getElementById('filter_order_Dir').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
	</td></tr>
</table>

<table class="adminlist" cellspacing="1">
<thead>
	<tr>
		<th width="1">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
		</th>
		<th class="title">
			<?php echo JHTML::_('grid.sort', JText::_( 'File' ), 'name', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th class="title">
			<?php echo JHTML::_('grid.sort', JText::_( 'Name' ), 'ms_name', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="120" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', JText::_( 'Email' ), 'ms_email', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', JText::_( 'Subject' ), 'ms_subject', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="80" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', JText::_( 'Sender\'s ip' ), 'ms_sender_ip', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th class="title">
			<?php echo JHTML::_('grid.sort', JText::_( 'Status' ), 'recorded_text', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="60" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', JText::_( 'ID' ), 'id', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th align="center" width="80">
			<?php echo JHTML::_('grid.sort', JText::_( 'Date added' ), 'date_added', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<td colspan="9">
			<?php echo $this->pageNav->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
<tbody>
	<?php
	if (count($this->rows) == 0) {
	?>
		<tr><td colspan="9" id="no_record">
			<?php echo JText::_( 'No record found !' ); ?>
		</td></tr>
	<?php
	} else {
		$k = 0;
		$i = 0;

		foreach($this->rows as $row) {
			$checked = JHTML::_('grid.id', $i, $row->id, false, 'cid');
			?>
			<tr class="row<?php echo $k; ?>"  style="color:<?php echo $row->color; ?>;">
				<td width="1" align="center"><?php echo $checked; ?><input type="hidden" id="file_<?php echo $row->id; ?>" name="file_<?php echo $row->id; ?>" value="<?php echo $row->name; ?>" /></td>
				<td align="left"><?php echo $row->name; ?></td>
				<td align="left"><?php echo $row->ms_name; ?></td>
				<td align="left"><?php echo $row->ms_email; ?></td>
				<td align="left"><?php echo $row->ms_subject; ?></td>
				<td align="left"><a class="aiContactSafe" href="http://whois.domaintools.com/<?php echo $row->ms_sender_ip; ?>" target="_blank"><?php echo $row->ms_sender_ip; ?></a></td>
				<td align="left"><?php echo $row->recorded_text; ?></td>
				<td align="center"><?php echo $row->id; ?></td>
				<td nowrap="nowrap" align="center">
					<?php echo JHTML::_('date',  $row->date_added, $this->_config_values['date_format'] ); ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
			$i += 1;
		}
	}
	?>
</tbody>
</table>

<?php 
	// footer of the adminForm
	// don't remove this line
	echo $this->getTmplFooter();
?>
