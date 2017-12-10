<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @desk Удалить товар из корзины
 * @version 201612.15
 */
require_once './connect.php';

$vandor = filter_input(INPUT_POST, 'vandor');
$user_id = filter_input(INPUT_POST, 'user_id');

$query = $mysqli->query("DELETE FROM `cart` WHERE `user_id` = '$user_id' AND `vandor` = '$vandor'");
if ($query) {
    return TRUE;
} else {
    return FALSE;
}
