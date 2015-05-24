<?php 

namespace Classes\Controller;

use WorkCoding\Core;

/**
 * Базовый контроллер публичной части сайта.
 */
abstract class CBasePublicly extends CBase
{
    /**
     * Метод подготавливает данные, которые будут использоваться
     * в методе action_*
     */
    protected function before()
    {
        // Название публичной части сайта
        $this->title = Core::getConfig('settings', 'siteName');
    }
}
