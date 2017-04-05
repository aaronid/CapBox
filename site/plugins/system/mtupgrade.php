<?php

/**
 * @version		$Id: mtupgrade.php 18130 2010-07-14 11:21:35Z louis $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.

 * Derivative work to have an insatallable plugin for old joomla version
 * @copyright	Copyright (C) 2010 C�dric KEIFLIN alias ced1870
 * http://www.ck-web-creation-alsace.com
 * http://www.joomlack.fr.nf
 * @license		GNU/GPL
 * version : 1.1
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemMTUpgrade extends JPlugin {

    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @access	protected
     * @param	object	$subject The object to observe
     * @param 	array   $config  An array that holds the plugin configuration
     * @since	1.0
     */
    function plgSystemMTUpgrade(& $subject, $config) {
        parent::__construct($subject, $config);
		
    }

    /**
     * onAfterInitialise handler
     *
     * Adds the mtupgrade folder to the list of directories to search for JHTML helpers.
     *
     * @access	public
     * @return null
     */
    function onAfterRoute() {
		
		/* Fonction pour gérer le chargement du plugin */
		
		// recupere l'ID de la page
		$id = JRequest::getInt('Itemid');
			
		// charge les parametres
		$IDs  = explode ("," , $this->params->get( 'pageselect', '0' ));
				
		// test, si on n'est pas bon on sort
		if (!in_array($id, $IDs) && $IDs[0] != 0) return false;
		
		/* fin de la fonction */
		
        $mainframe = & JFactory::getApplication();
        $document = & JFactory::getDocument();
        $doctype = $document->getType();

        // si pas en frontend, on sort
        if ($mainframe->isAdmin()) {
            return false;
        }


        // si pas HTML, on sort
        if ($doctype !== 'html') {
            return;
        }

        /*$menu = & JSite::getMenu();
        $active = $menu->getActive();
        $id = $active->id;
        if ($id == 1)
            return;*/

        JHTML::addIncludePath(JPATH_PLUGINS . DS . 'system' . DS . 'mtupgrade');
    }

}
