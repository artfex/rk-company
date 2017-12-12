<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Входной файл
 * @version 201611.01
 */
session_start();

// Проверка версии php
if (version_compare(phpversion(), '7.0.0', '<') == TRUE) {
    exit('Ваша версия PHP ' . phpversion() . '! Для корректной работы требуется php 5.3 и выше!');
}

// Константа полного пути до корня
define('ROOT_DIR', dirname(__FILE__));

// Константа полного пути до папки с библиотеками
define('LIBS', ROOT_DIR . '/libs');

// Константа полного пути до папки с модулями
define('MOD', ROOT_DIR . '/module');

// Константа полного пути до папки с темами
define('TMP', ROOT_DIR . '/tmp');

// Открываем конфигурацию
require_once ROOT_DIR . '/config.php';

// Запуск маршрутизации
new Route();

// Отображение шаблона
$tmp->show_display('main');
