<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Конттроллер редактора статей.
 */

class C_ArticlesEditor extends C_BaseAdmin
{
    private $mArticle;// экземпляр класса модели статей


    protected function before()
    {
        parent::before();

        $this->mArticle = M_Article::Instance();

        // Проверить право на работу со статьями
        if ( ! $this->mUsers->Can('USE_EDIT_ADD_ARTICLES'))
        {
            header('Location: index.php?c=editor');
            exit;
        }
    }


    /**
     * Экшн главной страницы редактора статей.
     */
    public function action_index()
    {
        // Название страницы
        $this->title .= ' :: Редактор статей';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml( 'v_articles_editor.php',
            array(
                'articles' => $this->mArticle->All() // массив содержит все статьи сайта
            )
        );
    }


    /**
     * Экшн добавления новой статьи.
     */
    public function action_add()
    {
        // Обработка отправки формы.
        if ($this->isPost())
        {
            // если новый пост сохранён
            if ( $this->mArticle->Add($_POST['title'], $_POST['content']) )
            {
                header('Location: index.php?c=ArticlesEditor');
                die();
            }

            // запомнить введённые пользователем данные
            // в случае ошибки
            $title = $_POST['title'];
            $content = $_POST['content'];

            // флаг вывода ошибок
            $error = true;
        }
        else
        {
            $title = '';
            $content = '';

            // флаг вывода ошибок
            $error = false;
        }

        $this->title .= ' :: Добавление статьи';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml(
            'v_article_add.php',
            array(
                'title' => $title, // название публикуемой статьи
                'content' => $content, // содержание публикуемой статьи
                'error' => $error // флаг вывода ошибок
            )
        );

    }


    /**
     * Экшн редактирования или удаления статьи.
     */
    public function action_edit()
    {
        // Обработка отправки формы.
        if ($this->isPost())
        {
            // Если изменения сохранены
            if ( $this->mArticle->Edit($_POST['id'], $_POST['title'], $_POST['content']) )
            {
                header('Location: index.php?c=ArticlesEditor');
                die();
            }

            // запомнить введённые пользователем данные
            // в случае ошибки
            $article['id_article'] = $_POST['id'];
            $article['title'] = $_POST['title'];
            $article['content'] = $_POST['content'];

            // флаг вывода ошибок
            $error = true;
        }
        // Если только пришли.
        elseif( isset($_GET['id']) )
        {
            // Если хотим удалить, удаляем
            if( isset($_GET['delete']) )
            {
                $this->mArticle->Delete($_GET['id']);
                header('Location: index.php?c=ArticlesEditor');
                exit;
            }

            // вытащить статью из базы
            $article = $this->mArticle->Get($_GET['id']);

            // если в базе нет такой статьи
            if( ! is_array($article) )
            {
                header('Location: index.php?c=ArticlesEditor');
                exit;
            }
            // флаг вывода ошибок
            $error = false;
        }
        // Если ломятся без параметра.
        else
        {
            header('Location: index.php?c=ArticlesEditor');
            exit;
        }

        // заголовок текущей страницы
        $this->title .= ' :: Редактирование статьи';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml(
            'v_article_edit.php',
            array(
                'article' => $article, // список статей
                'error' => $error // флаг вывода ошибок
            )
        );

    }
}