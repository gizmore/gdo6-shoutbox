<?php
namespace GDO\Shoutbox;

use GDO\Core\GDO_Module;
use GDO\DB\GDT_Checkbox;
use GDO\UI\GDT_Page;
use GDO\UI\GDT_Link;
use GDO\DB\GDT_UInt;
use GDO\Date\GDT_Duration;
use GDO\User\GDO_User;
use GDO\Core\GDT_Method;
use GDO\Shoutbox\Method\Box;

/**
 * Shoutbox module.
 * 
 * @author gizmore
 * @version 6.10.4
 * @since 6.10.4
 */
final class Module_Shoutbox extends GDO_Module
{
    public function onLoadLanguage()
    {
        return $this->loadLanguage('lang/shoutbox');
    }
    
    public function getClasses()
    {
        return [
            GDO_Shoutbox::class,
        ];
    }
    
    public function getConfig()
    {
        return [
            GDT_Checkbox::make('shout_mails')->initial('1'),
            GDT_Checkbox::make('shout_guests')->initial('1'),
            GDT_Checkbox::make('shout_sidebar')->initial('1'),
            GDT_Checkbox::make('shout_sidebar_box')->initial('1'),
            GDT_Checkbox::make('shout_captcha_guests')->initial('1'),
            GDT_Checkbox::make('shout_captcha_member')->initial('0'),
            GDT_UInt::make('shout_boxsize')->initial('3'),
            GDT_Duration::make('shout_cooldown_guests')->initial('1m'),
            GDT_Duration::make('shout_cooldown_member')->initial('10s'),
        ];
    }
    public function cfgMail() { return $this->getConfigVar('shout_mails'); }
    public function cfgGuests() { return $this->getConfigVar('shout_guests'); }
    public function cfgSidebar() { return $this->getConfigVar('shout_sidebar'); }
    public function cfgSidebarBox() { return $this->getConfigVar('shout_sidebar_box'); }
    public function cfgBoxsize() { return $this->getConfigVar('shout_boxsize'); }
    public function cfgCooldownGuests() { return $this->getConfigValue('shout_cooldown_guests'); }
    public function cfgCooldownMember() { return $this->getConfigValue('shout_cooldown_member'); }
    public function cfgCooldown(GDO_User $user)
    {
        return $user->isMember() ?
            $this->cfgCooldownMember() :
            $this->cfgCooldownGuests();
    }
    public function cfgCaptchaGuests() { return $this->getConfigVar('shout_captcha_guests'); }
    public function cfgCaptchaMember() { return $this->getConfigVar('shout_captcha_member'); }
    public function cfgCaptcha(GDO_User $user)
    {
        return $user->isMember() ?
            $this->cfgCaptchaMember() :
            $this->cfgCaptchaGuests();
    }
    
    public function onInitSidebar()
    {
        if ($this->cfgSidebar())
        {
            if ($this->cfgSidebarBox())
            {
                GDT_Page::$INSTANCE->leftNav->addField(
                    GDT_Method::make()->method(Box::make()));
            }
            else
            {
                GDT_Page::$INSTANCE->leftNav->addField(
                    GDT_Link::make()->label('gdo_sidebar')->href(
                        href('Shoutbox', 'Table')));
            }
        }
    }
    
    public function onIncludeScripts()
    {
        $this->addCSS('css/gdo6-shoutbox.css');
        $this->addJS('js/gdo6-shoutbox.js');
    }
    
}
