<?php 

namespace Classes\Controller\Publicly;

use WorkCoding\Core;
use Classes\Controller\CBasePublicly;
use Classes\Model\MArticle;
use Classes\Model\MComment;

/**
 * Контроллер вывода статей для публичной части сайта.
 */
class CArticle extends CBasePublicly
{
    private $mArticle;// экземпляр класса модели статей
    private $mComments;// экземпляр класса модели комментариев к статье
    

    /**
     * Метод подготавливает данные, которые будут использоваться
     * в методе action_*
     */
    protected function before()
    {
        parent::before();
        $this->mArticle = MArticle::instance();
        $this->mComments = MComment::instance();
    }


    /**
     * Экшн чтения статьи.
     */
    public function actionIndex()
    {
        // Если параметры переданы через URL
        if (isset($this->params[0])) {

            // Извлечение статьи.
            $article = $this->mArticle->get($this->params[0]);

            // если в базе нет такой статьи
            if (! is_array($article)) {
                $this->notFound();
            }

            // Получить комментарии к статье
            $comments = $this->mComments->get($this->params[0]);
        } else {
            $this->notFound();
        }

        // Название страницы
        $this->title .= ' :: ' . $article['title'];

        // Флаг ошибки при комментировании
        $error = isset($this->params[1]) ? true : false;

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml(
            'v_post.php',
            array(
                'article' => $article, // ассоциативный массив выбраной статьи
                'comments' => $comments, // ассоциативный массив комментариев к статье
                'error' => $error, // флаг ошибки при комментировании
                'user' => $this->mUsers->get()
            )
        );
    }


    /**
     * Экшн добавления комментария, от пользователя.
     */
    public function actionComments()
    {
        if ($this->isPost() and 0 !== count($this->mUsers->get())) {
            $add = $this->mComments->add(
                $_POST['id'],
                $this->mUsers->get()['id_user'],
                Core::textOnly($_POST['message'])
            );
            
            if (0 < $add) {
                // если новый комментарий сохранён
                $this->redirect('/article/index/' . $_POST['id']);            
            } else {
                $this->redirect('/article/index/' . $_POST['id'] . '/error#comments');
            }
        }
        
        // если обратились к экшену напрямую
        $this->notFound();
    }
}
