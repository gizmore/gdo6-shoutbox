<?php
namespace GDO\Shoutbox\Method;

use GDO\Form\MethodCrud;
use GDO\Shoutbox\GDO_Shoutbox;

/**
 * Edit or delete a Shout.
 * @author gizmore
 */
final class Edit extends MethodCrud
{
    public function hrefList()
    {
        return href('Shoutbox', 'Table');
    }

    public function gdoTable()
    {
        return GDO_Shoutbox::table();
    }
    
}
