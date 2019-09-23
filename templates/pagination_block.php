<?php if (count($pages) > 1): ?>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a href="<?=$link; ?><?=(($cur_page - 1) > 0) ? $cur_page - 1 : 1; ?>">Назад</a></li>
        <?php foreach ($pages as $page): ?>
            <li class="pagination-item<?php if ($page === $cur_page): ?> pagination-item-active<?php endif; ?>"><a href="<?=$link . $page; ?>"><?=$page; ?></a></li>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next"><a href="<?=$link; ?><?=(($cur_page + 1) <= count($pages)) ? $cur_page + 1 : count($pages); ?>">Вперед</a></li>
    </ul>
<?php endif; ?>
