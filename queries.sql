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
SET email = "v_barankina@yandex.ru", name = "Валерия Баранкина", password = "v12345678", avatar = "fotki/v_barankina.jpg", contacts = "Телефон +7 985 123 4567", lot_id = 2, rate_id = 1;
INSERT into user
SET email = "n_romashkin@mail.ru", name = "Николай Ромашкин", password = "romashka555", avatar = "fotki/pole_romashek.jpg", contacts = "Адрес: на деревеню дедушке", lot_id = 6, rate_id = 2;

/* Добавить существующий список лотов */
INSERT into lot
SET name = "2014 Rossignol District Snowboard", description = "Великолепная доска", image = "img/lot-1.jpg", start_price = 10999, delete_date = "2019-08-22", rate_step = 500, user_id = 5, category_id = 1;
INSERT into lot
SET name = "DC Ply Mens 2016/2017 Snowboard", description = "Мегавеликолепная доска", image = "img/lot-2.jpg", start_price = 159999, delete_date = "2019-08-20", rate_step = 2000, user_id = 5, category_id = 1;
INSERT into lot
SET name = "Крепления Union Contact Pro 2015 года размер L/XL", description = "Великолепные крепления", image = "img/lot-3.jpg", start_price = 8000, delete_date = "2019-08-17", rate_step = 500, user_id = 5, category_id = 2;
INSERT into lot
SET name = "Ботинки для сноуборда DC Mutiny Charocal", description = "Великолепные ботинки", image = "img/lot-4.jpg", start_price = 10999, delete_date = "2019-08-16", rate_step = 1000, user_id = 5, category_id = 3;
INSERT into lot
SET name = "Куртка для сноуборда DC Mutiny Charocal", description = "Великолепная куртка", image = "img/lot-5.jpg", start_price = 7500, delete_date = "2019-08-26", rate_step = 500, user_id = 5, category_id = 4;
INSERT into lot
SET name = "Маска Oakley Canopy", description = "Великолепные очки", image = "img/lot-6.jpg", start_price = 5400, delete_date = "2019-08-14", rate_step = 100, user_id = 5, category_id = 6;

/* Добавить ставки */
INSERT into rate
SET sum = 200, user_id = 1, lot_id = 6;
INSERT into rate
SET sum = 2000, user_id = 2, lot_id = 5;
INSERT into rate
SET sum = 1000, user_id = 1, lot_id = 5;

/* Получить все категории */
SELECT * FROM category;

/* Получить самые новые открытые лоты cо следующими полями - название, стартовая цена, ссылка на изображение, цена, название категории*/
SELECT l.name, start_price, image, (start_price + SUM(r.sum)) as current_price, c.name 
FROM lot as l
LEFT JOIN rate as r
ON l.id = r.lot_id
JOIN category as c
ON l.category_id = c.id
WHERE delete_date > NOW()
ORDER BY delete_date DESC;

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
SELECT l.name, r.sum as rate
FROM lot as l
LEFT JOIN rate as r
ON l.id = r.lot_id
WHERE l.id = 5;