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
	<tr><td width="100%"><h3><?php echo JText::_( 'Message statuses' ); ?></h3></td></tr>
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
			<?php echo JHTML::_('grid.sort', JText::_( 'Name' ), 'name', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="80" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', JText::_( 'Color' ), 'color', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="80" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', JText::_( 'Ordering' ), 'ordering', @$this->filter_order_Dir, @$this->filter_order ); ?>
			<?php echo JHTML::_('grid.order',  $this->rows ); ?>
		</th>
		<th width="60" class="title">
			<?php echo JHTML::_('grid.sort', JText::_( 'ID' ), 'id', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th align="center" width="80">
			<?php echo JHTML::_('grid.sort', JText::_( 'Date added' ), 'date_added', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th align="center" width="80">
			<?php echo JHTML::_('grid.sort', JText::_( 'Last update' ), 'last_update', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<td colspan="7">
			<?php echo $this->pageNav->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
<tbody>
	<?php
	if (count($this->rows) == 0) {
	?>
		<tr><td colspan="7" id="no_record">
			<?php echo JText::_( 'No record found !' ); ?>
		</td></tr>
	<?php
	} else {
		$k = 0;
		$i = 0;
		$n = count($this->rows);
		
		foreach($this->rows as $row) {
			$checked = JHTML::_('grid.id', $i, $row->id, false, 'cid');
			?>
			<tr class="row<?php echo $k; ?>">
				<td width="1" align="center"><?php echo $checked; ?></td>
				<td><a href="<?php echo $row->edit; ?>" class="aicontactsafe_edit"><?php echo $row->name; ?></a></td>
				<td align="center"><span style="color:<?php echo $row->color; ?>"><?php echo $row->color; ?></span></td>
				<td class="order">
					<span><?php echo $this->pageNav->orderUpIcon( $i, true, 'orderup', JText::_( 'Move Up' ), true ); ?></span>
					<span><?php echo $this->pageNav->orderDownIcon( $i, $n, true, 'orderdown', JText::_( 'Move Down' ), true );?></span>
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" class="text_area" style="text-align: center" />
				</td>
				<td align="center"><?php echo $row->id; ?></td>
				<td nowrap="nowrap" align="center">
					<?php echo JHTML::_('date',  $row->date_added, $this->_config_values['date_format'] ); ?>
				</td>
				<td nowrap="nowrap" align="center">
					<?php echo JHTML::_('date',  $row->last_update, $this->_config_values['date_format'] ); ?>
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
