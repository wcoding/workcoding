<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Контроллер главной страницы администрирования сайта
 */
class C_AdminPanel extends C_BaseAdmin
{
    /**
     * Экшн главной страницы
     */
    public function action_index()
    {
        // Название страницы
        $this->title .= ' :: Главная';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml( 'v_admin_panel.php' );
    }
}
