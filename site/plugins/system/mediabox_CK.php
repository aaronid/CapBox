<?php

/**
 * @copyright	Copyright (C) 2010 Cédric KEIFLIN alias ced1870
 * http://www.ck-web-creation-alsace.com
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * version : 1.0
 * */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');

class plgSystemMediabox_CK extends JPlugin {

    function plgSystemMediabox_CK(&$subject, $config) {
        parent :: __construct($subject, $config);
        JHtml::stylesheet('mediaboxAdvBlack21.css', JUri::root() . 'plugins/system/mediabox_CK/', true);
    }

    function onAfterRender() {

        /* Fonction pour gérer le chargement du plugin */

        // recupere l'ID de la page
        $id = JRequest::getInt('Itemid');

        // charge les parametres
        $IDs = explode(",", $this->params->get('pageselect', '0'));

        // test, si on n'est pas bon on sort
        if (!in_array($id, $IDs) && $IDs[0] != 0)
            return false;

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


        $base = JURI::base();

        $variable = '';
        $variable .= "<script type=\"text/javascript\" src=\"" . $base . "plugins/system/mediabox_CK/mediaboxAdv-1.3.4b.js\"></script>\n";
        $variable .= "<script type=\"text/javascript\" src=\"" . $base . "plugins/system/mediabox_CK/quickie.js\"></script>\n";
        $variable .= "<script type=\"text/javascript\">
                    Mediabox.scanPage = function() {
                        var links = $$(\"a\").filter(function(el) {
                            return el.rel && el.rel.test(/^lightbox/i);
                        });
                        $$(links).mediabox({
                        overlayOpacity: 0.7,
                        playerpath: '".$base."plugins/system/mediabox_CK/NonverBlaster.swf'
                        }, null, function(el) {
                            var rel0 = this.rel.replace(/[[]|]/gi,\" \");
                            var relsize = rel0.split(\" \");
                            return (this == el) || ((this.rel.length > 8) && el.rel.match(relsize[1]));
                        });
                    };
                    window.addEvent(\"domready\", Mediabox.scanPage);
                    </script>";
        // renvoie les données dans la page
        $body = JResponse::getBody();
        $body = str_replace('</head>', $variable . '</head>', $body);
        JResponse::setBody($body);
    }

}

?>