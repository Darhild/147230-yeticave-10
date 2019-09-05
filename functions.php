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
    [$hoursLeft] = count_time_diff($date);

    if ($hoursLeft < 1) {
        return " timer--finishing";
    }

    return "";
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
function get_categories($con)
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
function prepare_lots_query($con, $condition = "")
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
function get_active_lots($con)
{
    $data = [];
    $condition = "WHERE l.date_expire > NOW() ORDER BY l.date_expire ASC";
    $result = prepare_lots_query($con, $condition);

    if($result) {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $data;
}

/**
 * Возвращает числовое значение переменной

 * @param string $query Параметр, получаемый из строки запроса
 * @return int Числовое значение переменной
 */
function return_int_from_query($query)
{
   return intval($query);
}

/**
 * Возвращает значение указанного параметра из строки запроса

 * @param string $param Параметр, получаемый из строки запроса
 * @return string Значение параметра
 */
function get_param_from_query($param)
{
    if ($param === "id") {
        return return_int_from_query($_GET[$param]) ?? "";
    }

    return $_GET[$param] ?? "";
}

/**
 * Возвращает массив с данными лота, соответствующего переданному id, название категории, к которой принадлежит лот, и его текущую цену с учётом ставок

 * @param mysqli $con Подключение к ДБ
 * @param string $id Идентификатор лота
 * @return array Массив данных из таблицы lot
 */
function get_lot_by_id($con, $id)
{
    $data = [];
    $condition = "WHERE l.id = $id";
    $result = prepare_lots_query($con, $condition);

    if($result) {
        $data = mysqli_fetch_assoc($result);
    }

    return $data;
}

/**
 * Возвращает значения прежде заполненных полей из массива POST

 * @param string $name Имя поля
 * @return string Значение поля
 */
function get_post_val($name)
{
    return $_POST[$name] ?? "";
}

/**
 * Возвращает массив данных из массива $_POST, отфильтрованный по нужным полям"
 *
 * @param array $fields Названия нужных полей
 * @return array Массив данных
 */
function filter_post_data($fields)
{
    return array_intersect_key($_POST, array_flip($fields));
}

/**
 * Возвращает данные пользователя с указанным email из таблицы user

 * @param mysqli $con Подключение к ДБ
 * @param string $email Email пользователя
 * @return array Данные пользователя
 */
function get_user_from_db($con, $email)
{
    $email = mysqli_real_escape_string($con, $email);
    $sql = "SELECT * FROM user WHERE email = '$email'";

    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    return $user;
}

/**
 * Возвращает строку ошибки, если пользователь при регистрации вводит уже существующий в БД email, или null

 * @param mysqli $con Подключение к ДБ
 * @param string $email Email пользователя
 * @return string Текст ошибки или null
 */
function check_double_email($con, $email)
{
    $user = get_user_from_db($con, $email);

    if (isset($user)) {
        return "Пользователь с этим email уже зарегистрирован";
    }

    return null;
}

/**
 * Возвращает строку ошибки, если пользователь с указанным email не найден в БД, или null

 * @param mysqli $con Подключение к ДБ
 * @param string $email Email пользователя
 * @return string Текст ошибки или null
 */
function check_existing_email($con, $email)
{
    $user = get_user_from_db($con, $email);

    if (!isset($user)) {
        return "Такой пользователь не найден";
    }

    return null;
}

/**
 * Возвращает строку ошибки, если введенный пароль не совпадает с паролем, указанным при регистрации пользователя с данным email

 * @param mysqli $con Подключение к ДБ
 * @param array $data Данные, отфильтрованные из массива $_POST
 * @return string Текст ошибки или null
 */
function verify_password($con, $data)
{
    $user = get_user_from_db($con, $data["email"]);

    if (isset($user)) {
        if (password_verify($data["password"], $user["password"])) {
            return null;
        }

        return "Пароль неверен";
    }
}

/**
 * Возвращает массив ошибок, полученных после валидации полей формы

 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param array $validators Массив с правилами валидации
 * @return array Массив ошибок
 */
function validate_form($data, $validators)
{
    $errors = [];

    foreach ($data as $key => $value) {
        if (is_callable($validators[$key])) {
            $rule = $validators[$key];
            $errors[$key] = call_user_func($rule, $data);
        }
    };

    $errors = array_filter($errors);

    return $errors;
}

/**
 * Возвращает массив ошибок, полученных после валидации полей формы "Регистрация нового пользователя"

 * @param mysqli $con Подключение к ДБ
 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param array $validators Массив с правилами валидации
 * @return array Массив ошибок
 */
function validate_registration_form($con, $data, $validators)
{
    $errors = validate_form($data, $validators);

    if (empty($errors)) {
        $errors["email"] = check_double_email($con, $data["email"]);
    }

    $errors = array_filter($errors);

    return $errors;
}

/**
 * Возвращает массив ошибок, полученных после валидации формы "Авторизация"

 * @param mysqli $con Подключение к ДБ
 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param array $validators Массив с правилами валидации
 * @return array Массив ошибок
 */
function validate_login_form($con, $data, $validators)
{
    $errors = validate_form($data, $validators);

    if (empty($errors)) {
        $errors["email"] = check_existing_email($con, $data["email"]);

        if(empty($errors)) {
            $errors["password"] = verify_password($con, $data);
        }
    }

    $errors = array_filter($errors);

    return $errors;
}

/**
 * Возвращает массив ошибок, полученных после валидации полей формы "Добавить новый лот"

 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param array $validators Массив с правилами валидации
 * @return array Массив ошибок
 */
function validate_lot($data, $validators)
{
    $errors = validate_form($data, $validators);
    $errors["lot-img"] = validate_image("lot-img");
    $errors = array_filter($errors);

    return $errors;
}

/**
 * Возвращает текстовую строку, которая выводится при ошибки валидации поля "Категория", или null, если ошибки нет

 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param string $field Имя поля в массиве $_POST
 * @param array $cats_ids Массив id существующих категорий
 * @return string Текст ошибки или null
 */
function validate_category($data, $field, $cats_ids)
{
    $id = $data[$field];

    if (!in_array($id, $cats_ids)) {
        return "Укажите существующую категорию";
    }

    return null;
}

/**
 * Возвращает текст ошибки, если обязательное поле формы не заполнено, или null, если ошибки нет

 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param string $field Имя поля в массиве $_POST
 * @return string Текст ошибки или null
 */
function validate_filled($data, $field)
{
    if (empty($data[$field])) {
        return "Это поле должно быть заполнено";
    }

    return null;
}

/**
 * Возвращает текст ошибки, если email, указанный пользователем, не валиден, или null, если ошибки нет

 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param string $field Имя поля в массиве $_POST
 * @return string Текст ошибки или null
 */
function validate_email($data, $field)
{
    if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
        return "Ваш Email не корректен";
    }

    return null;
}

/**
 * Возвращает текст ошибки, если в поле формы указано не целое положительное число, или null, если ошибки нет

 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param string $field Имя поля в массиве $_POST
 * @return string Текст ошибки или null
 */
function is_num_positive_int($data, $field)
{
    if (!ctype_digit($data[$field]) || $data[$field] <= 0) {
        return "Введите целое положительное число";
    }

    return null;
}

/**
 * Возвращает текст ошибки, если дата, указанная в поле формы, не соответствует формату "ГГГГ-ММ-ДД", или дата не больше текущей на сутки, или null, если ошибки нет

 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param string $field Имя поля в массиве $_POST
 * @return string Текст ошибки или null
 */
function validate_date($data, $field)
{
    if (is_date_valid($data[$field])) {
        [$hoursLeft] = count_time_diff($data[$field]);

        if ($hoursLeft < 24) {
            return "Указанная дата должна быть больше текущей хотя бы на одни сутки";
        }
    }
    else {
        return "Введите дату в формате ГГГГ-ММ-ДД";
    }
}

/**
 * Возвращает текст ошибки, если изображение не загружено или не соответствует необходимому формату

 * @param string $field Имя поля в массиве $_FILES
 * @return string Текст ошибки или null
 */
function validate_image($field)
{
    if (!empty($_FILES[$field]["name"])) {
        return validate_image_format($_FILES[$field]);
    }

    return "Загрузите изображение лота";
}

/**
 * Возвращает текст ошибки, если формат картинки не соответствует jpg или png, или null, если ошибки нет

 * @param array $file Данные файла из массива $_FILES
 * @return string Текст ошибки или null
 */
function validate_image_format($file)
{
    $file_name = $file["tmp_name"];
    $file_type = mime_content_type($file_name);

    if ($file_type !== "image/jpeg" && $file_type !== "image/png") {
        return "Загрузите картинку в формате png, jpg или jpeg";
    }

    return null;
}

/**
 * Возвращает новую ссылку на файл после перемещения его из временной папки в папку uploads

 * @param array $file Данные файла из массива $_FILES
 * @return string Текст ошибки
 */
function move_file($file)
{
    $file_name = $file["name"];
    $file_path = __DIR__ . '/uploads/';
    $file_url = '/uploads/' . $file_name;
    move_uploaded_file($file["tmp_name"], $file_path . $file_name);

    return $file_url;
}

/**
 * Записывает данные в таблицу ДБ и возвращает id добавленной строки

 * @param mysqli $con Подключение к ДБ
 * @param string $sql Строка запроса к ДБ
 * @param array $data Массив значений, которые передаются в подготовленное выражение, по умолчанию пустой
 * @return string id добавленной строки
 */
function db_insert_data($con, $sql, $data = []) {
    $stmt = db_get_prepare_stmt($con, $sql, $data);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $result = mysqli_insert_id($con);
    }

    return $result;
}

/**
 * Записывает данные лота из массива $_POST в таблицу lot и возвращает id этого лота

 * @param mysqli $con Подключение к ДБ
 * @param array $data Данные, отфильтрованные из массива $_POST
 * @param string $user_id Id пользователя из сессии
 * @return string id лота
 */
function insert_lot($con, $data, $user_id)
{
    $name = $data["lot-name"];
    $description = $data["message"];
    $image_url = move_file($_FILES["lot-img"]);
    $start_price = $data["lot-rate"];
    $date_expire = $data["lot-date"];
    $bid_step = $data["lot-step"];
    $category_id = $data["category"];
    $sql = "INSERT INTO lot (name, description, image_url, start_price, date_expire, bid_step, category_id, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    return db_insert_data($con, $sql, [$name, $description, $image_url, $start_price, $date_expire, $bid_step, $category_id, $user_id]);
}

/**
 * Записывает данные пользователя из массива $_POST в таблицу user и возвращает id этого пользователя

 * @param mysqli $con Подключение к ДБ
 * @param array $data Данные, отфильтрованные из массива $_POST
 * @return string id пользователя
 */
function insert_new_user($con, $data)
{
    $email = $data["email"];
    $password = password_hash($data["password"], PASSWORD_DEFAULT);
    $name = $data["name"];
    $contacts = $data["message"];

    $sql = "INSERT INTO user (email, name, password, contacts) VALUES (?, ?, ?, ?)";

    return db_insert_data($con, $sql, [$email, $name, $password, $contacts]);
}
