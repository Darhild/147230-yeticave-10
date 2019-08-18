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
 * Возвращает массив с названиями классов для таймера в зависимости от того, сколько времени осталось до истечения лота

 * @param string $date Дата в формате "ГГГГ-ММ-ДД"
 * @return array Массив классов
 */
function return_timer_class($date) {
    $time = count_time_diff($date);
    $classes = ["lot__timer", "timer"];

    if ($time[0] < 1) {
        array_push($classes, "timer-finishing");
    }

    return $classes;
}

/**
 * Возвращает массив данных о том, сколько времени осталось до истечения лота, отформатированных с ведущими нулями

 * @param string $date Дата в формате "ГГГГ-ММ-ДД"
 * @return array Возвращённые данные
 */
function print_timer($date) {
    $time = count_time_diff($date);

    foreach($time as $num) {
        str_pad($num, 2, "0", STR_PAD_LEFT);
    }

    return $time;
}
