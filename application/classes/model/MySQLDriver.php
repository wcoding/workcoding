<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Помощник работы с БД
*/
class MySQLDriver implements DataBaseDriver
{
	private static $instance; // ссылка на экземпляр класса


	/**
	 * Получение единственного экземпляра класса (одиночка).
	 * От начала до завершения работы скрипта, должено существовать
	 * не более одного экземпляра этого класса.
	 *
	 * @return MySQLDriver
	 */
	public static function Instance()
	{
		// Создать, если экземпляр класса MySQLDriver, ещё не был создан
		if (self::$instance == null)
			self::$instance = new MySQLDriver();
		
		return self::$instance;
	}


	/**
	 * Установка соединения с базой данных
     */
	private function __construct()
	{
		// получить массив из конфига(/application/config/database.php)
		$config = Core::GetConfig('database');

		// Подключение к СУБД.
		$connect = mysql_connect(
			$config['hostname'],
			$config['username'],
			$config['password']
		) or die('No connect with data base');

		// Установить кодировку по умолчанию, для текущего соединения
		mysql_set_charset($config['charset'], $connect);

		// Выбрать БД, с которой будим работать.
		mysql_select_db($config['database']) or die('No data base');
	}


	/**
	 * Выборка строк
	 *
	 * @param string $query полный текст SQL запроса
	 * @return array ассоциативный массив выбранных объектов
     */
	public function Select($query)
	{
		$result = mysql_query($query);
		
		if (!$result)
			die(mysql_error());
		
		$n = mysql_num_rows($result);
		$arr = array();
	
		for($i = 0; $i < $n; $i++)
		{
			$row = mysql_fetch_assoc($result);		
			$arr[$i] = $row;
		}

		return $arr;
	}


	/**
	 *  Вставка строки
	 *
	 *        "INSERT INTO $table (key_for_$object,...) VALUES ('value_for_$object',...)"
	 *
	 * @param string $table имя таблицы
	 * @param array $object ассоциативный массив с парами вида "имя столбца - значение"
	 * @return int идентификатор новой строки
     */
	public function Insert($table, $object)
	{			
		$columns = array(); 
		$values = array(); 
	
		foreach ($object as $key => $value)
		{
			$key = mysql_real_escape_string($key . '');
			$columns[] = $key;
			
			if ($value === null)
			{
				$values[] = 'NULL';
			}
			else
			{
				$value = mysql_real_escape_string($value . '');							
				$values[] = "'$value'";
			}
		}

		$columns_s = implode(',', $columns);
		$values_s = implode(',', $values);  
			
		$query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
		$result = mysql_query($query);
								
		if (!$result)
			die(mysql_error());
			
		return mysql_insert_id();
	}


	/**
	 *  Изменение строк
	 *
	 *        "UPDATE $table SET key_for_$object = 'value_for_$object',... WHERE $where"
	 *
	 * @param string $table имя таблицы
	 * @param array $object ассоциативный массив с парами вида "имя столбца - значение"
	 * @param string $where условие (часть SQL запроса)
	 * @return int число измененных строк
     */
	public function Update($table, $object, $where)
	{
		$sets = array();
	
		foreach ($object as $key => $value)
		{
			$key = mysql_real_escape_string($key . '');
			
			if ($value === null)
			{
				$sets[] = "$value=NULL";			
			}
			else
			{
				$value = mysql_real_escape_string($value . '');					
				$sets[] = "$key='$value'";			
			}			
		}

		$sets_s = implode(',', $sets);			
		$query = "UPDATE $table SET $sets_s WHERE $where";
		$result = mysql_query($query);
		
		if (!$result)
			die(mysql_error());

		return mysql_affected_rows();	
	}


	/**
	 *  Удаление строк
	 *
	 * @param string $table имя таблицы
	 * @param string $where условие (часть SQL запроса)
	 * @return int число удаленных строк
     */
	public function Delete($table, $where)
	{
		$query = "DELETE FROM $table WHERE $where";		
		$result = mysql_query($query);
						
		if (!$result)
			die(mysql_error());

		return mysql_affected_rows();	
	}
}
