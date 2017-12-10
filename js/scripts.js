/**
 * @author Ашурбеков Магомед
 * @version 201703.13
 */

/**
 * @description Кнопка "Добавить в корзину"
 * @param {type} id
 * @param {type} vandor
 * @param {type} user_id
 * @param {type} quantity
 * @returns {undefined}
 */
function addToCart(id, vandor, user_id, quantity) {
    if (quantity === '') {
        quantity = $('.' + id).val();
    }
    $.ajax({
        type: "POST",
        url: "/js/ajax/addtocart.php",
        data: {'vandor': vandor, 'user_id': user_id, 'quantity': quantity},
        success: function (data) {
            showCart(user_id);
        },
        error: function (xhr) {
            alert('Возникла ошибка: ' + xhr.status + ' ' + xhr.statusText);
        }
    });
}

/**
 * @description Кнопка "Отправить заказ на ТОП-300"
 */
function orderTOP300(user_id) {
    if (confirm("Заказать ТОП-300?") === true) {
        $.ajax({
            type: "POST",
            url: "/js/ajax/ordertop300.php",
            data: {'user_id': user_id},
            success: function (data) {
                alert(data);
            },
            error: function (xhr) {
                alert('Возникла ошибка: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    }
}

/**
 * @description Отобразить живую корзину
 * @param {type} user_id
 * @returns {undefined}
 */
function showCart(user_id) {
    $(function () {
        $.ajax({
            type: "POST",
            url: "/js/ajax/showcart.php",
            data: {"user_id": user_id, "show": "rows"},
            success: function (data) {
                $("span.hcart__num").html(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "/js/ajax/showcart.php",
            data: {"user_id": user_id, "show": "data"},
            success: function (data) {
                $("div.minicart").html(data);
            }
        });
    });
}

/**
 * @description Очистить корзину
 */
function truncateCart(user_id) {
    if (confirm("Очистить корзину?") === true) {
        $.ajax({
            type: "POST",
            url: "/js/ajax/truncatecart.php",
            data: {'user_id': user_id},
            success: function (data) {
                showCart(user_id);
                alert(data);
            },
            error: function (xhr) {
                alert('Возникла ошибка: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    }
}

/**
 * @description Шаг и изменение количества товара в корзине
 * @param {type} id
 * @param {type} section
 * @param {type} operator
 * @returns {undefined}
 */
function TableStep(id, section, operator) {
    $(function () {
        // Задаём переменные
        id = +id; // ID товара
        section = +section; // Секция
        var step; // Шаг
        var quantity = $("input." + id).val(); // Количество товара в строке
        // Для клипс и металлов
        if (section === 1 || section === 2) {
            var module = +quantity.substr(-2, 2); // Модуль последних двух чисел в строке
            if (module === 50 && operator === 'plus') {
                step = 50;
                quantity = +quantity;
                quantity = quantity + step;
            }
            if (module === 0 && operator === 'plus' || module === 25 && operator === 'plus') {
                step = 25;
                quantity = +quantity;
                quantity = quantity + step;
            }
            if (module === 0 && quantity > 0 && operator === 'minus') {
                step = 50;
                quantity = +quantity;
                quantity = quantity - step;
            }
            if (module === 25 && operator === 'minus' || module === 50 && operator === 'minus') {
                step = 25;
                quantity = +quantity;
                quantity = quantity - step;
            }
        }

        // Разъёмы
        if (section === 4) {
            step = 10;
            if (operator === 'minus' && quantity > 0) {
                quantity = +quantity;
                quantity = quantity - step;
            }
            if (operator === 'plus') {
                quantity = +quantity;
                quantity = quantity + step;
            }
        }

        // Для стяжек и форсунок
        if (section === 5 || section === 3) {
            step = 1;
            if (operator === 'minus' && quantity > 0) {
                quantity = +quantity;
                quantity = quantity - step;
            }
            if (operator === 'plus') {
                quantity = +quantity;
                quantity = quantity + step;
            }
        }

        $("input." + id).val(quantity);
    });
}

/**
 * @description Перенаправление на страницу поиска
 * @returns {undefined}
 */
function Search() {
    $(function () {
        var search = $("input.search__input").val(); // Получаем переменную из строки поиска
        window.location.href = "/?route=price_list&search=" + search;
    });
}

/**
 * @description Подсчёт количества товара в корзине
 * @param {type} id
 * @param {type} section
 * @param {type} quantity
 * @param {type} price25
 * @param {type} price100
 * @returns {undefined}
 */
function calculationCart(id, section, quantity, price25, price100) {
    $(function () {
        if (section <= 2 && quantity < 100) {
            $("div.price" + id).html(price25 + " руб/шт");
            $("input." + id).val(quantity);
            var sum = quantity * price25;
        } else if (section === 5 && quantity === 1) {
            $("div.price" + id).html(price25 + " руб/шт");
            $("input." + id).val(quantity);
            var sum = quantity * price25;
        } else {
            $("div.price" + id).html(price100 + " руб/шт");
            $("input." + id).val(quantity);
            var sum = quantity * price100;
        }
        $("div.sum" + id).html(sum + " руб.");
    });
}

/**
 * @description Подсчёт суммы и баллов и отображение их в корзине
 * @returns {undefined}
 */
function showSum() {
    $(function () {
        var maxsum = 0;
        $("div.sum").text(function (index, text) {
            text = text.split(' ', 3);
            sum = +text[0];
            maxsum = maxsum + sum;
        });
        var points = Math.floor(maxsum * 0.03);
        $("span.maxsum").html(maxsum + " руб.");
        if (maxsum >= 5000) {
            $("div.minsum").css({"display": "none"});
            $("div.cart__btn-holder").css({"display": "block"});
            $("div.cart__comment").css({"display": "block"});
        } else {
            $("div.minsum").css({"display": "block"});
            $("div.cart__btn-holder").css({"display": "none"});
            $("div.cart__comment").css({"display": "none"});
        }
        if (maxsum < 20000) {
            $("div.points").html("Закажите на сумму более 20 000 рублей, и получи накопительные баллы в размере 3% от суммы покупки");
            $("div.cart__bonus").html("До получения бонуса осталось <span class='cart__bonus-value'>" + (20000 - maxsum) + " руб.</span>");
        } else {
            $("div.points").html("Вы получите " + points + " баллов за эту покупку");
            $("div.cart__bonus").html("Вы получите <span class='cart__bonus-value'>" + points + " баллов</span> за эту покупку");
        }
    });
}


/**
 * @description Изменить количество товара в корзине
 * @param {type} id
 * @param {type} vandor
 * @param {type} section
 * @param {type} quantity
 * @param {type} price25
 * @param {type} price100
 * @param {type} operator
 * @param {type} user_id
 * @returns {undefined}
 */
function editToCart(id, vandor, section, quantity, price25, price100, operator, user_id) {

    $(function () {
        // Задаём переменные
        id = +id; // ID товара
        section = +section; // Секция
        var step; // Шаг
        var quantity = $("input." + id).val();

        // Для клипс и металлов
        if (section === 1 || section === 2) {
            var module = +quantity.substr(-2, 2); // Модуль последних двух чисел в строке
            if (module === 50 && operator === 'plus') {
                step = 50;
                quantity = +quantity;
                quantity = quantity + step;
            }
            if (module === 0 && operator === 'plus' || module === 25 && operator === 'plus') {
                step = 25;
                quantity = +quantity;
                quantity = quantity + step;
            }
            if (module === 0 && quantity > 0 && operator === 'minus') {
                step = 50;
                quantity = +quantity;
                quantity = quantity - step;
            }
            if (module === 25 && operator === 'minus' || module === 50 && operator === 'minus') {
                step = 25;
                quantity = +quantity;
                quantity = quantity - step;
            }
        }

        // Разъёмы
        if (section === 4) {
            step = 10;
            if (operator === 'minus' && quantity > 0) {
                quantity = +quantity;
                quantity = quantity - step;
            }
            if (operator === 'plus') {
                quantity = +quantity;
                quantity = quantity + step;
            }
        }

        // Для стяжек и форсунок
        if (section === 5 || section === 3) {
            step = 1;
            if (operator === 'minus' && quantity > 0) {
                quantity = +quantity;
                quantity = quantity - step;
            }
            if (operator === 'plus') {
                quantity = +quantity;
                quantity = quantity + step;
            }
        }


        editDataCart(id, vandor, user_id, quantity);

        calculationCart(id, section, quantity, price25, price100);
        showCart(user_id);
        showSum();
    });
}

/**
 * @description Изменить количество товара в корзине в базе данных
 * @param {type} id
 * @param {type} vandor
 * @param {type} user_id
 * @param {type} quantity
 * @returns {undefined}
 */
function editDataCart(id, vandor, user_id, quantity) {
    if (quantity === '') {
        quantity = $('.' + id).val();
    }
    $.ajax({
        type: "POST",
        url: "/js/ajax/edittocart.php",
        data: {'vandor': vandor, 'user_id': user_id, 'quantity': quantity},
        success: function () {},
        error: function (xhr) {
            alert('Возникла ошибка: ' + xhr.status + ' ' + xhr.statusText);
        }
    });
}

/**
 * @description Удалить из корзины
 * @param {type} vandor
 * @param {type} user_id
 * @returns {undefined}
 */
function deleteToCart(vandor, user_id) {
    $.ajax({
        type: "POST",
        url: "/js/ajax/deletetocart.php",
        data: {'vandor': vandor, 'user_id': user_id},
        success: function (data) {
            location.reload();
        },
        error: function (xhr) {
            alert('Возникла ошибка: ' + xhr.status + ' ' + xhr.statusText);
        }
    });
}

function goodsCard(id, vandor, oem, price100, price25, sectiondb, img, user_id) {
    $(function () {
        sectiondb = +sectiondb;
        switch (sectiondb) {
            case 1 :
                var section = 'Клипсы';
                var namePrice100 = 'Цена за 1 шт. (от 100 шт.)';
                var namePrice25 = 'Цена за 1 шт. (от 25 шт.)';
                break;
            case 2 :
                var section = 'Металл';
                var namePrice100 = 'Цена за 1 шт. (от 100 шт.)';
                var namePrice25 = 'Цена за 1 шт. (от 25 шт.)';
                break;
            case 3 :
                var section = 'Стяжки';
                var namePrice100 = 'Цена за 1 шт.';
                break;
            case 4 :
                var section = 'Разъёмы';
                var namePrice100 = 'Цена за 1 шт.';
                break;
            case 5 :
                var section = 'Автохимия';
                var namePrice100 = 'Цена за 1 шт. (от 2 шт.)';
                var namePrice25 = 'Цена за 1 шт. (от 1 шт.)';
                break;
        }
        $("span.card__article-name").html(vandor);
        $("h1.card__title").html(oem);
        $("a.card__category").html(section);
        $("img.card__image").attr("src", img);
        $("div.card__label100").html(namePrice100);
        $("div.card__label25").html(namePrice25);
        $("div.card__price100").html(price100);
        $("div.card__price25").html(price25);
        $.ajax({
            type: "POST",
            url: "/js/ajax/card_count.php",
            data: {'id': id, 'sectiondb': sectiondb, 'type': 'step'},
            success: function (data) {
                $("div.card__count-input").html(data);
            },
            error: function (xhr) {
                alert('Возникла ошибка: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
        $.ajax({
            type: "POST",
            url: "/js/ajax/card_count.php",
            data: {'id': id, 'vandor': vandor, 'user_id': user_id, 'type': 'addcard'},
            success: function (data) {
                $("div.card__btn").html(data);
            },
            error: function (xhr) {
                alert('Возникла ошибка: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });
}

/**
 * @description Отобразить уведомления
 * @param {type} user_id
 * @returns {undefined}
 */
function showNotice(user_id) {
    $(function () {
        $.ajax({
            type: "POST",
            url: "/js/ajax/shownotice.php",
            data: {"user_id": user_id},
            success: function (data) {
                data = +data;
                $("span.hnotice__num").html(data);
                if (data === 0) {
                    $("i.notice-icon").html('notifications');
                    $("i.notice-icon").css({"color" : "#000"});
                } else {
                    $("i.notice-icon").html('notifications_active');
                    $("i.notice-icon").css({"color" : "#f00"});
                }
            }
        });
    });
}

/**
 * @description Изменение кнопки при переключении оплаты
 */
function selectPayment(payment) {
    $(function () {
        if (payment === 'norobokassa') {
            $("button[name=sendorder]").html('Отправить заказ');
        } else if (payment === 'robokassa') {
            $("button[name=sendorder]").html('Оплатить заказ');
        }
    });
}
