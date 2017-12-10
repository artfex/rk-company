<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description  ТОП-300 в корзину
 * @version 201704.09
 */
require_once './connect.php';

$user_id = (int) filter_input(INPUT_POST, 'user_id');

$query = $mysqli->query("SELECT `email`, `tel`, `country`, `name` FROM `users` WHERE `id` = '$user_id'");
$result = $query->fetch_array(MYSQLI_ASSOC);
$email = $result['email'];
$tel = $result['tel'];
$country = $result['country'];
$name = $result['name'];

$headers = 'From: avtodok@avtodok.com' . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

$msgAdmin = "Пользователь: $name<br />"
        . "E-mail: $email<br />"
        . "Телефон: $tel<br />"
        . "Город: $country<br />"
        . "Заказал ТОП-300";

if (!mail("order@avtodok.com", "Заказ ТОП-300 от пользователя $name", $msgAdmin, $headers)) {
    exit('Ошибка! Заказ не отправлен администратору');
}

$msgUser = "Ваш заказ ТОП-300 принят. С Вами свяжутся в ближайшее время для уточнения заказа";
if (!mail($email, "Заказ ТОП-300", $msgUser, $headers)) {
    exit('Ошибка! Администратор получил заказ, но Вам он отправлен не был');
}
echo 'Заказ принят к исполнению';
