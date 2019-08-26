USE `47230-yeticave-10`;
/* Добавить существующие категории */
INSERT into category
(name, symbol_code)
VALUES
("Доски и лыжи", "boards"),
("Крепления", "attachment"),
("Ботинки", "boots"),
("Одежда", "clothing"),
("Инструменты", "tools"),
("Разное", "other");

/* Добавить пользователей */
INSERT into user
(email, name, password, contacts)
VALUES
("v_barankina@yandex.ru", "Валерия Баранкина", "v12345678", "Телефон +7 985 123 4567"),
("n_romashkin@mail.ru", "Николай Ромашкин", "romashka555", "Адрес: на деревеню дедушке");

/* Добавить существующий список лотов */
INSERT into lot
(name, description, image_url, start_price, date_expire, bid_step, seller_id, category_id)
VALUES
("2014 Rossignol District Snowboard", "Великолепная доска", "img/lot-1.jpg", 10999, "2019-08-27", 500, 1, 1),
("DC Ply Mens 2016/2017 Snowboard", "Мегавеликолепная доска", "img/lot-2.jpg", 159999, "2019-08-28", 2000, 2, 1),
("Крепления Union Contact Pro 2015 года размер L/XL", "Великолепные крепления", "img/lot-3.jpg", 8000, "2019-08-29", 500, 2, 2),
("Ботинки для сноуборда DC Mutiny Charocal", "Великолепные ботинки", "img/lot-4.jpg", 10999, "2019-08-30", 1000, 1, 3),
("Куртка для сноуборда DC Mutiny Charocal", "Великолепная куртка", "img/lot-5.jpg", 7500, "2019-09-01", 500, 1, 4),
("Маска Oakley Canopy", "Великолепные очки", "img/lot-6.jpg", 5400, "2019-09-02", 100, 2, 6);

/* Добавить ставки */
INSERT into bid
(value, user_id, lot_id)
VALUES
(5600, 1, 6),
(8500, 2, 5),
(9500, 1, 5),
(10000, 2, 5),
(11000, 2, 1),
(11500, 1, 1);

/* Получить все категории */
SELECT * FROM category;

/* Получить самые новые открытые лоты cо следующими полями - название, стартовая цена, ссылка на изображение, цена, название категории*/
SELECT l.name, start_price, image_url,
       IFNULL((
           SELECT value FROM bid as b
           WHERE b.lot_id = l.id
           ORDER BY b.value DESC LIMIT 1),
           start_price
       ) as current_price,
       c.name as category, date_expire
FROM lot as l
JOIN category as c
ON l.category_id = c.id
WHERE date_expire > NOW()
ORDER BY date_expire ASC;

/* Показать лот и название его категории по id */
SELECT l.name, c.name as category
FROM lot as l
JOIN category as c
ON l.category_id = c.id
WHERE l.id = 5;

/* Обновить название лота по его идентификатору */
UPDATE lot
SET name = "2018 Rossignol District Snowboard"
WHERE id = 1;

/* Получить список ставок для лота по его идентификатору с сортировкой по дате */
SELECT l.name, b.value as bid, b.date_create
FROM lot as l
LEFT JOIN bid as b
ON l.id = b.lot_id
WHERE l.id = 5
ORDER BY b.date_create ASC;
