<?php
namespace GDO\Shoutbox\Method;

use GDO\DB\GDT_String;
use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Shoutbox\GDO_Shoutbox;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_Validator;
use GDO\Shoutbox\Module_Shoutbox;
use GDO\User\GDO_User;
use GDO\Core\Website;
use GDO\Date\Time;
use GDO\Mail\Mail;
use GDO\Captcha\GDT_Captcha;

/**
 * Add a shoutbox entry.
 * 
 *  - Checks for cooldown.
 *  - Sends moderation mail.
 *  
 * @author gizmore
 * @version 6.10.4
 */
class Add extends MethodForm
{
    public function saveLastUrl() { return false; }
    
    public function formName() { return 'form_shout'; }
    
    public function createForm(GDT_Form $form)
    {
        $table = GDO_Shoutbox::table();
        $form->addFields([
            $table->gdoColumn('shout_text'),
            GDT_Validator::make('cooldown')->validator('shout_text', [$this, 'validateCooldown']),
            GDT_AntiCSRF::make(),
        ]);
        if (Module_Shoutbox::instance()->cfgCaptcha(GDO_User::current()))
        {
            $form->addFieldAfter(GDT_Captcha::make(), 'cooldown');
        }
        $form->actions()->addField(GDT_Submit::make());
    }
    
    public function validateCooldown(GDT_Form $form, GDT_String $field, $value)
    {
        if ($shout = GDO_Shoutbox::lastShoutFrom(GDO_User::current()))
        {
            $age = $shout->getAge();
            $cooldown = Module_Shoutbox::instance()->cfgCooldown(GDO_User::current());
            $wait = $cooldown - $age;
            if ($wait > 0)
            {
                return $field->error('err_shout_cooldown', [Time::humanDuration($wait)]);
            }
        }
        return true;
    }
    
    public function formValidated(GDT_Form $form)
    {
        $user = GDO_User::current()->persistent();
        $shout = GDO_Shoutbox::blank([
            'shout_text' => $form->getFormVar('shout_text'),
        ])->insert();

        $module = Module_Shoutbox::instance();
        if ($module->cfgMail())
        {
            $this->sendMails($user, $shout);
        }

        return Website::redirectMessage('msg_shouted', null, Website::hrefBack());
    }
    
    public function sendMails(GDO_User $user, GDO_Shoutbox $shout)
    {
        foreach (GDO_User::staff() as $staff)
        {
            $this->sendMail($staff, $user, $shout);
        }
    }
    
    public function sendMail(GDO_User $staff, GDO_User $user, GDO_Shoutbox $shout)
    {
        $mail = Mail::botMail();
        $mail->setSubject(tusr($staff, 'mail_subj_shoutbox', [sitename()]));
        $mail->setBody(tusr($staff, 'mail_body_shoutbox', [
            $staff->displayName(),
            sitename(),
            $user->displayName(),
            $shout->display('shout_text'),
            url('Shoutbox', 'Delete', "&form[submit]=1&form[shout]={$shout->getID()}&form[token]={$shout->gdoHashcode()}"),
        ]));
        $mail->sendToUser($staff);
    }
    
}
