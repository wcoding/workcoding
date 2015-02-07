<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Базовый контроллер Панели администрирования.
 */
abstract class C_BaseAdmin extends C_Base
{

    /**
     * Метод подготавливает данные, которые будут использоваться
     * в методе action_*
     */
    protected function before()
    {
        parent::before();

        // Если пользователь не зарегистрирован - отправляем на страницу регистрации.
        if ($this->mUsers->Get() == null)
        {
            header('Location: index.php?c=auth&act=login');
            exit;
        }

        // Простым пользователям нельзя в админку
        if ($this->mUsers->Can('USER'))
        {
            header('Location: index.php');
            exit;
        }

        // Переопределить название сайта
        $this->title = 'Панель администрирования';
    }


    /**
     * Генерация базового шаблона.
     * Внутренний шаблон($this->content), который бал сформирован в action_*,
     * передать в базовый шаблон и вывести на экран.
     */
    public function render()
    {
        $vars = array('title' => $this->title, 'content' => $this->content);
        $page = $this->GetHtml('v_base_admin.php', $vars);
        echo $page;
    }
}
