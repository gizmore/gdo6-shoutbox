<?php
namespace GDO\Shoutbox;

use GDO\Core\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_DeletedAt;
use GDO\DB\GDT_DeletedBy;
use GDO\DB\GDT_String;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_EditedAt;
use GDO\DB\GDT_EditedBy;
use GDO\User\GDO_User;
use GDO\Core\GDT_Template;
use GDO\Date\Time;

/**
 * Shoutbox table/entity.
 * @author gizmore
 */
final class GDO_Shoutbox extends GDO
{
    public function gdoColumns()
    {
        return [
            GDT_AutoInc::make('shout_id'),
            GDT_String::make('shout_text')->min(3)->max(256)->notNull(),
            GDT_CreatedAt::make('shout_created'),
            GDT_CreatedBy::make('shout_creator'),
            GDT_EditedAt::make('shout_edited'),
            GDT_EditedBy::make('shout_editor'),
            GDT_DeletedAt::make('shout_deleted'),
            GDT_DeletedBy::make('shout_deletor'),
        ];
    }
    public function getAge() { return Time::getAgo($this->getCreated()); }
    public function getCreated() { return $this->getVar('shout_created'); }
    public function displayCreated() { return Time::displayDate($this->getCreated()); }
    public function getCreator() { return $this->getValue('shout_creator'); }
    public function hrefEdit() { return href('Shoutbox', 'Edit', "&id={$this->getID()}"); }
    
    ###################
    ### Permissions ###
    ###################
    public function canDelete(GDO_User $user)
    {
        if ($user->isStaff())
        {
            return true;
        }
        return false;
    }
    ##############
    ### Static ###
    ##############
    public static function lastShoutFrom(GDO_User $user)
    {
        return self::table()->select()->
            where("shout_creator={$user->getID()}")->
            order('shout_created DESC')->
            first()->exec()->fetchObject();
    }
    
    ##############
    ### Render ###
    ##############
    public function renderList()
    {
        return GDT_Template::php('Shoutbox', 'shout_li.php', ['shout' => $this]);
    }
    
}
