<?php
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

        $this->mArticle = M_Article::Instance();
        $this->mComments = M_Comment::Instance();

        // Проверить право на работу с комментариями
        if ( ! $this->mUsers->Can('USE_EDIT_COMMENTS'))
        {
            header('Location: index.php?c=editor');
            exit;
        }
    }


    /**
     * Экшн главной страницы редактора комментариев.
     */
    public function action_index(){

        // Название страницы
        $this->title .= ' :: Редактор комментариев';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml( 'v_comments_editor.php' );
    }

}