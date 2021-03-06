<?php 

namespace Classes\Model;

/**
 *  Класс модели статей.
 *
*/
class MArticle
{
	private static $instance; 	// ссылка на экземпляр класса
	private $dbase; 			// драйвер БД


	/**
	 *  Получение единственного экземпляра класса (одиночка)
	 *
	 * @return MArticle
     */
	public static function instance()
	{
		if (self::$instance == null) {
			self::$instance = new MArticle();
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
	 *  Список всех статей.
	 * 
	 * @return array ассоциативный массив
	*/
	public function all()
	{
		$query = "SELECT *
				  FROM articles
				  ORDER BY id_article DESC";

		return $this->dbase->select($query);
	}


	/**
	 *  Конкретная статья.
	 * 
	 * @param	int		$id_article		- идентификатор статьи
	 * @return	array	ассоциативный массив выбраной статьи
	*/
	public function get($id_article)
	{
		// Запрос.
		$t = "SELECT *
			  FROM articles
			  WHERE id_article = '%d'";

		$query = sprintf($t, $id_article);
		$result = $this->dbase->select($query);
		return $result[0];
	}


	/**
	 *  Добавить статью.
	 *
	 * @param	string	$title		- название статьи 
	 * @param	string	$content	- контент статьи
	 * @return	mixed	идентификатор новой статьи иначе false
	*/
	public function add($title, $content)
	{
		// Подготовка.
		$title = trim($title);
		$content = trim($content);

		// Проверка.
		if ($title == '') {
			return false;
        }

		// Запрос.
		$obj = array();
		$obj['title'] = $title;
		$obj['content'] = $content;

		return $this->dbase->insert('articles', $obj);
	}


	/**
	 *  Изменить статью.
	 * 
	 * @param	int		$id_article	- идентификатор статьи 
	 * @param	string	$title		- название статьи 
	 * @param	string	$content	- контент статьи
	 * @return	mixed	количество обновлённых строк иначе false
	*/
	public function edit($id_article, $title, $content)
	{
		// Подготовка.
		$title = trim($title);
		$content = trim($content);

		// Проверка.
		if ($title == '') {
			return 0;
        }

		// Запрос.
		$obj = array();
		$obj['title'] = $title;
		$obj['content'] = $content;

		$t = "id_article = '%d'";
		$where = sprintf($t, $id_article);

		return $this->dbase->update('articles', $obj, $where);
	}


	/**
	 *  Удалить статью.
	 * 
	 * @param	int		$id_article	- идентификатор статьи
	 * @return	int					- если больше нуля, то удалил
	*/
	public function delete($id_article)
	{
		// Запрос.
		$t = "id_article = '%d'";
		$where = sprintf($t, $id_article);

		return $this->dbase->delete('articles', $where);
	}


	/**
	 *  Короткое описание статьи.
	 *
	 * @param	array	$article - это ассоциативный массив, представляющий статью
	 * @return	string	
	*/
	function preview($article)
	{
		// убрать html
		$str = strip_tags($article['content']);
		// если, получившаяся строка больше 200 знаков, обрезать и добавить многоточие
		return (mb_strlen($str) > 200) ? mb_substr($str, 0, 200).'..' : $str;
	}
}
