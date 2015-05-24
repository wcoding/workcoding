<?php 

namespace Classes\Controller\Admin;

use Classes\Controller\CBaseAdmin;
use Classes\Model\MArticle;
use Classes\Model\MComment;

/**
 * Контроллер модерирования комментариев
 */
class CCommentsEditor extends CBaseAdmin
{
    private $mArticle;// экземпляр класса модели статей
    private $mComments;// экземпляр класса модели комментариев к статье


    protected function before()
    {
        parent::before();

        $this->mArticle = MArticle::instance();
        $this->mComments = MComment::instance();

        // Проверить право на работу с комментариями
        if (! $this->mUsers->can('USE_EDIT_COMMENTS')) {
            $this->redirect('/editor');
        }
    }


    /**
     * Экшн главной страницы редактора комментариев.
     */
    public function actionIndex()
    {
        // Название страницы
        $this->title .= ' :: Редактор комментариев';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml('v_comments_editor.php');
    }
}
