<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Класс модели комментариев к статье
 */

class M_Comment
{
    private static $instance; 	// ссылка на экземпляр класса
    private $dbase; 			// драйвер БД


    /**
     *  Получение единственного экземпляра (одиночка)
     *
     * @return M_Comment
     */
    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new M_Comment();

        return self::$instance;
    }


    public function __construct()
    {
        $this->dbase = MySQLDriver::Instance();
    }


    /**
     *  Получить комментарии к статье.
     *
     * @param	int		$id_article идентификатор статьи
     * @return	array	ассоциативный массив комментариев
     */
    public function Get($id_article)
    {
        // Запрос.
        $t = "SELECT *
			  FROM comments
			  WHERE article_id = '%d'";

        $query = sprintf($t, $id_article);

        return $this->dbase->Select($query);
    }


    /**
     *  Добавить комментарий.
     *
     * @param	int		$id_article идентификатор статьи
     * @param	string	$name   имя комментатора
     * @param	string	$message    текст комментария
     * @return	mixed	идентификатор нового комментария иначе false
     */
    public function Add($id_article, $name, $message)
    {
        // Подготовка.
        $name = trim($name);
        $message = trim($message);

        // Проверка.
        if ($name == '' or $message == '')
            return false;

        // Запрос.
        $obj = array();
        $obj['article_id'] = $id_article;
        $obj['name'] = $name;
        $obj['message'] = $message;

        return $this->dbase->Insert('comments', $obj);
    }

}