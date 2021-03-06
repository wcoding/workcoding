<?php 

namespace Classes\Controller;

/**
 * Базовый контроллер Панели администрирования.
 */
abstract class CBaseAdmin extends CBase
{
    /**
     * Метод подготавливает данные, которые будут использоваться
     * в методе action_*
     */
    protected function before()
    {
        parent::before();

        // Если пользователь не зарегистрирован - отправляем на страницу регистрации.
        if (count($this->mUsers->get()) === 0) {
            $this->redirect('/auth/login');
        }

        // Простым пользователям нельзя в админку
        if ($this->mUsers->can('USER')) {
            // Редирект на главную страницу
            $this->redirect();
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
        $page = $this->getHtml('v_base_admin.php', $vars);
        echo $page;
    }
}
