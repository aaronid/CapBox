<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// add javascript
$warp = Warp::getInstance();
$warp['system']->document->addScript($warp['path']->url('js:search.js'));

?>

<form id="searchbox" action="<?php echo JRoute::_('index.php'); ?>" method="post" role="search">
	<input type="text" value="" name="searchword" placeholder="<?php echo JText::_('rechercher...'); ?>" />
	<button type="reset" value="Reset"></button>
	<input type="hidden" name="task"   value="search" />
	<input type="hidden" name="option" value="com_search" />
</form>

<script type="text/javascript">
jQuery(function($) {
	$('#searchbox input[name=searchword]').search({'url': '<?php echo JRoute::_("index.php?option=com_search&tmpl=raw&type=json&ordering=&searchphrase=all"); ?>', 'param': 'searchword', 'msgResultsHeader': '<?php echo JText::_("Résultats de la recherche"); ?>', 'msgMoreResults': '<?php echo JText::_("Plus de résultats"); ?>', 'msgNoResults': '<?php echo JText::_("Aucuns résultats trouvés"); ?>'}).placeholder();
});
</script>