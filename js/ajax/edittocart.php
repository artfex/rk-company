<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @desk Данные страницы
 * @version 201611.25
 */
require_once './connect.php';

$vandor = filter_input(INPUT_POST, 'vandor');
$user_id = (int) filter_input(INPUT_POST, 'user_id');
$quantity = (int) filter_input(INPUT_POST, 'quantity');


$query = $mysqli->query("UPDATE `cart` SET `quantity` = '$quantity' WHERE `user_id` = '$user_id' AND `vandor` = '$vandor'");
