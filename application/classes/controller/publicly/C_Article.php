<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Конттроллер вывода статей для публичной части сайта.
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
        if(isset($_GET['id'])){

            // Извлечение статьи.
            $article = $this->mArticle->get($_GET['id']);

            // если в базе нет такой статьи
            if(!is_array($article)){
                $this->NotFound();
            }

            // Получить комментарии к статье
            $comments = $this->mComments->get($_GET['id']);
        }
        else{
            $this->NotFound();
        }

        // Название страницы
        $this->title .= ' :: '.$article['title'];

        // Флаг ошибки при комментировании
        $error = isset($_GET['error']) ? true : false;

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
            if ( $this->mComments->add($_POST['id'], $_POST['name'], $_POST['message']) )
            {
                header("Location: index.php?c=article&id={$_POST['id']}");
                exit;
            }
            // если не все поля были заполнены
            else{
                header("Location: index.php?c=article&id={$_POST['id']}&error#comments");
                exit;
            }
        }

        // если обратились к экшену напрямую
        $this->NotFound();
    }
}
