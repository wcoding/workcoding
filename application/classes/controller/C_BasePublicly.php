<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Базовый контроллер публичной части сайта.
 */
abstract class C_BasePublicly extends C_Base
{
    /**
     * Метод подготавливает данные, которые будут использоваться
     * в методе action_*
     */
    protected function before()
    {
        // Название публичной части сайта
        $this->title = Core::GetConfig('settings', 'siteName');
    }
}