<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Список всех корзин
 */
$meta = new Meta();
$cart = new Cart();
$baskets_id = (int) filter_input(INPUT_GET, 'baskets_id');
?>
<div class="content">
    <?php if ($baskets_id === 0 || $baskets_id === NULL || $baskets_id === '') { ?>
        <div id="baskets_of_buyers">
            <h1>Список покупок клиентов</h1>
            <table>
                <tr>
                    <th>Имя пользователя</th>
                    <th>Дата покупки</th>
                    <th>Баллы</th>
                    <th>Сумма </th>
                </tr>
                <?php
                foreach ($cart->basketsOfBuyers() as $value) {
                    $id = (int) $value['id'];
                    $maxsum = (float) $value['maxsum'];
                    $points = (int) $value['points'];
                    $date = date('d M Y года', $value['date']);
                    $users_name = $meta->users($value['user_id'], 'name');
                    $verification = (int) $value['verification'];
                    ?>
                    <tr class="string <?php
                    if ($verification === 0) {
                        echo 'pointer';
                    }
                    ?>" onclick="location.href = '/?route=baskets_of_buyers&baskets_id=<?php echo $id; ?>'">
                        <td class="name"><?php echo $users_name; ?></td>
                        <td class="date"><?php echo $date; ?></td>
                        <td class="points"><?php echo $points; ?> баллов</td>
                        <td class="maxsum"><?php echo $maxsum; ?> руб</td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <?php
    } else {
        $users_id = $cart->BasketOfBuyer($baskets_id, 'user_id');
        ?>
        <div id="purchase_history">
            <a href="/?route=baskets_of_buyers">Вернуться к списку покупок</a>
            <ul>
                <h2>Контакты клиента:</h2>
                <li><?php echo $meta->users($users_id, 'name'); ?></li>
                <li><?php echo $meta->users($users_id, 'email'); ?></li>
                <li><?php echo $meta->users($users_id, 'tel'); ?></li>
                <li><?php echo $meta->users($users_id, 'country'); ?></li>
            </ul>
            <?php
            $points = (int) $cart->BasketOfBuyer($baskets_id, 'points');
            if (+ $cart->BasketOfBuyer($baskets_id, 'verification') === 1) {
                echo "<label>Начислено $points баллов</label>";
            } else {
            ?>
            <form method="POST">
                <input type="number" name="points" min="0" value="<?php echo $points; ?>" style="width: 150px;" />
                <input type="number" name="baskets_id" value="<?php echo $baskets_id; ?>" style="display: none;" />
                <input type="submit" name="verificationPoints" value="Подтвердить баллы" />
            </form>
            <?php } ?>
            <table>
                <caption>Содержимое корзины</caption>
                <tr>
                    <th>Артикул</th>
                    <th>Цена</th>
                    <th>Количество</th>
                </tr>
                <?php
                foreach ($cart->purchaseHistory($baskets_id) as $value) {
                    $vandor = $value['vandor'];
                    $price = (float) $value['price'];
                    $quantity = (int) $value['quantity'];
                    ?>
                    <tr class="string">
                        <td class="vandor"><?php echo $vandor; ?></td>
                        <td class="price"><?php echo $price; ?> руб.</td>
                        <td class="quantity"><?php echo $quantity; ?> шт.</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2">Оплата деньгами</td>
                    <td><?php echo $cart->BasketOfBuyer($baskets_id, 'maxsum'); ?> руб.</td>
                </tr>
                <tr>
                    <td colspan="2">Оплата баллами</td>
                    <td><?php echo + $cart->BasketOfBuyer($baskets_id, 'used_points'); ?> баллов</td>
                </tr>
            </table>
        </div>
    <?php } ?>
</div>
<script>showSum();</script>
