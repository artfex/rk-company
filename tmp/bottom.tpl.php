<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Скрипты и всплывающие окна
 * @version 201703.14
 */
?>

<div class="popup mfp-hide" id="feedback">
    <button class="popup__close" title="Закрыть"></button>
    <div class="popup__title">Оставьте сообщение</div>
    <p>Мы ответим вам на Email в течение 24 часов</p>
    <form method="POST">
        <div class="send-message__label">Сообщение</div>
        <textarea name="message" class="textarea textarea_popup" rows="5"></textarea>
        <footer class="popup__footer">
            <button type="submit" name="sendMessage" class="btn btn_type_default btn_size_lg">Оставить заявку</button>
        </footer>
    </form>
</div>

<div class="popup mfp-hide" id="callorder">
    <button class="popup__close" title="Закрыть"></button>
    <div class="popup__title">Закажите по телефону!</div>
    <p>Для этого нажмите кнопку “оставить заявку” и мы свяжемся с вами для оформления заказа</p>
    <form method="POST">
        <input type="tel" name="tel" class="textarea textarea_popup" placeholder="Введите номер телефона"/>
        <div class="send-message__label">*Если поле оставить пустым, то Вам позвонят на номер указанный при регистрации</div>
        <footer class="popup__footer">
            <button type="submit" name="callOrder" class="btn btn_type_default btn_size_lg">Оставить заявку</button>
        </footer>
    </form>
</div>
<div class="popup mfp-hide" id="thanks">
    <button class="popup__close" title="Закрыть"></button>
    <div class="popup__title">Спасибо за заявку!</div>
    <p>Мы свяжемся с вами в ближайшее время для оформления заказа.</p>
</div>
<div class="popup popup_card mfp-hide" id="card">
    <header class="popup__header">
        <button class="popup__close" title="Закрыть"></button>
    </header>
    <div class="card">
        <h1 class="card__title"></h1>
        <div class="card__container">
            <div class="card__hero">
                <a href="#"><img width="300" height="300" class="card__image"></a>
            </div>
            <div class="card__info">
                <div class="card__row">
                    <div class="card__column">
                        <span class="card__label card__label_inline">Артикул:</span>
                        <span class="card__article"><span class="card__article-name"></span></span>
                    </div>
                    <div class="card__column">
                        <span class="card__label card__label_inline">Категория:</span>
                        <a href="#" class="card__category"></a>
                    </div>
                </div>
                <div class="card__row">
                    <div class="card__column">
                        <div class="card__label card__label100"></div>
                        <div class="card__price card__price100"></div>
                    </div>
                    <div class="card__column">
                        <div class="card__label card__label25"></div>
                        <div class="card__price card__price25"></div>
                    </div>
                </div>
                <div class="card__count">
                    <div class="card__count-label">Выберите необходимое количество товара</div>
                    <div class="card__count-input"></div>
                    <!--<div class="card__count-unit">шт.</div>-->
                </div>
                <footer class="card__footer">
                    <!--<div class="card__total">
                        <span class="card__label card__label_inline">Итого</span>
                        <span class="card__total-value">1200 руб.</span>
                    </div>-->
                    <div class="card__btn">
                        <button class="btn btn_type_success btn_size_md" onclick="addToCart(<?php echo "'$id', '$vandor', '$user_id'"; ?>, '')">В корзину</button>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</div>

<script>showCart('<?php echo $user_id; ?>');</script>
<script>showNotice('<?php echo $user_id; ?>');</script>
<script src="/js/search.js"></script>
<script src="/tmp/js/lib/modernizr-custom.js"></script>
<script src="/tmp/js/lib/jquery.min.js"></script>
<script src="/tmp/js/lib/jquery.magnific-popup.min.js"></script>
<script src="/tmp/js/lib/jquery-ui.min.js"></script>
<script src="/tmp/js/main.js"></script>
