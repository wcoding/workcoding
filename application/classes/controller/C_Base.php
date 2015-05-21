<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Базовый контроллер сайта.
*/
abstract class C_Base extends Controller
{
	protected $title;		// заголовок страницы
	protected $content;		// содержание страницы
	protected $mUsers;		// экземпляр класса менеджер пользователей


	function __construct()
	{
		$this->mUsers = M_User::instance();
	}


	/**
	 * Метод подготавливает данные, которые будут использоваться
	 * в методе action_*
	 */
	protected function before()
	{
		// Очистка старых сессий.
		$this->mUsers->clearSessions();

		$this->title = '';
		$this->content = '';
	}
	
	
	/**
	 * Генерация базового шаблона.
	 * Внутренний шаблон($this->content), который бал сформирован в action_*,
	 * передать в базовый шаблон и вывести на экран.
	 */
	public function render()
	{
		$vars = array('title' => $this->title, 'content' => $this->content);	
		$page = $this->getHtml('v_base_publicly.php', $vars);
		echo $page;
	}	
}
