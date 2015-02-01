<?php
/**
 * Базовый контроллер сайта.
*/
abstract class C_Base extends Controller
{
	protected $title;		// заголовок страницы
	protected $content;		// содержание страницы
	
	
	function __construct()
	{		
	}


	/**
	 * Метод подготавливает данные, которые будут использоваться
	 * в методе action_*
	 */
	protected function before()
	{
		$this->title = 'PHP. Уровень 2';
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
		$page = $this->GetHtml('v_base.php', $vars);				
		echo $page;
	}	
}
