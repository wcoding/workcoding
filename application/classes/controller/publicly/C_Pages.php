<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Контроллер для страниц сайта(не для статей)
 */
class C_Pages extends C_BasePublicly
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
