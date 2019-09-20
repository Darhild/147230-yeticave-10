<?php
[
    "cur_page" => $cur_page,
    "pages" => $pages,
    "pages_count" => $pages_count,
    "offset" => $offset
] = get_pages_info($_GET, $lots, $page_items);
