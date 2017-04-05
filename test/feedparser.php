<?php
	// inclusion de la classe magpierss
	require_once("magpierss/rss_fetch.inc");

	function FeedParser($url_feed, $nb_items_affiches=5)
	{
	  // lecture du fichier distant (flux XML)
	  $rss = fetch_rss($url_feed);

		$html = "";
	  // si la lecture s'est bien passee, on lit les elements
	  if (is_array($rss->items))
	  {
		// on ne recupere que les elements les + recents
		$items = array_slice($rss->items, 0, $nb_items_affiches);

		// debut de la liste
		// (vous pouvez indiquer un style CSS pour la formater)
		// boucle sur tous les elements
		foreach ($items as $item)
		{
		  $html .= "<li><a href=\"".$item['link']."\"?PHPSESSID=ab52323c22615d4b42fc9d5a05f384a6>";
		  $html .= "".utf8_encode($item['title'])."</a><br>".utf8_encode($item['description'])."</li>";
		}
	  }

	  // retourne le code HTML a inclure dans la page
	  return $html;
	}
?>