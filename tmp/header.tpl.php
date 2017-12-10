<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Шапка сайта
 * @version 201703.13
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" >
        <meta name="viewport" content="width=device-width, initial-scale = 1">
        <meta name="description" content="<?php echo $meta->thispage('description'); ?>">
        <meta name="keywords" content="<?php echo $meta->thispage('keywords'); ?>">
        <title><?php echo $meta->thispage('title'); ?></title>

        <link rel="icon" type="image/png" href="/tmp/img/favicon.png">
        <link rel="apple-touch-icon" type="image/png" href="/tmp/img/favicon.png">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="/tmp/css/styles.css" />
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="/js/scripts.js"></script>
