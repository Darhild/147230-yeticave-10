<?php
/**
 * Форматирует цену, округляя до целого числа, отделяя разряды пробелом и добавляя знак рубля
 * @param float $num Цена
 * @return string Отформатированная цена
 */
function format_price($num)
{
    $formated_num = ceil($num);

    if ($num >= 1000) {
        $formated_num = number_format($num, 0, "", " ");
    }

    $formated_num .= " ₽";
    return $formated_num;
}
/**
 * Рассчитывает временной интервал от текущего момента до переданной даты
 * @param string $date Дата в формате "ГГГГ-ММ-ДД"
 * @return array Часы и минуты, остающиеся до наступления указанной даты
 */
function count_time_diff($date)
{
    $date_now = date_create("now");
    $date_future = date_create($date);
    $hours_before_date = 0;
    $minutes_before_date = 0;

    if ($date_future > $date_now) {
        $diff = date_diff($date_now, $date_future);
        $days_diff = date_interval_format($diff, "%a");
        $hours_diff = date_interval_format($diff, "%h");
        $minutes_before_date = date_interval_format($diff, "%i");
        $hours_before_date = $days_diff * 24 + $hours_diff;
    }

    return [ $hours_before_date, $minutes_before_date ];
}

/**
 * Возвращает дополнительное название класса, если до истечения лота осталось меньше часа

 * @param string $date Дата в формате "ГГГГ-ММ-ДД"
 * @return string Массив классов
 */
function return_timer_class($date)
{
    $time = count_time_diff($date);
    $class = "";

    if ($time[0] < 1) {
        $class = " timer--finishing";
    }

    return $class;
}

/**
 * Возвращает массив данных о том, сколько времени осталось до истечения лота, отформатированных с ведущими нулями

 * @param string $date Дата в формате "ГГГГ-ММ-ДД"
 * @return array Возвращённые данные
 */
function print_timer($date)
{
    $time = count_time_diff($date);

    foreach($time as &$num) {
        $num = str_pad($num, 2, "0", STR_PAD_LEFT);
    }

    return $time;
}

/**
 * Возвращает массив всех данных из таблицы category

 * @param mysqli $con Подключение к ДБ
 * @return array Массив данных из таблицы category
 */
function getCategories($con)
{
    $data = [];

    $sql = "SELECT * FROM category";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $data;
}

/**
 * Возвращает результат запроса к БД с данными таблицы лотов, категорией лота и его текущей ценой

 * @param mysqli $con Подключение к ДБ
 * @param string $condition Дополнительное условие запроса к БД, по умолчанию равно пустой строке
 * @return mysqli_result Результат запроса к БД
 */
function prepareLotsQuery($con, $condition = "")
{
    $sql = "SELECT 
                  lots.*,            
                  IFNULL(lots.current_price, lots.start_price) as price
            FROM (
                    SELECT l.*,
                           c.name as category,
                           (   
                               SELECT value
                               FROM bid as b
                               WHERE b.lot_id = l.id
                               ORDER BY b.value DESC
                               LIMIT 1
                           ) as current_price
                    FROM lot as l
                    JOIN category as c
                    ON l.category_id = c.id "
                    . $condition .
                ") as lots ";

    $result = mysqli_query($con, $sql);
    return $result;
}

/**
 * Возвращает массив с данными открытых лотов из таблицы lot, название категории, к которой принадлежит лот, и его текущую цену с учётом ставок

 * @param mysqli $con Подключение к ДБ
 * @return array Массив данных из таблицы lot
 */
function getActiveLots($con)
{
    $data = [];
    $condition = "WHERE l.date_expire > NOW() ORDER BY l.date_expire ASC";
    $result = prepareLotsQuery($con, $condition);

    if($result) {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $data;
}

/**
 * Возвращает значение указанного параметра из строки запроса

 * @param string $param Параметр, получаемый из строки запроса
 * @return string Значение параметра
 */
function getParamFromQuery($param)
{
    $result = $_GET[$param] ?? "";

    return $result;
}

/**
 * Возвращает массив с данными лота, соответствующего переданному id, название категории, к которой принадлежит лот, и его текущую цену с учётом ставок

 * @param mysqli $con Подключение к ДБ
 * @param string $id Идентификатор лота
 * @return array Массив данных из таблицы lot
 */
function getLotById($con, $id)
{
    $data = [];
    $condition = "WHERE l.id = $id";
    $result = prepareLotsQuery($con, $condition);

    if($result) {
        $data = mysqli_fetch_assoc($result);
    }

    return $data;
}



