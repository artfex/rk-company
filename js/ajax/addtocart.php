<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Данные страницы
 * @version 201611.25
 */
require_once './connect.php';

$vandor = filter_input(INPUT_POST, 'vandor');
$user_id = (int) filter_input(INPUT_POST, 'user_id');
$quantity = (int) filter_input(INPUT_POST, 'quantity');


if ($quantity === 0) {
    echo 'Нельзя добавить 0 шт!';
} else {
    $query = $mysqli->query("SELECT `quantity` FROM `cart` WHERE `user_id` = '$user_id' AND `vandor` = '$vandor'");
    $result = $query->fetch_array(MYSQLI_ASSOC);
    if ($result) {
        $quantity = $quantity + $result['quantity'];
        $query = $mysqli->query("UPDATE `cart` SET `quantity` = '$quantity' WHERE `user_id` = '$user_id' AND `vandor` = '$vandor'");
    } else {
        $query = $mysqli->query("INSERT INTO `cart` (`user_id`, `vandor`, `quantity`) VALUES('$user_id', '$vandor', '$quantity')");
    }
}
