<?php
namespace GDO\Shoutbox\Method;

use GDO\Table\MethodQueryList;
use GDO\Shoutbox\GDO_Shoutbox;
use GDO\Core\GDT_Method;


final class Table extends MethodQueryList
{
    public function gdoTable()
    {
        return GDO_Shoutbox::table();
    }
    
    public function getDefaultOrder() { return 'shout_created DESC'; }
    
    public function getTitleLangKey()
    {
        return 'gdo_shoutbox';
    }
    
    public function getTableTitle()
    {
        return t('list_shoutbox_box', [$this->table->countItems()]);
    }
 
    public function getQuery()
    {
        return parent::getQuery()->where('shout_deleted IS NULL');
    }
    
    public function execute()
    {
        $response = parent::execute();
        return $response->addField(GDT_Method::with(Add::make()));
    }
    
}
