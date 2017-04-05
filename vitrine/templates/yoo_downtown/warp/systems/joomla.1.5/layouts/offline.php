<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// prepare filters
$filters = $this['assetfilter']->create(array('CSSImportResolver', 'CSSRewriteURL', 'CSSCompressor'));

?>
<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>">

<head>
	<title><?php echo $error; ?> - <?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo $this['path']->url('css:base.css'); ?>" />
	<link rel="stylesheet" href="<?php echo $this['path']->url('css:error.css'); ?>" />
	<!--[if IE 6]><style><?php echo $this['asset']->createFile('css:error-ie6.css')->getContent($filters); ?></style><![endif]-->
</head>

<body id="page" class="page">

	<div class="center error-<?php echo strtolower($error); ?>">

		<h1 class="error">
			<span><?php echo $error; ?></span>
		</h1>
		<h2 class="title"><?php echo $title; ?></h2>
		<p class="message"><?php echo $message; ?></p>

		<form class="short" action="index.php" method="post" name="login">
			<div class="username">
				<label for="username"><?php echo JText::_('Username') ?></label>
				<input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('Username') ?>" size="18" />
			</div>
			<div class="password">
				<label for="passwd"><?php echo JText::_('Password') ?></label>
				<input type="password" name="passwd" class="inputbox" size="18" alt="<?php echo JText::_('Password') ?>" id="passwd" />
			</div>
			<div class="remember">
				<label for="remember"><?php echo JText::_('Remember me') ?></label>
				<input type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_('Remember me') ?>" id="remember" />
			</div>
			
			<div class="button">
				<input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />
			</div>
			<input type="hidden" name="option" value="com_user" />
			<input type="hidden" name="task" value="login" />
			<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
			<?php echo JHTML::_( 'form.token' ); ?>
		</form>

	</div>
	
</body>
</html>