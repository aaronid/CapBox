<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<?php if ($type == 'logout') : ?>

	<form class="short" action="index.php" method="post" name="login">
	
		<?php if ($params->get('greeting')) : ?>
		<div class="greeting">
			<?php if ($params->get('name')) : {
				echo JText::sprintf('HINAME', $user->get('name') );
			} else : {
				echo JText::sprintf('HINAME', $user->get('username') );
			} endif; ?>
		</div>
		<?php endif; ?>
	
		<div class="button">
			<button value="<?php echo JText::_('BUTTON_LOGOUT'); ?>" name="Submit" type="submit"><?php echo JText::_('BUTTON_LOGOUT'); ?></button>
		</div>
	
		<input type="hidden" name="option" value="com_user" />
		<input type="hidden" name="task" value="logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
	</form>

<?php else : ?>

	<?php
		if(JPluginHelper::isEnabled('authentication', 'openid')) {
			$lang->load('plg_authentication_openid', JPATH_ADMINISTRATOR );
			$langScript = 	'var JLanguage = {};'.
							' JLanguage.WHAT_IS_OPENID = \''.JText::_('WHAT_IS_OPENID').'\';'.
							' JLanguage.LOGIN_WITH_OPENID = \''.JText::_('LOGIN_WITH_OPENID').'\';'.
							' JLanguage.NORMAL_LOGIN = \''.JText::_('NORMAL_LOGIN').'\';'.
							' var modlogin = 1;';
			$document = &JFactory::getDocument();
			$document->addScriptDeclaration( $langScript );
			JHTML::_('script', 'openid.js');
		}
	?>
	
	<form class="short" action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" name="login">
	
		<?php if ($params->get('pretext')) : ?>
		<div class="pretext">
			<?php echo $params->get('pretext'); ?>
		</div>
		<?php endif; ?>
		
		<div class="username">
			<input type="text" name="username" size="18" placeholder="<?php echo JText::_('Username') ?>" />
		</div>
		
		<div class="password">
			<input type="password" name="passwd" size="18" placeholder="<?php echo JText::_('Password') ?>" />
		</div>
		
		<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
		<div class="remember">
			<?php $number = rand(); ?>
			<label for="modlgn_remember-<?php echo $number; ?>"><?php echo JText::_('Remember me') ?></label>
			<input id="modlgn_remember-<?php echo $number; ?>" type="checkbox" name="remember" value="yes" checked />
		</div>
		<?php endif; ?>
		
		<div class="button">
			<button value="<?php echo JText::_('LOGIN') ?>" name="Submit" type="submit"><?php echo JText::_('LOGIN') ?></button>
		</div>

		<ul class="blank">
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_user&view=reset'); ?>"><?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a>
			</li>
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_user&view=remind'); ?>"><?php echo JText::_('FORGOT_YOUR_USERNAME'); ?></a>
			</li>
			<?php
			$usersConfig = &JComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) : ?>
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_user&view=register'); ?>"><?php echo JText::_('REGISTER'); ?></a>
			</li>
			<?php endif; ?>
		</ul>
		
		<?php if($params->get('posttext')) : ?>
		<div class="posttext">
			<?php echo $params->get('posttext'); ?>
		</div>
		<?php endif; ?>
	
		<input type="hidden" name="option" value="com_user" />
		<input type="hidden" name="task" value="login" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHTML::_('form.token'); ?>
	</form>
	
	<script>
		jQuery(function($){
			$('form.short input[placeholder]').placeholder();
		});
	</script>
	
<?php endif; ?>