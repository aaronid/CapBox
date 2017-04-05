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
<p>C'est avec plaisir que nous vous offrons un test gratuit de 30 jours CAPBOX. Vous trouverez ci-aprés les coordonnées qui ont été transmis à CAPBOX :</p>

<table border="0" cellpadding="0" cellspacing="2">
<?php foreach($fields as $field) { ?>
<tr>
<td><span <?php echo $field->label_message_parameters; ?> > <?php echo $field->field_label_message; ?></span></td>
<td> </td>
<td> <?php echo ($field->field_type == 'FL')?$field->fld_link:$field->fld_value; ?></td>
</tr>
<?php } ?>
</table>
<p>Nous vous remercions et nous vous contacterons au plus vite pour vous faire suivre votre code d'activation.</p>
<p>Cordialement, l'équipe CAPBOX.</p>
</body>
</html>