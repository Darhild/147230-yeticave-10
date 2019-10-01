<?php
$cur_page = (return_int_from_query("page", $_GET) > 0) 
? return_int_from_query("page", $_GET) 
: 1;

[
    "pages" => $pages,
    "pages_count" => $pages_count,
] = get_pages_info($cur_page, $lots, $page_items);


$pagination_data["cur_page"] = $cur_page;
$pagination_data["pages"] = $pages;
$pagination_data["pages_count"] = $pages_count;

