<?php
    use app\core\Helpers\FileManager;
    use app\core\Helpers\Helper;
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta
            name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    >
    <link
            rel="stylesheet"
            href="<?php echo FileManager::resourcePath('css/style.css') ?>"
    >
    <title>
        <?php echo Helper::env('APP_NAME', 'Development') ?>
    </title>
</head>
