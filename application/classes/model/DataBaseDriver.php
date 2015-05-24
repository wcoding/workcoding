<?php 

namespace Classes\Model;

/**
 * Интерфейс работы с базой данных
 */
interface DataBaseDriver
{
    /**
     * Выборка строк
     *
     * @param string $query полный текст SQL запроса
     * @return array массив выбранных объектов
     */
    public function select($query);


    /**
     *  Вставка строки
     *
     * @param string $table имя таблицы
     * @param array $object ассоциативный массив с парами вида "имя столбца - значение"
     * @return int идентификатор новой строки
     */
    public function insert($table, $object);


    /**
     *  Изменение строк
     *
     * @param string $table имя таблицы
     * @param array $object ассоциативный массив с парами вида "имя столбца - значение"
     * @param string $where условие (часть SQL запроса)
     * @return int число измененных строк
     */
    public function update($table, $object, $where);


    /**
     *  Удаление строк
     *
     * @param string $table имя таблицы
     * @param string $where условие (часть SQL запроса)
     * @return int число удаленных строк
     */
    public function delete($table, $where);
}