/* Добавить существующие категории */
INSERT into category
SET name = "Доски и лыжи", symbol_code = "boards";
INSERT into category
SET name = "Крепления", symbol_code = "attachment";
INSERT into category
SET name = "Ботинки", symbol_code = "boots";
INSERT into category
SET name = "Одежда", symbol_code = "clothing";
INSERT into category
SET name = "Инструменты", symbol_code = "tools";
INSERT into category
SET name = "Разное", symbol_code = "other";

/* Добавить пользователей */
INSERT into user
SET email = "v_barankina@yandex.ru", name = "Валерия Баранкина", password = "v12345678", contacts = "Телефон +7 985 123 4567";
INSERT into user
SET email = "n_romashkin@mail.ru", name = "Николай Ромашкин", password = "romashka555", contacts = "Адрес: на деревеню дедушке";

/* Добавить существующий список лотов */
INSERT into lot
SET name = "2014 Rossignol District Snowboard", description = "Великолепная доска", image_url = "img/lot-1.jpg", start_price = 10999, date_expire = "2019-08-22", bid_step = 500, seller_id = 1, category_id = 1;
INSERT into lot
SET name = "DC Ply Mens 2016/2017 Snowboard", description = "Мегавеликолепная доска", image_url = "img/lot-2.jpg", start_price = 159999, date_expire = "2019-08-20", bid_step = 2000, seller_id = 2, category_id = 1;
INSERT into lot
SET name = "Крепления Union Contact Pro 2015 года размер L/XL", description = "Великолепные крепления", image_url = "img/lot-3.jpg", start_price = 8000, date_expire = "2019-08-17", bid_step = 500, seller_id = 2, category_id = 2;
INSERT into lot
SET name = "Ботинки для сноуборда DC Mutiny Charocal", description = "Великолепные ботинки", image_url = "img/lot-4.jpg", start_price = 10999, date_expire = "2019-08-16", bid_step = 1000, seller_id = 1, category_id = 3;
INSERT into lot
SET name = "Куртка для сноуборда DC Mutiny Charocal", description = "Великолепная куртка", image_url = "img/lot-5.jpg", start_price = 7500, date_expire = "2019-08-26", bid_step = 500, seller_id = 1, category_id = 4;
INSERT into lot
SET name = "Маска Oakley Canopy", description = "Великолепные очки", image_url = "img/lot-6.jpg", start_price = 5400, date_expire = "2019-08-14", bid_step = 100, seller_id = 5, category_id = 2;

/* Добавить ставки */
INSERT into bid
SET value = 5600, user_id = 1, lot_id = 6;
INSERT into bid
SET value = 8500, user_id = 2, lot_id = 5;
INSERT into bid
SET value = 9500, user_id = 1, lot_id = 5;
INSERT into bid
SET value = 10000, user_id = 2, lot_id = 5;
INSERT into bid
SET value = 11000, user_id = 2, lot_id = 1;
INSERT into bid
SET value = 11500, user_id = 1, lot_id = 1;

/* Получить все категории */
SELECT * FROM category;

/* Получить самые новые открытые лоты cо следующими полями - название, стартовая цена, ссылка на изображение, цена, название категории*/
SELECT l.name, start_price, image_url, 
(SELECT value FROM bid as b 
WHERE b.lot_id = l.id
ORDER BY b.value DESC LIMIT 1) as current_price, 
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