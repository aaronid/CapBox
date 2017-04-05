<?php
/**
 * @version     $Id$ 2.0.7 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// don't remove anything above this text

// you have in the array "$fields" all the information entered in the contact form ( including values in fld_value )?>

<html>
<body>
<p>Merci pour votre question, nous vous répondrons dans les meilleurs délais. vous trouverez ci-dessous une copie de votre message.</p>

<table border="0" cellpadding="0" cellspacing="2">
<?php foreach($fields as $field) { ?>
<tr>
<td><span <?php echo $field->label_message_parameters; ?> > <?php echo $field->field_label_message; ?></span></td>
<td> </td>
<td> <?php echo ($field->field_type == 'FL')?$field->fld_link:$field->fld_value; ?></td>
</tr>
<?php } ?>
</table>
<p>CAPBOX vous remercie</p>
</body>
</html>