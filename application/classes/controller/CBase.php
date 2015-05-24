<?php 

namespace Classes\Controller;

use Classes\Model\MUser;

/**
 * Базовый контроллер сайта.
*/
abstract class CBase extends Controller
{
	protected $title;		// заголовок страницы
	protected $content;		// содержание страницы
	protected $mUsers;		// экземпляр класса менеджер пользователей


	function __construct()
	{
		$this->mUsers = MUser::instance();
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
