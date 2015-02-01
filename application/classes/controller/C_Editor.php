<?php
/**
 * Конттроллер страницы "Консоль редактора".
*/
class C_Editor extends C_Base
{
	private $mArticle;// экземпляр класса модели статей
	
	
	function __construct()
	{
		$this->mArticle = new M_Article();
	}


	/**
	 * Экшн главной страницы консоли редактора.
	 */
	public function action_index(){
		
		// Название страницы
		$this->title .= ' :: Консоль редактора';
		
		// Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
		$this->content = $this->GetHtml( 'v_editor.php', array('articles' => $this->mArticle->all()) );	
	}


	/**
	 * Экшн добавления новой статьи.
	 */
	public function action_add(){

		// Обработка отправки формы.
		if (!empty($_POST))
		{
			// если новый пост сохранён
			if ( $this->mArticle->add($_POST['title'], $_POST['content']) )
			{
				header('Location: index.php?c=editor');
				die();
			}
			
			// запомнить введённые пользователем данные
			// в случае ошибки
			$title = $_POST['title'];
			$content = $_POST['content'];
			
			// флаг вывода ошибок
			$error = true;
		}
		else
		{
			$title = '';
			$content = '';
			
			// флаг вывода ошибок
			$error = false;
		}

		// Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
		$this->content = $this->GetHtml(
			'v_add.php', 
			array(
				'title' => $title, // название добавляемой статьи
				'content' => $content, // содержание добавляемой статьи
				'error' => $error // флаг вывода ошибок
				)
			);
	
	}


	/**
	 * Экшн редактирования или удаления статьи.
	 */
	public function action_edit(){
		
		// Обработка отправки формы.
		if ($this->isPost())
		{
			// если всё получилось
			if ( $this->mArticle->edit($_POST['id'], $_POST['title'], $_POST['content']) )
			{
				header('Location: index.php?c=editor');
				die();
			}
			
			// запомнить введённые пользователем данные
			// в случае ошибки
			$article['id_article'] = $_POST['id'];
			$article['title'] = $_POST['title'];
			$article['content'] = $_POST['content'];
			
			// флаг вывода ошибок
			$error = true;
		}
		// Только пришли.
		elseif(isset($_GET['id']))
		{	
			// если хотим удалить
			if(isset($_GET['delete']))
			{
				$this->mArticle->delete($_GET['id']);
				header('Location: index.php?c=editor');
				exit;
			}

			// вытащить статью
			$article = $this->mArticle->get($_GET['id']);
			
			// если в базе нет такой статьи
			if(!is_array($article)){
				header('Location: index.php?c=editor');
				exit;
			}
			// флаг вывода ошибок
			$error = false;
		}
		// Если ломятся без параметра.
		else
		{
			header('Location: index.php?c=editor');
			exit;
		}
	
		$this->title .= ' :: Редактирование';
		
		// Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
		$this->content = $this->GetHtml( 
			'v_edit.php', 
			array(
				'article' => $article, // список статей
				'error' => $error // флаг вывода ошибок
				) 
			);
		
	}
}
