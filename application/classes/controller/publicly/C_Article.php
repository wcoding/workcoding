<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Контроллер вывода статей для публичной части сайта.
 */
class C_Article extends C_BasePublicly
{
    private $mArticle;// экземпляр класса модели статей
    private $mComments;// экземпляр класса модели комментариев к статье


    function __construct()
    {
        $this->mArticle = M_Article::Instance();
        $this->mComments = M_Comment::Instance();
    }


    /**
     * Экшн чтения статьи.
     */
    public function action_index()
    {
        // Если параметры переданы через URL
        if(isset($this->params[0])){

            // Извлечение статьи.
            $article = $this->mArticle->Get($this->params[0]);

            // если в базе нет такой статьи
            if(!is_array($article)){
                $this->NotFound();
            }

            // Получить комментарии к статье
            $comments = $this->mComments->Get($this->params[0]);
        }
        else{
            $this->NotFound();
        }

        // Название страницы
        $this->title .= ' :: '.$article['title'];

        // Флаг ошибки при комментировании
        $error = isset($this->params[1]) ? true : false;

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml(
            'v_post.php',
            array(
                'article' => $article, // ассоциативный массив выбраной статьи
                'comments' => $comments, // ассоциативный массив комментариев к статье
                'error' => $error // флаг ошибки при комментировании
            )
        );
    }


    /**
     * Экшн добавления комментария, от пользователя.
     */
    public function action_comments()
    {

        if($this->IsPost()){

            // если новый комментарий сохранён
            if ( $this->mComments->Add($_POST['id'], $_POST['name'], $_POST['message']) )
                $this->Redirect('/article/index/'.$_POST['id']);

            // если не все поля были заполнены
            else
                $this->Redirect('/article/index/'.$_POST['id'].'/error#comments');
        }

        // если обратились к экшену напрямую
        $this->NotFound();
    }
}
