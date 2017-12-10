<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Корзина
 * @version 201703.13
 */
$cart = new Cart();
$section = (int) filter_input(INPUT_GET, 'section');
switch ($section) {
    case 1 :
        $name = 'Клипсы';
        break;
    case 2 :
        $name = 'Металл';
        break;
    case 3 :
        $name = 'Стяжки';
        break;
    case 4 :
        $name = 'Разъёмы';
        break;
    case 5 :
        $name = 'Автохимия';
        break;
}
?>
<div class="content">
    <div class="cart">
        <h1 class="cart__title">Корзина</h1>
        <?php if ($cart->thisCart() === 0) { ?>
        <div class="cart__info">Ваша корзина пустая!</div>
        <?php } else { ?>
        <div class="cart__info points"></div>
        <div class="cart__info minsum">Минимальная сумма заказа должна составлять 5000 рублей</div>
        <div class="order">
            <?php
            foreach ($cart->thisCart() as $product) {
                $id = (int) $product['id'];
                $img = $product['img'];
                $vandor = $product['vandor'];
                $oem = $product['oem'];
                $section = (int) $product['section'];
                $quantity = (int) $product['quantity'];
                $price100 = (float) $product['price100'];
                $price25 = (float) $product['price25'];
                ?>
                <div class="order__item">
                    <div class="order__hero">
                        <img src="<?php echo $img; ?>" alt="" class="order__image">
                    </div>
                    <div class="order__description">
                        <div class="order__caption"><?php echo $vandor; ?></div>
                    </div>
                    <div class="order__price">
                        <div class="order__price-item">
                            <div class="order__price-value <?php echo "price$id"; ?>">4.8 руб/шт</div>
                        </div>
                        <div class="order__price-item">
                            <div class="order__price-value sum <?php echo "sum$id"; ?>"></div>
                        </div>
                    </div>
                    <div class="order__count">
                        <button class="operator minus" onclick="editToCart(<?php echo "'$id', '$vandor', '$section', '$quantity', '$price25', '$price100', 'minus', '$user_id'"; ?>)">-</button>
                        <input class="<?php echo $id; ?>" type="text" value="" disabled="">
                        <button class="operator plus" onclick="editToCart(<?php echo "'$id', '$vandor', '$section', '$quantity', '$price25', '$price100', 'plus', '$user_id'"; ?>)">+</button>
                    </div>
                    <div onclick="deleteToCart(<?php echo "'$vandor', '$user_id'"; ?>)" class="order__remove">
                        <a href="#" class="remove remove_size_lg" title="Удалить"></a>
                    </div>
                </div>
                <script>calculationCart(<?php echo "'$id', '$section', '$quantity', '$price25', '$price100'"; ?>);</script>
            <?php } ?>
        </div>
        <form method="post">
            <footer class="cart__footer">
                <div class="cart__footer-leftside">
                    <div class="cart__back"><a href="/" class="back-link">Вернуться в каталог</a></div>
                    <div class="cart__comment">
                        <textarea rows="5" class="textarea" name="comment" placeholder="Здесь вы можете оставить комментарий к заказу"></textarea>
                    </div>
                </div>
                <div class="cart__footer-rightside">
                    <div class="cart__total">
                        Итого <span class="cart__total-value maxsum"></span>
                    </div>
                    <div class="cart__bonus"></div>
                    <div class="cart__btn-holder">
                        <label><input name="payment" type="radio" value="norobokassa" onchange="selectPayment(this.value)" checked /> Оплатить позже</label><br />
                        <label><input name="payment" type="radio" value="robokassa" onchange="selectPayment(this.value)"/> Оплатить сейчас</label><br />
                        <button type="submit" name="sendorder" class="btn btn_type_success btn_size_md">Отправить заказ</button>
                    </div>
                </div>
            </footer>
        </form>
    </div>
</div>
<script>showSum();</script>
<?php } ?>
