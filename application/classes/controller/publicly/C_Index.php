<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Контроллер главной страницы сайта сайта.
 */
class C_Index extends C_BasePublicly
{
    private $mArticle;// экземпляр класса модели статей


    /**
     * Метод подготавливает данные, которые будут использоваться
     * в методе action_*
     */
    protected function before()
    {
        parent::before();
        $this->mArticle = M_Article::instance();
    }


    /**
     * Экшн списка статей, на главной странице.
     */
    public function action_index()
    {
        // Вытащить все статьи.
        $articles = $this->mArticle->all();

        // Добавить краткое описание к каждой статье
        foreach ($articles as $key => $article) {
            $articles[$key]['intro'] = $this->mArticle->preview($article);
        }

        // Название страницы
        $this->title .= ' :: Главная';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml('v_index.php', array('articles' => $articles));
    }
}
