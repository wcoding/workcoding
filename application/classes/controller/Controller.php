<?php
/**
 * Базовый класс контроллера.
*/
abstract class Controller
{
	/**
	 * Функция отрабатывающая до основного метода.
	*/
	protected abstract function before();


	/**
	 * Генерация внешнего шаблона.
	*/
	protected abstract function render();


	/**
	 * Последовательная обработка HTTP запроса. Сдесь вызываются методы класса
	 * который расширяет данный класс, Controller.
	 *
	 * @param string $action имя метода который должен отработать.
	*/
	public function Request($action)
	{
		$this->before();
		$this->$action();
		$this->render();
	}
	
	
	/**
	 * Запрос произведен методом GET?
	*/
	protected function IsGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}
	

	/**
	 * Запрос произведен методом POST?
	*/
	protected function IsPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}


	/**
	 *  Отдаёт HTML-шаблон, со вставленными в него данными.
	 * 
	 * @param	string	$fileName	имя файла, шаблона.
	 * @param	array	$vars	массив ['varName' => $value], где ключ это имя переменной в шаблоне.
	 * @return	string	
	*/
	protected function GetHtml($fileName, $vars = array())
	{
		// Установить переменные и их значения, для шаблона.
		foreach ($vars as $varName => $value)
		{
			$$varName = $value;
		}
		
		// Не выводить ничего на экран
		ob_start();
		
		// Передать в шаблон переменные, 
		// которые были установленны
		include VIEW.$fileName; 
		
		// Отдать готовый HTML
		return ob_get_clean();
	}


	/**
	 * Если вызвали метод, которого нет - завершаем работу.
	 */
	public function NotFound()
	{
		header("HTTP/1.0 404 Not Found");
		include(VIEW.'404.php');
		exit;
	}
	
	
	/**
	 * Если вызвали метод, которого нет - завершаем работу.
	*/
	public function __call($name, $params)
	{
		$this->NotFound();
	}

}