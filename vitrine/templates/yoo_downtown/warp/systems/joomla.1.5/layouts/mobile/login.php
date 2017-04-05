<?php if (JFactory::getUser()->get('guest')) : ?>

    <form action="<?php echo JRoute::_( 'index.php', true, false); ?>" method="post" name="login" id="form-login" >

        <p>
            <input type="text" name="username" placeholder="<?php echo JText::_('Username') ?>" />
        </p>
        <p>
            <input type="password" name="passwd" placeholder="<?php echo JText::_('Password') ?>" />
        </p>

        <input type="submit" name="Submit" class="button" value="Login" />

        <input type="hidden" name="option" value="com_user" />
        <input type="hidden" name="task" value="login" />
        <input type="hidden" name="return" value="<?php echo base64_encode(JRoute::_( 'index.php', true, false)); ?>" />
        <?php echo JHTML::_('form.token'); ?>
    </form>

<?php else: ?>

    <form action="index.php" method="post" name="login" id="form-login">

        <?php echo JText::sprintf('HINAME', JFactory::getUser()->get('name')); ?>

        <input type="submit" name="Submit" class="button" value="<?php echo JText::_( 'BUTTON_LOGOUT'); ?>" />

        <input type="hidden" name="option" value="com_user" />
        <input type="hidden" name="task" value="logout" />
        <input type="hidden" name="return" value="<?php echo base64_encode(JRoute::_( 'index.php', true, false)); ?>" />

    </form>

<?php endif; ?>