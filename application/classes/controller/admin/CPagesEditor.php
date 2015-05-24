<?php 

namespace Classes\Controller\Admin;

use Classes\Controller\CBaseAdmin;

/**
 * Контроллер добавление, редактирования страниц сайта
 */
class CPagesEditor extends CBaseAdmin
{
    protected function before()
    {
        parent::before();

        // Проверить право на добавление - редактирование страниц сайта
        if (! $this->mUsers->can('USE_ADD_EDIT_PAGES')) {
            $this->redirect('/editor');
        }
    }


    /**
     * Экшн главной страницы редактора страниц.
     */
    public function actionIndex()
    {
        // Название страницы
        $this->title .= ' :: Редактор страниц сайта';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml('v_pages_editor.php');
    }
}
