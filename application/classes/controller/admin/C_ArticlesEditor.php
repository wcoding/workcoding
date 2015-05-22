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

        $this->mArticle = M_Article::instance();

        // Проверить право на работу со статьями
        if (! $this->mUsers->can('USE_EDIT_ADD_ARTICLES')) {
            $this->redirect('/editor');
        }
    }


    /**
     * Экшн главной страницы редактора статей.
     */
    public function actionIndex()
    {
        // Название страницы
        $this->title .= ' :: Редактор статей';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml(
            'v_articles_editor.php',
            array(
                'articles' => $this->mArticle->all() // массив содержит все статьи сайта
            )
        );
    }


    /**
     * Экшн добавления новой статьи.
     */
    public function actionAdd()
    {
        // Обработка отправки формы.
        if ($this->isPost()) {
            // если новый пост сохранён
            if ($this->mArticle->add($_POST['title'], $_POST['content'])) {
                $this->redirect('/ArticlesEditor');
            }

            // запомнить введённые пользователем данные
            // в случае ошибки
            $title = $_POST['title'];
            $content = $_POST['content'];

            // флаг вывода ошибок
            $error = true;
        } else {
            $title = '';
            $content = '';

            // флаг вывода ошибок
            $error = false;
        }

        $this->title .= ' :: Добавление статьи';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml(
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
    public function actionEdit()
    {
        // Обработка отправки формы.
        if ($this->isPost()) {
            $edit = $this->mArticle->edit(
                $_POST['id'], 
                $_POST['title'], 
                $_POST['content']
            );
            
            // Если изменения сохранены
            if (0 < $edit) {
                $this->redirect('/ArticlesEditor');
            }

            // запомнить введённые пользователем данные
            // в случае ошибки
            $article['id_article'] = $_POST['id'];
            $article['title'] = $_POST['title'];
            $article['content'] = $_POST['content'];

            // флаг вывода ошибок
            $error = true;
            
        // Если только пришли.
        } elseif (isset($this->params[0])) {
            // Если хотим удалить, удаляем
            if (isset($this->params[1])) {
                $this->mArticle->delete($this->params[0]);
                $this->redirect('/ArticlesEditor');
            }

            // вытащить статью из базы
            $article = $this->mArticle->get($this->params[0]);

            // если в базе нет такой статьи
            if (! is_array($article)) {
                $this->redirect('/ArticlesEditor');
            }
            
            // флаг вывода ошибок
            $error = false;

        // Если ломятся без параметра.
        } else {
            $this->redirect('/ArticlesEditor');
        }

        // заголовок текущей страницы
        $this->title .= ' :: Редактирование статьи';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml(
            'v_article_edit.php',
            array(
                'article' => $article, // список статей
                'error' => $error // флаг вывода ошибок
            )
        );
    }
}
