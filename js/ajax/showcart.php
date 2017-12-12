<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Количество товара в корзине
 * @version 201702.12
 */
require_once './connect.php';
$user_id = (int) filter_input(INPUT_POST, 'user_id');
$show = filter_input(INPUT_POST, 'show');

$query = $mysqli->query("SELECT * FROM `cart` WHERE `user_id` = '$user_id' ORDER BY `vandor` ASC");
$rows = $query->num_rows;
if ($show == 'rows') {
    echo $rows;
} elseif ($show == 'data') {
    $cart = '';
    $maxsum = 0;
    $i = 0;
    if ($rows > 0) {
        foreach ($query as $value) {
            $vandor = $value['vandor'];
            $img = explode(" ", $vandor);
            $img = '/tmp/img/catalog/' . $img['0'] . '.jpg';
            $result = $mysqli->query("SELECT * FROM `pricelist` WHERE `vandor` = '$vandor'");
            $product = $result->fetch_array(MYSQLI_ASSOC);
            $id = $product['id'];
            $oem = $product['oem'];
            $quantity = $value['quantity'];
            $price100 = $product['price100'];
            $price25 = $product['price25'];
            $section = $product['section'];
            if ($section <= 2 && $quantity < 100) {
                $sum = $price25 * $quantity; // Стоимость при покупке клипс и металла до 100 шт
            } elseif ($section == 5 && $quantity == 2) {
                $sum = $price25 * $quantity; // Стоимость при покупке очистителей 1 шт
            } else {
                $sum = $price100 * $quantity; // Стоимость при покупке от 100 шт клипс от 2 шт очистителей и всех остальных
            }
            $maxsum = $maxsum + $sum;
            if ($i < 5) {
                $cart = $cart
                        . "<div class='minicart__group'>"
                        . "<div class='minicart__hero'>"
                        . "<img src='$img' alt='' class='minicart__image'>"
                        . "</div>"
                        . "<div class='minicart__description'>"
                        . "<div class='minicart__caption'>$vandor</div>"
                        . "</div>"
                        . "<div class='minicart__count'>"
                        . "<input type='text' class='minicart__input' value='$quantity' disabled=''>"
                        . "</div>"
                        . "<div class='minicart__price'>$sum руб.</div>"
                        . "<div class='minicart__remove'>"
                        . "<a onclick=\"deleteToCart('$vandor', '$user_id')\" class='remove remove_size_sm' title='Удалить'></a>"
                        . "</div>"
                        . "</div>";
                $i++;
            }
        }
        if ($rows > 5) {
            $string = $rows - 5;
            $cart = $cart
                    . "<div class='minicart__overall'>"
                    . "<div class='minicart__overall-caption'>Ещё</div>"
                    . "<div class='minicart__total'>$string артикулов</div>"
                    . "</div>";
        }
        $cart = $cart
                . "<div class='minicart__overall'>"
                . "<div class='minicart__overall-caption'>Итого</div>"
                . "<div class='minicart__total'>$maxsum руб.</div>"
                . "</div>";
    }
    $cart = $cart
            . "<footer class='minicart__footer'>"
            . "<button type='submit' class='btn btn_type_success btn_size_sm' onclick=\"location.href='/?route=cart'\">Оформить заказ</button>"
            . "<button style='float: right' class='btn btn_type_success btn_size_sm' onclick='truncateCart($user_id)'>Очистить</button>"
            . "</footer>";
    echo $cart;
}
