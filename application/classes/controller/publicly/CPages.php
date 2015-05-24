<?php 

namespace Classes\Controller\Publicly;

use Classes\Controller\CBasePublicly;

/**
 * Контроллер для страниц сайта(не для статей)
 */
class CPages extends CBasePublicly
{
    /**
     * Метод подготавливает данные, которые будут использоваться
     * в методе action_*
     */
    protected function before()
    {
        parent::before();
    }
}
