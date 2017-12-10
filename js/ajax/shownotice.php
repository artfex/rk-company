<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Количество уведомлений пользователя
 * @version 201702.13
 */
require_once './connect.php';
$user_id = (int) filter_input(INPUT_POST, 'user_id');

$query = $mysqli->query("SELECT * FROM `notification` WHERE `to` = '$user_id' AND `status` = 0");
$rows = $query->num_rows;
echo $rows;
