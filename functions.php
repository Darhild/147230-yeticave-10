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
 * Форматирует цену, округляя до целого числа, отделяя разряды пробелом и добавляя знак рубля

 * @param float $num Цена
 * @return string Отформатированная цена
 */
function count_time_diff($date) 
{
    $date_now = date_create("now");    
    $date_future = date_create($date);

    if ($date_future > $date_now) {
        $diff = date_diff($date_now, $date_future);
        $days_diff = date_interval_format($diff, "%d");
        $hours_diff = date_interval_format($diff, "%h");
        $minutes_before_date = date_interval_format($diff, "%i");
        $hours_before_date = $days_diff * 24 + $hours_diff;

        return [ $hours_before_date, $minutes_before_date ];        
    }
    else {
        return [ 0, 0 ];
    }    

}
