<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 01.02.2015
 * Time: 23:55
 */

class Core
{

    public function __construct(){}


    /**
     * Функция автозагрузки файла, в котором описан класс,
     * экземпляр которого мы пытаемся создать.
     *
     * @param string $classname имя файла котрый нужно подключить
     * @return void
     */
    public static function auto_load($classname){

        if( file_exists(SYSPATH."$classname.php") )
            include_once(SYSPATH."$classname.php");

        if( file_exists(CONTROLLER."$classname.php") )
            include_once(CONTROLLER."$classname.php");

        if( file_exists(MODEL."$classname.php") )
            include_once(MODEL."$classname.php");
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
     *      $arr = Core::GetConfig('database', $group = '');
     *      или
     *      $hostname = Core::GetConfig('database', 'MySQL.connection.hostname');
     *
     * @param string $filename название файла конфигурации
     * @param string $group путь из ключей в многомерном массиве, через точку
     * @return array|string возвращает конфиг-нный массив либо конкретное значение из этого массива
     */
    public static function GetConfig($filename, $group = '')
    {
        $config = array();

        // Если запрашиваемого файла не существует, вернуть пустой массив
        if ( !file_exists(APPPATH .'config'.DIRECTORY_SEPARATOR.$filename.'.php') )
            return $config;

        // Вытащить массив из файла конфигурации
        $config = (array)include(APPPATH .'config'.DIRECTORY_SEPARATOR.$filename.'.php');

        // Если хотим получить конкретное значение или элемент массива
        if ($group !== '')
        {
            // По ключу, достать элемент, из многомерного массива
            foreach(explode('.', $group) as $key){
                $config = $config[$key];
            }
        }

        return $config;
    }
}