<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Контроллер модерирования комментариев
 */
class C_CommentsEditor extends C_BaseAdmin
{
    private $mArticle;// экземпляр класса модели статей
    private $mComments;// экземпляр класса модели комментариев к статье


    protected function before()
    {
        parent::before();

        $this->mArticle = M_Article::instance();
        $this->mComments = M_Comment::instance();

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
