<main>
    <?=$nav; ?>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
        <?php if(empty($user_bids)): ?>
            <p>Вы ещё не сделали ни одной ставки.</p>
        <?php endif; ?>
        <?php foreach ($user_bids as $user_bid): ?>
            <tr class="rates__item<?=return_bid_class($user_bid, "lot_date_expire"); ?>">
                <td class="rates__info">
                    <div class="rates__img">
                    <img src="<?=$user_bid["image_url"]; ?>" width="54" height="40" alt="<?=strip_tags($user_bid["lot_name"]); ?>">
                    </div>
                    <?php if($user_bid["user_id"] ===  $user_bid["winner_id"]): ?>
                        <div>
                    <?php endif; ?>
                            <h3 class="rates__title"><a href="lot.php?id=<?=$user_bid["lot_id"]; ?>"><?=strip_tags($user_bid["lot_name"]); ?></a></h3>
                    <?php if($user_bid["user_id"] ===  $user_bid["winner_id"]): ?>
                            <p><?=strip_tags($user_bid["seller_contacts"]); ?></p>
                        </div>
                    <?php endif; ?>
                </td>
                <td class="rates__category">
                    <?=$user_bid["category_name"]; ?>
                </td>
                <td class="rates__timer">
                    <div class="timer<?=return_timer_class($user_bid, "lot_date_expire"); ?>"><?=print_timer($user_bid, "lot_date_expire", true); ?></div>
                </td>
                <td class="rates__price">
                    <?=format_price($user_bid["bid_value"]); ?>
                </td>
                <td class="rates__time">
                    <?=return_formated_time($user_bid["bid_date_create"]); ?>
                </td>
            </tr>
        <?php endforeach; ?>
      </table>
    </section>
  </main>
