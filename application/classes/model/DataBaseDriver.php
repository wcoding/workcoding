<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 30.01.2015
 * Time: 23:29
 */

interface DataBaseDriver {

    /**
     * Выборка строк
     *
     * @param string $query полный текст SQL запроса
     * @return array массив выбранных объектов
     */
    public function Select($query);


    /**
     *  Вставка строки
     *
     * @param string $table имя таблицы
     * @param array $object ассоциативный массив с парами вида "имя столбца - значение"
     * @return int идентификатор новой строки
     */
    public function Insert($table, $object);


    /**
     *  Изменение строк
     *
     * @param string $table имя таблицы
     * @param array $object ассоциативный массив с парами вида "имя столбца - значение"
     * @param string $where условие (часть SQL запроса)
     * @return int число измененных строк
     */
    public function Update($table, $object, $where);


    /**
     *  Удаление строк
     *
     * @param string $table имя таблицы
     * @param string $where условие (часть SQL запроса)
     * @return int число удаленных строк
     */
    public function Delete($table, $where);
}