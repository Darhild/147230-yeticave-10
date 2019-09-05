<main>
    <?=$nav; ?>
    <section class="lot-item container">
        <h2><?=$lot_item["name"]; ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=$lot_item["image_url"]; ?>" width="730" height="548" alt="<?=strip_tags($lot_item["name"]); ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lot_item["category"]; ?></span></p>
                <p class="lot-item__description"><?=strip_tags($lot_item["description"]); ?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <div class="timer lot-item__timer<?=return_timer_class($lot_item["date_expire"]); ?>">
                        <?=implode(" : ", print_timer($lot_item["date_expire"])); ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=format_price($lot_item["price"]); ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?=format_price($lot_item["bid_step"]); ?></span>
                        </div>
                     </div>
                    <?php if ($is_auth): ?>
                        <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                            <p class="lot-item__form-item form__item form__item--invalid">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" placeholder="12 000">
                                <span class="form__error">Введите наименование лота</span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>
