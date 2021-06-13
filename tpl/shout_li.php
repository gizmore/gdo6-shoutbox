<?phpuse GDO\Shoutbox\GDO_Shoutbox;use GDO\User\GDO_User;use GDO\UI\GDT_Link;use GDO\UI\GDT_IconButton;/** @var $shout GDO_Shoutbox **/
?>
<li class="gdo6-shoutbox-message">
  <div>    <b><?=$shout->getCreator()->displayName()?></b>    <span><?=$shout->displayCreated()?></span>  </div>  <p><?=$shout->display('shout_text')?></p>  <?php if ($shout->canDelete(GDO_User::current())) : ?>  <?php echo GDT_IconButton::make()->href($shout->hrefEdit())->icon('edit')->render(); ?>  <?php endif; ?></li>