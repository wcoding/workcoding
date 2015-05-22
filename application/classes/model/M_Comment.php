<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Класс модели комментариев к статье
 */
class M_Comment
{
    private static $instance;// ссылка на экземпляр класса
    private $dbase;// драйвер БД


    /**
     *  Получение единственного экземпляра (одиночка)
     *
     * @return M_Comment
     */
    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new M_Comment();
        }

        return self::$instance;
    }


    private function __construct()
    {
        // Создать объект для работы с базой данных
        // и установить соединение
        $this->dbase = MySQLDriver::instance();
    }


    /**
     *  Получить комментарии к статье.
     *
     * @param	int	$id_article идентификатор статьи
     * @return	array	ассоциативный массив комментариев
     */
    public function get($id_article)
    {
        // Запрос.
        $t = "SELECT comments.message, users.name
            FROM comments
            JOIN users
            ON users.id_user = comments.user_id
            WHERE comments.article_id = '%d'";

        $query = sprintf($t, $id_article);

        return $this->dbase->select($query);
    }


    /**
     *  Добавить комментарий.
     *
     * @param	int	$id_article  идентификатор статьи
     * @param	int	$user_id  id комментатора
     * @param	string $message  текст комментария
     * @return	int  идентификатор нового комментария
    */
    public function add($id_article, $user_id, $message)
    {
        // Подготовка.
        $message = trim($message);

        // Проверка.
        if ($message == '') {
            return 0;
        }

        // Запрос.
        $obj = array();
        $obj['article_id'] = $id_article;
        $obj['user_id'] = $user_id;
        $obj['message'] = $message;

        return $this->dbase->insert('comments', $obj);
    }
}
