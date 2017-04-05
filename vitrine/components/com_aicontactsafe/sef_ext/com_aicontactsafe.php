<?php
/**
 * sh404SEF support for com_aicontactsafe component.
 * Author : Alexandru Dobrin
 * contact : contact@algis.ro
 * 
 * {shSourceVersionTag: Version 2.0.1 - 2009-06-30}
 * 
 *    
 */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & shRouter::shGetConfig();  
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// remove common URL from GET vars list, so that they don't show up as query string in the URL
shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('lang');
if (!empty($Itemid))
  shRemoveFromGETVarsList('Itemid');
if (!empty($limit))  
shRemoveFromGETVarsList('limit');
if (isset($limitstart)) 
  shRemoveFromGETVarsList('limitstart'); // limitstart can be zero

// start by inserting the menu element title
$task = isset($task) ? @$task : null;

$Itemid = isset($Itemid) ? @$Itemid : null;

if (!empty($pf)) {
	$pf = (int)$pf;
	$query = 'SELECT name, id FROM `#__aicontactsafe_profiles` WHERE id = '.$pf;
	$database->setQuery($query);
	$sampleTitle = $database->loadObject();
	if ($sampleTitle) {
		$title[] = $sampleTitle->name;
		shRemoveFromGETVarsList('pf');
	}  
}
if ( count($title) == 0 ) {
	$shName = shGetComponentPrefix($option);
	$shName = empty($shName) ?  getMenuTitle($option, $task, $Itemid, null, $shLangName) : $shName;
	$shName = (empty($shName) || $shName == '/') ? 'Com':$shName;
	$title[] = $shName;
}

shRemoveFromGETVarsList('layout');
shRemoveFromGETVarsList('view');

// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null), 
      (isset($shLangName) ? @$shLangName : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------
  
?>
