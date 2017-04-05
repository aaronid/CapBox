<?php
/**
* @package   Widgetkit Component
* @file      item.php
* @version   1.0.0 BETA 8 August 2011
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2011 YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/
	
	$id    = isset($id) ? $id : uniqid();
    $item  = isset($item) ? $item : array();

?>
<div id="<?php echo $id;?>" class="item box">

	<div class="deletable"></div>
    
	<h3 class="title">Item</h3>
    <div class="content">

        <?php foreach ($style_xml->xpath('fields/field') as $field) : ?>
        <div class="option">

	        <?php

	            $name  = (string) $field->attributes()->name;
	            $type  = (string) $field->attributes()->type;
	            $label = (string) $field->attributes()->label;
	            $name  = (string) $field->attributes()->name;
				$value = isset($item[$name]) ? $item[$name] : '';

	            echo "<h4>$label</h4>";
	            echo $this['field']->render($type, 'items['.$id.']['.$name.']', $value, $field, array('item'=>$item));
				
	        ?>

        </div>
        <?php endforeach;?>
		
    </div>
</div>