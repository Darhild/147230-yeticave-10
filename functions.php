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

