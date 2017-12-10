<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description  ТОП-300 в корзину
 * @version 201704.09
 */
require_once './connect.php';

$user_id = (int) filter_input(INPUT_POST, 'user_id');

$query = $mysqli->query("DELETE FROM `cart` WHERE `user_id` = '$user_id'");
if (!$query) {
    exit("Не удалось очистить Вашу корзину");
}
echo 'Корзина очищена';
