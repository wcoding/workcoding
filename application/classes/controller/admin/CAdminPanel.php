<?php 

namespace Classes\Controller\Admin;

use Classes\Controller\CBaseAdmin;

/**
 * Контроллер главной страницы администрирования сайта
 */
class CAdminPanel extends CBaseAdmin
{
    /**
     * Экшн главной страницы
     */
    public function actionIndex()
    {
        // Название страницы
        $this->title .= ' :: Главная';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml( 'v_admin_panel.php' );
    }
}
