<?php 

namespace Classes\Model;

/**
 *  Класс модели пользователи.
 *
*/
class MUser
{	
    private static $instance;// экземпляр класса
    private $dbase;// драйвер БД
    private $sid;// идентификатор текущей сессии
    private $uid;// идентификатор текущего пользователя


    /**
     *  Получение единственного экземпляра класса (одиночка)
     *
     * @return MUser
    */
    public static function instance()
    {
        if (self::$instance == null)
            self::$instance = new MUser();

        return self::$instance;
    }


    private function __construct()
    {
        // Создать объект для работы с базой данных
        // и установить соединение
        $this->dbase = MySQLDriver::instance();

        // дефолтные значения полей класса
        $this->sid = null;
        $this->uid = null;
    }


    /**
     * Очистка неиспользуемых сессий
    */
    public function clearSessions()
    {
        $min = date('Y-m-d H:i:s', time() - 60 * 20); 			
        $t = "time_last < '%s'";
        $where = sprintf($t, $min);
        $this->dbase->delete('sessions', $where);
    }


    /**
     * @param string $login - логин
     * @param string $password - пароль
     * @param bool $remember - нужно ли запомнить в куках
     * @return bool - true или false
    */
    public function login($login, $password, $remember = true)
    {
        // вытаскиваем пользователя из БД 
        $user = $this->getByLogin($login);

        if ($user == null) {
            return false;
        }

        // Посолить пресный пароль :)
        $password = $password . SALTPASS;

        // проверяем пароль
        if ($user['password'] != md5($password)) {
            return false;
        }

        // запоминаем имя и md5(пароль)
        if (false !== $remember) {
            $expire = time() + 3600 * 24 * 100;
            setcookie('login', $login, $expire, BASEURL);
            setcookie('password', md5($password), $expire, BASEURL);
        }

        // открываем сессию и запоминаем SID
        $this->sid = $this->openSession($user['id_user']);

        return true;
    }


    /**
     * Вход
    */
    public function logout()
    {
        setcookie('login', '', time() - 1, BASEURL);
        setcookie('password', '', time() - 1, BASEURL);
        unset($_COOKIE['login']);
        unset($_COOKIE['password']);
        unset($_SESSION['sid']);		
        $this->sid = null;
        $this->uid = null;
    }


    /**
     * Добавить нового пользователя
     *
     * @param string $login - логин
     * @param string $password - пароль
     * @param string $username - имя пользователя
     * @param int $role - идентификатор роли пользователя(см. в базе)
     * @return bool|int - возвращает нуль если пользователь уже существует
    */
    public function add($login, $password, $username, $role)
    {
        // Подготовка.
        $login = trim($login);
        $password = trim($password);
        $username = trim($username);

        // Проверка.
        if ($login == '' or $password == '' or $username == '') {
            return false;
        }

        // Запрос.
        $obj = array();
        $obj['login'] = $login;
        $obj['password'] = md5($password . SALTPASS);
        $obj['name'] = $username;
        $obj['id_role'] = (int) $role;

        // Если такого пользователя нет ещё, то регистрируй
        if (null == $this->GetByLogin($login)) {
            return $this->dbase->Insert('users', $obj);
        }
        
        return 0;
    }


    /**
     * Изменить данные пользователя
     *
     * @param string $username - имя пользователя
     * @param string $password - пароль
     * @return bool|int - 1 если данные были заменены на новые
    */
    public function change($username, $password)
    {
        // Подготовка.
        $username = trim($username);
        $password = trim($password);

        // Получить данные пользователя
        $user = $this->get();

        // Если пользователя не существует, в сессии
        if ($user == null) {
            return false;
        }

        $obj = array();

        // Если надо менять имя
        if ($username !== '') {
            $obj['name'] = $username;
        } else {
            $obj['name'] = $user['name'];
        }

        // Если надо менять пароль
        if ($password !== '') {
            $obj['password'] = md5($password . SALTPASS);
        } else {
            $obj['password'] = $user['password'];
        }

        // Получить идентификатор пользователя
        $id = (int) $user['id_user'];

        $where = "id_user = $id";

        return $this->dbase->update('users', $obj, $where);
    }


    /**
     *  Получение пользователя
     *
     * @param null|int $id_user если не указан, брать текущего
     * @return array ассоциативный массив с данными пользователя
    */
    public function get($id_user = null)
    {
        $result = array();
        
        // Если id_user не указан, берем его по текущей сессии.
        if ($id_user == null) {
            $id_user = $this->getUid();
        }

        if ($id_user == null) {
            return $result;
        }

        // А теперь просто возвращаем пользователя по id_user.
        $t = "SELECT * FROM users WHERE id_user = '%d'";
        $query = sprintf($t, $id_user);
        $result = $this->dbase->select($query);
        
        return $result[0];		
    }


    /**
     * Получить список всех пользователей
     *
     * @return array массив данных всех пользователей, включая их роли
    */
    public function getAll()
    {
        $query = "SELECT users.id_user,
                    users.login,
                    users.name as username,
                    roles.id_role,
                    roles.name as rolename,
                    roles.description
               FROM users
               JOIN roles
               ON users.id_role = roles.id_role
               ORDER BY users.id_user";

        return $this->dbase->select($query);
    }


    /**
     * Получить список всех ролей
     *
     * @return array ассоциативный массив
    */
    public function getRoles()
    {
        $query = "SELECT * FROM roles";
        return $this->dbase->select($query);
    }


    /**
     * Редактировать данные пользователя
     *
     * @param int $id_user идентификатор пользователя, чьи данные изменить
     * @param string $username имя пользователя
     * @param int $id_role идентифмкатор роли пользователя
     * @return int
    */
    public function edit($id_user, $username, $id_role)
    {
        // Подготовка.
        $username = trim($username);
        $id_user = (int) $id_user;
        $id_role = (int) $id_role;

        // Проверка.
        if ($username == '') {
            return 0;
        }

        // Запрос.
        $obj = array();
        $obj['name'] = $username;
        $obj['id_role'] = $id_role;

        // Условие в запросе
        $where = "id_user = $id_user";

        return $this->dbase->update('users', $obj, $where);
    }


    /**
     * Получает пользователя по логину
     *
     * @param string $login логин пользователя
     * @return array ассоциативный массив с данными пользователя
    */
    public function getByLogin($login)
    {	
        $t = "SELECT * FROM users WHERE login = '%s'";
        $query = sprintf($t, mysql_real_escape_string($login));
        $result = $this->dbase->select($query);
        return $result[0];
    }


    /**
     * Проверка наличия привилегии
     *
     * @param string $priv - имя привилегии
     * @param int $id_user - если не указан, значит, для текущего
     * @return bool результат - true или false
    */
    public function can($priv, $id_user = null)
    {        
        // Получить данные пользователя
        $user = $this->get($id_user);

        // Если пользователя не существует, в сессии
        if ($user == null) {
            return false;
        }

        // Получить идентификатор роли пользователя
        $id_role = (int) $user['id_role'];

        // Я НЕ ПАРАНОИК. Нет?
        $priv = mysql_real_escape_string($priv);

        // Запрос привилегий
        $query = "SELECT count(*) as can
                FROM privs2roles
                JOIN privs
                ON privs2roles.id_priv = privs.id_priv
                WHERE id_role = $id_role
                AND privs.name = '$priv'";

        $result = $this->dbase->select($query);

        //           ($result[0]['can'] !== '0') ? true : false;
        return (bool) $result[0]['can'];
    }


    //
    // Проверка активности пользователя
    // $id_user		- идентификатор
    // результат	- true если online
    //
    public function isOnline($id_user)
    {		
        // ЕЩЁ НЕ НАШЁЛ ЭТОМУ ПРИМЕНЕНИЯ
        return false;
    }


    /**
     * Получение id текущего пользователя
     *
     * @return null|int результат - идентификатор пользователя, в базе
    */
    public function getUid()
    {	
        // Проверка кеша.
        if ($this->uid != null) {
            return $this->uid;
        }

        // Берем по текущей сессии.
        $sid = $this->getSid();

        if ($sid == null) {
            return null;
        }

        $t = "SELECT id_user FROM sessions WHERE sid = '%s'";
        $query = sprintf($t, mysql_real_escape_string($sid));
        $result = $this->dbase->select($query);

        // Если сессию не нашли - значит пользователь не авторизован.
        if (count($result) == 0) {
            return null;
        }

        // Если нашли - запоминм ее.
        $this->uid = $result[0]['id_user'];
        return $this->uid;
    }


    /**
     * Функция возвращает идентификатор текущей сессии
     *
     * @return null|string результат - SID
    */
    private function getSid()
    {
        // Проверка кеша.
        if ($this->sid != null) {
            return $this->sid;
        }

        // Ищем SID в сессии.
        $sid = isset($_SESSION['sid']) ? $_SESSION['sid'] : null;

        // Если нашли, попробуем обновить time_last в базе. 
        // Заодно и проверим, есть ли сессия там.
        if ($sid != null) {
            $session = array();
            $session['time_last'] = date('Y-m-d H:i:s'); 			
            $t = "sid = '%s'";
            $where = sprintf($t, mysql_real_escape_string($sid));
            $affected_rows = $this->dbase->update('sessions', $session, $where);

            if ($affected_rows == 0) {
                $t = "SELECT count(*) FROM sessions WHERE sid = '%s'";		
                $query = sprintf($t, mysql_real_escape_string($sid));
                $result = $this->dbase->select($query);

                if ($result[0]['count(*)'] == 0) {
                    $sid = null;
                }
            }
        }		

        // Нет сессии? Ищем логин и md5(пароль) в куках.
        // Т.е. пробуем переподключиться.
        if ($sid == null && isset($_COOKIE['login'])) {
            $user = $this->getByLogin($_COOKIE['login']);

            if ($user != null && $user['password'] == $_COOKIE['password']) {
                $sid = $this->openSession($user['id_user']);
            }
        }

        // Запоминаем в кеш.
        if ($sid != null) {
            $this->sid = $sid;
        }

        // Возвращаем, наконец, SID.
        return $sid;		
    }


    /**
     * Открытие новой сессии
     *
     * @param int $id_user идентификатор пользователя в БД
     * @return string результат - сгенерированный индетификатор сессии
    */
    private function openSession($id_user)
    {
        // генерируем SID
        $sid = $this->generateStr(10);

        // вставляем SID в БД
        $now = date('Y-m-d H:i:s'); 
        $session = array();
        $session['id_user'] = $id_user;
        $session['sid'] = $sid;
        $session['time_start'] = $now;
        $session['time_last'] = $now;
        $this->dbase->insert('sessions', $session);

        // регистрируем сессию в PHP сессии
        $_SESSION['sid'] = $sid;				

        // возвращаем SID
        return $sid;	
    }


    /**
     * Генерация случайной последовательности символов
     *
     * @param int $length сколько символов должно быть в строке
     * @return string некая строка
    */
    private function generateStr($length = 10)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;  

        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }

        return $code;
    }
}
