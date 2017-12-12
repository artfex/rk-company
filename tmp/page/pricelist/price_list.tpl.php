<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Прайс лист
 * @version 201703.13
 */
$pricelist = new PriceList();
if ($search == 'new') {
    $name = "Новинки";
} elseif($search == 'top300') {
    $name = 'ТОП-300';
} elseif ($search != NULL) {
    $name = "Поиск | $search";
} elseif ($section != 0) {
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
            $name = 'Инструмент';
            break;
    }
}
if ($section != 0) {
    $list = $pricelist->product($section, NULL);
} elseif ($search != NULL) {
    $list = $pricelist->product(NULL, $search);
}
if ($section != 0 || $search != NULL) {
?>
<div class="content">
    <div class="products">
        <header class="products__header">
            <h1 class="products__title"><?php echo $name ?> <span class="products__num"><?php print_r($list->num_rows); ?> шт.</span></h1>
            <!--<div class="products__sort">
                <div class="sort">
                    <div class="sort__toggle">
                        <span class="sort__caption">Сортировать по:</span>
                        <span class="sort__value" data-current-value="price">Цене</span>
                    </div>
                    <div class="sort__dd">
                        <div class="sort__item sort__item_active" data-value="price">Цене</div>
                        <div class="sort__item" data-value="popular">Популярности</div>
                        <div class="sort__item" data-value="date">Дате добавления</div>
                    </div>
                </div>
            </div>-->
        </header>
<?php
foreach ($list as $product) {
    $img = explode(" ", $product['vandor']);
    $img = '/tmp/img/catalog/' . $img['0'] . '.jpg';
    $id = $product['id'];
    $vandor = $product['vandor'];
    $oem = $product['oem'];
    $price100 = $product['price100'];
    $sectiondb = (int) $product['section'];

    if ($sectiondb <= 2 || $sectiondb == 5) {
        $price25 = $product['price25'];
    }
?>
        <div class="products__item product">
            <div class="product__cell product__cell_type_hero">
                <a href="#card" class="popup-link" onclick="goodsCard(<?php echo "'$id', '$vandor', '$oem', '$price100', '$price25', '$sectiondb', '$img', '$user_id'"; ?>)"><img src="<?php echo $img; ?>" alt="" class="product__image"></a>
            </div>
            <div class="product__cell-group">
                <div class="product__cell product__cell_type_info">
                    <div class="product__label">Артикул</div>
                    <div class="product__caption"><?php echo $vandor; ?></div>
                </div>
                <div class="product__cell product__cell_type_description">
                    <div class="product__label">Наименование</div>
                    <div class="product__caption"><?php echo $oem; ?></div>
                </div>
                <?php if ($sectiondb <= 2) { ?>
                    <div class="product__cell product__cell_type_price">
                        <div class="product__label">Цена за 1 шт. (от 100 шт.)</div>
                        <div class="product__price"><span class="product__price-value"><?php echo $price100; ?></span> руб.</div>
                    </div>
                    <div class="product__cell product__cell_type_price">
                        <div class="product__label">Цена за 1 шт. (от 25 шт.)</div>
                        <div class="product__price"><span class="product__price-value"><?php echo $price25; ?></span> руб.</div>
                    </div>
                <?php } elseif ($sectiondb == 5) { ?>
                    <div class="product__cell product__cell_type_price">
                        <div class="product__label">Цена за 1 шт. для партнёров</div>
                        <div class="product__price"><span class="product__price-value"><?php echo $price100; ?></span> руб.</div>
                    </div>
                    <div class="product__cell product__cell_type_price">
                        <div class="product__label">Цена за 1 шт. для оптовиков</div>
                        <div class="product__price"><span class="product__price-value"><?php echo $price25; ?></span> руб.</div>
                    </div>
                <?php } else { ?>
                    <div class="product__cell product__cell_type_price">
                        <div class="product__label">Цена за 1 шт.</div>
                        <div class="product__price"><span class="product__price-value"><?php echo $price100; ?></span> руб.</div>
                    </div>
                <?php } ?>
                <div class="product__cell product__cell_type_count">
                    <button class="operator minus" onclick="TableStep(<?php echo "'$id', '$sectiondb'"; ?>, 'minus')">-</button>
                    <input class="<?php echo $id; ?>" type="text" value="0" disabled="">
                    <button class="operator plus" onclick="TableStep(<?php echo "'$id', '$sectiondb'"; ?>, 'plus')">+</button>
                </div>
                <div class="product__cell product__cell_type_btn">
                    <a href="#" class="product__btn" title="В корзину" onclick="addToCart(<?php echo "'$id', '$vandor', '$user_id'"; ?>, '')"></a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
<?php } elseif ($section == 0 && $search == NULL) { ?>
    <div class="intro">
        <h1 class="intro__title">Дорогие друзья!</h1>
        <p>Праздники уже закончились, а мы продолжаем дарить подарки! Наши специалисты трудились безустанно все выходные, для того чтобы согреть Вас этой зимой приятным предложением. Теперь Вы можете использовать накопительную систему скидок, совершая покупки через нашу программу. Для этого достаточно просто пользоваться autofasteners.pro и совершать заказы.</p>
        <p>Подробные условия использования бальной системы можно просмотреть по ссылке <a href="/points.pdf"><strong>Условия использования баллов</strong></a></p>
    </div>
    <div class="rubrics">
        <a href="/?route=price_list&section=1" class="rubrics__item">
            <img src="/tmp/content-images/rubric-1.jpg" alt="" width="172" height="140" class="rubrics__hero">
            <div class="rubrics__caption">Клипсы</div>
        </a>
        <a href="/?route=price_list&section=2" class="rubrics__item">
            <img src="/tmp/content-images/rubric-2.jpg" alt="" width="172" height="140" class="rubrics__hero">
            <div class="rubrics__caption">Металл</div>
        </a>
        <a href="/?route=price_list&section=3" class="rubrics__item">
            <img src="/tmp/content-images/rubric-3.jpg" alt="" width="172" height="140" class="rubrics__hero">
            <div class="rubrics__caption">Стяжки</div>
        </a>
        <a href="/?route=price_list&section=4" class="rubrics__item">
            <img src="/tmp/content-images/rubric-4.jpg" alt="" width="172" height="140" class="rubrics__hero">
            <div class="rubrics__caption">Разъёмы</div>
        </a>
        <a href="/?route=price_list&section=5" class="rubrics__item">
            <img src="/tmp/content-images/rubric-5.jpg" alt="" width="172" height="140" class="rubrics__hero">
            <div class="rubrics__caption">Инструмент</div>
        </a>
    </div>
<?php } ?>
</div>
<div class="overlay"></div>
<div class="cart-alert">
    Добавлено!<br />
    <a href="/?route=cart" class="cart-alert__link">Перейти в корзину</a>
</div>
