<?php
namespace GDO\Shoutbox\Method;

use GDO\Shoutbox\GDO_Shoutbox;
use GDO\Core\GDT_Method;
use GDO\UI\GDT_Link;
use GDO\Table\MethodQueryList;
use GDO\Shoutbox\Module_Shoutbox;
use GDO\Table\GDT_Table;

final class Box extends MethodQueryList
{
    public function isOrdered() { return false; }
    public function isSearched() { return false; }
    
    public function getDefaultIPP()
    {
        return Module_Shoutbox::instance()->cfgBoxsize();
    }
    
    public function getDefaultOrder() { return 'shout_created DESC'; }
    
    public function gdoTable()
    {
        return GDO_Shoutbox::table();
    }
    
    public function execute()
    {
        $add = AddSidebar::make();
        $add->getForm()->slim();
        return parent::execute()->addFieldFirst(
            GDT_Link::make('link_shoutbox')->label('gdo_shoutbox')->
                href(href('Shoutbox', 'Table')))->addField(
                    GDT_Method::make()->method($add));
    }
    
    public function setupCollection(GDT_Table $table)
    {
        parent::setupCollection($table);
        $table->headers->name = 'sht';
        GDT_Table::$ORDER_NAME--;
        return $table;
    }
    
}
