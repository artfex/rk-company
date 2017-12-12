<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Корзина
 * @version 201702.10
 */
class Cart {

    private $db;

    public function __construct() {
        $this->db = Connect::_self()->mysql();
    }

    /**
     * @description Карзина настоящего пользователя
     * @return array|int
     */
    public function thisCart() {
        $meta = new Meta();
        $user_id = $meta->user('id'); // ID настоящего пользователя
        $query = $this->db->query("SELECT * FROM `cart` WHERE `user_id` = $user_id ORDER BY `vandor` ASC");
        if ($query->num_rows == 0) {
            return 0;
        } else {
            $array = array();
            foreach ($query as $value) {
                $vandor = $value['vandor'];
                $img = explode(" ", $vandor);
                $img = '/tmp/img/catalog/' . $img['0'] . '.jpg';
                $result = $this->db->query("SELECT * FROM `pricelist` WHERE `vandor` = '$vandor'");
                $product = $result->fetch_array(MYSQLI_ASSOC);
                array_push($array, array(
                    'id' => $product['id'],
                    'img' => $img,
                    'vandor' => $product['vandor'],
                    'oem' => $product['oem'],
                    'quantity' => $value['quantity'],
                    'price100' => $product['price100'],
                    'price25' => $product['price25'],
                    'section' => $product['section']
                ));
            }
            sort($array);
            return $array;
        }
    }

    /**
     * @description Отправка заказа
     * @param type $data
     * @return boolean
     */
    public function sendOrder($data) {
        $meta = new Meta();
        $user_id = $meta->user('id'); // ID настоящего пользователя
        $name = $meta->user('name'); // Имя настоящего пользователя
        $email = $meta->user('email'); // E-mail настоящего пользователя
        $tel = $meta->user('tel');  // Телефон настоящего пользователя
        $country = $meta->user('country'); // Город настоящего пользователя
        $comment = $data['comment'];
        $payment = $data['payment']; // Оплата онлайн или позже
        $time = time(); // Дата покупки
        $msg = "<table>"
                . "<tr>"
                . "<th style='padding: 3px; border: 1px solid black'>Артикул</th>"
                . "<th style='padding: 3px; border: 1px solid black'>ОЕМ</th>"
                . "<th style='padding: 3px; border: 1px solid black'>Количество</th>"
                . "<th style='padding: 3px; border: 1px solid black'>Сумма</th>"
                . "</tr>";
        // Если в корзине есть товар
        if ($this->thisCart() != 0) {
            $this->db->query("INSERT INTO `list_baskets` (`user_id`, `date`, `verification`) VALUES ('$user_id', '$time', 0)");
            foreach ($this->thisCart() as $product) {
                // Задаём переменные
                $quantity = $product['quantity']; // Количество
                if ($quantity > 0) {
                    $vandor = $product['vandor']; // Артикул
                    $oem = $product['oem']; // OEM
                    $section = $product['section']; // Цекция
                    $price100 = $product['price100']; // Цена при покупке от 100 шт.
                    $price25 = $product['price25']; // Цена при покупке от 25 шт.
                    // Если это клипса или металл, и их количество меньше 100
                    if ($section <= 2 && $quantity < 100) {
                        $sum = $price25 * $quantity; // Стоимость при покупке клипс и металла до 100 шт
                    } elseif ($section == 5 && $quantity == 2) {
                        $sum = $price25 * $quantity; // Стоимость при покупке очистителей 1 шт
                    } else {
                        $sum = $price100 * $quantity; // Стоимость при покупке от 100 шт клипс от 2 шт очистителей и всех остальных
                    }

                    $price = $sum / $quantity; // Стоимость одной штуки
                    $maxsum += $sum;

                    // Добавляем таблицу с товаром в сообщение
                    $msg = $msg
                            . "<tr>"
                            . "<td style='padding: 3px; border: 1px solid black'>$vandor</td>"
                            . "<td style='padding: 3px; border: 1px solid black'>$oem</td>"
                            . "<td style='padding: 3px; border: 1px solid black'>$quantity шт.</td>"
                            . "<td style='padding: 3px; border: 1px solid black'>$sum руб.</td>"
                            . "</tr>";
                    $query = $this->db->query("SELECT `id` FROM `list_baskets` WHERE `user_id` = '$user_id' AND `date` = '$time' AND `verification` = 0"); // ID корзины в списке корзин
                    $query = $query->fetch_array(MYSQLI_ASSOC);
                    $baskets_id = $query['id'];
                    $this->db->query("INSERT INTO `purchase_history` (`baskets_id`, `vandor`, `oem`, `price`, `quantity`) VALUES ('$baskets_id', '$vandor', '$oem', '$price', '$quantity')");
                }
            }
            if ($maxsum < 20000) {
                $points = NULL; // Пустое количество баллов
            } else {
                $points = round($maxsum * 0.03, 0, PHP_ROUND_HALF_DOWN); // Вычисляем количество баллов и округляем их
            }
            $msg = $msg
                    . "<tr>"
                    . "<td colspan='2' style='padding: 3px; border: 1px solid black'>Сумма: </td>"
                    . "<td colspan='2' style='padding: 3px; border: 1px solid black'>$maxsum руб.</td>"
                    . "</tr>";
            if ($maxsum >= 20000) {
                $msg = $msg
                        . "<tr>"
                        . "<td colspan='2' style='padding: 3px; border: 1px solid black'>Сумма начисленных баллов: </td>"
                        . "<td colspan='2' style='padding: 3px; border: 1px solid black'>$points</td>"
                        . "</tr>";
            }

            // Сообщение для администратора
            $msgAdmin = "Пользователь: $name<br>"
                    . "E-mail: $email<br>"
                    . "Телефон: $tel<br>"
                    . "Город: $country";
            if ($comment != '') {
                $msgAdmin = "$msgAdmin<br>Комментарий: $comment";
            }
            $msgAdmin = "$msgAdmin<br>$msg";

            // Сообщение для пользователя
            $msgUser = "Ваш заказ принят: $msg";

            /*if ($payment == 'robokassa') {
                
            } elseif ($payment == 'norobokassa') {*/
                Mail::new_mail("manager", "Заказ от пользователя: $name", $msgAdmin);
                Mail::new_mail("doubleDevelop", "Заказ RK-company от пользователя: $name", $msgAdmin);
                Mail::new_mail($email, "Ваш заказ принят", $msgUser . $baskets_id);
                $this->db->query("UPDATE `list_baskets` SET `maxsum` = '$maxsum', `points` = '$points' WHERE `id` = '$baskets_id'");
                $this->db->query("DELETE FROM `cart` WHERE `user_id` = '$user_id'");
                return TRUE;
        }
        return FALSE;
    }

    /**
     * @description Корзины покупателей
     * @return boolean
     */
    public function basketsOfBuyers() {
        $query = $this->db->query("SELECT * FROM `list_baskets` ORDER BY `date` DESC");
        if (!$query) {
            return FALSE;
        } else {
            return $query;
        }
    }

    /**
     * @description Корзина покупателя
     */
    public function BasketOfBuyer($id, $data) {
        $query = $this->db->query("SELECT * FROM `list_baskets` WHERE `id` = '$id'");
        if (!$query) {
            return FALSE;
        }
        $result = $query->fetch_array(MYSQLI_ASSOC);
        return $result["$data"];
    }

    /**
     * @description Содержимое корзины покупателя
     */
    public function purchaseHistory($baskets_id) {
        $query = $this->db->query("SELECT * FROM `purchase_history` WHERE `baskets_id` = '$baskets_id'");
        if (!$query) {
            return FALSE;
        }
        return $query;
    }

    /**
     * @description Подтверждение баллов
     */
    public function verificationPoints($data) {
        $baskets_id = $data['baskets_id'];
        $points = $data['points'];
        $query = $this->db->query("UPDATE `list_baskets` SET `points` = '$points', `verification` = 1 WHERE `id` = '$baskets_id'");
        if (!$query) {
            return FALSE;
        }
        return TRUE;
    }

}
