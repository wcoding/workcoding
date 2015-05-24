<?php 

namespace WorkCoding;

/**
 * Класс с набором полезных методов
 */
class Core
{
    /**
     * Функция автозагрузки нужного класса.
     *
     * Файл который инклюдит эта функция должен лежать в любой из директорий фреймворка.
     * В этом файле должен быть описан, одноимённый с ним, класс, экземпляр которого,
     * где-то у себя в скрипте, мы пытаемся создать.
     *
     * @param string $classname имя файла котрый нужно подключить
     * @return void
     */
    public static function autoLoad($classname)
    {
        $name = str_replace('\\', '/', $classname);
        
        if (file_exists(SYSPATH . "$name.php")) {
            include_once(SYSPATH . "$name.php");
            return true;
        }

        if (file_exists(APPPATH . "$name.php")) {
            include_once(APPPATH . "$name.php");
            return true;
        }
        
        return false;
    }


    /**
     * Получить конфиг
     *
     *      ======================== database.php ===============================
     *      return array(
     *            'MySQL' => array(
     *                  'connection' => array(
     *                        'hostname' => 'localhost',
     *                        'username' => ....,
     *                  ),
     *            ),
     *            'PDO' => array(
     *                  'connection' => array(
     *                        'dsn'      => 'mysql:host=localhost;dbname=school',
     *                        'username' => ....
     *      )
     *      =====================================================================
     *
     *      $arr = Core::getConfig('database', $group = '');
     *      или
     *      $hostname = Core::getConfig('database', 'MySQL.connection.hostname');
     *
     * @param string $filename название файла конфигурации
     * @param string $group путь из ключей в многомерном массиве, через точку
     * @return array|string возвращает конфиг-нный массив либо конкретное значение из этого массива
     */
    public static function getConfig($filename, $group = '')
    {
        $config = array();

        // Если запрашиваемого файла не существует, вернуть пустой массив
        if (! file_exists(APPPATH . 'config' . DS . $filename . '.php')) {
            return $config;
        }

        // Вытащить массив из файла конфигурации
        $config = (array) include(APPPATH . 'config' . DS . $filename . '.php');

        // Если хотим получить конкретное значение или элемент массива
        if ($group !== '') {
            // По ключу, достать элемент, из многомерного массива
            foreach (explode('.', $group) as $key) {
                $config = $config[$key];
            }
        }

        return $config;
    }


    /**
     * Удалить из строки html-теги и лишние пробелы.
     *
     * @param  string $string
     * @return string 
     */    
    public static function textOnly($string)
    {
        $string = preg_replace ('/<[^>]*>/', ' ', $string);
        $string = str_replace("\r", '', $string);
        $string = str_replace("\n", ' ', $string);
        $string = str_replace("\t", ' ', $string);
        $string = trim(preg_replace('/ {2,}/', ' ', $string));

        return $string;
    }
}
