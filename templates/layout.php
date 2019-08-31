<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?=$page_title; ?></title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <?=$calendar_css ?? ""; ?>
</head>
<body>
<div class="page-wrapper">
    <?=$header; ?>
    <?=$content; ?>
</div>
<?=$footer; ?>

<script src="flatpickr.js"></script>
<script src="script.js"></script>
</body>
</html>
