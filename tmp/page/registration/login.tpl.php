    <link rel="stylesheet" href="/tmp/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/tmp/css/style.css">
</head>
<body>
    <div class="header">
        <div class="top_header">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-xs-4">
                        <a href="" class="logo"><img src="/tmp/img/logo.png" alt="logo"></a>
                    </div>
                    <div class="col-xs-8 tar">
                        <ul class="top_menu">
                            <li><a href="#sign-in" class="sign-in pop-up_a">Вход</a></li>
                            <li><a href="#register" class="register pop-up_a">Регистрация</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="content_block">
            <div class="container">
                <div class="description">
                    Устали от неудобных прайс-листов в формате XLS и надоели ошибки при оформлении заказов?
                </div>
                <div class="title">
                    Оптовый online прайс-каталог товаров от компании RK-Company
                </div>
                <div class="menu_block">
                    <a href="#sign-in" class="sign-in pop-up_a">Вход</a>
                    <a href="#register" class="register pop-up_a">Регистрация</a>
                </div>
                <img src="/tmp/img/browser_window.png" alt="window image" class="widow-image">
            </div>
        </div>
    </div>
    <div class="good_news">
        <div class="container">
            <div class="top_title">У нас отличная новость!</div>
            <div class="good_news-container">
                <div class="col">
                    <div class="good_news-item">
                        <div class="good_news-image"><img src="/tmp/img/good_news-1.png" alt="good_news-image"></div>
                        <p>
                            Мы создали простую в использовании, но очень функциональную программу по оформлению заказов.
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="good_news-item">
                        <div class="good_news-image"><img src="/tmp/img/good_news-2.png" alt="good_news-image"></div>
                        <p>
                            Нашей программой можно пользоваться как на стационарных компьютерах, так и на различных мобильных устройствах.
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="good_news-item">
                        <div class="good_news-image"><img src="/tmp/img/good_news-3.png" alt="good_news-image"></div>
                        <p>
                            При заказе на сумму более 10 000 рублей доставка в любую точку России бесплатно.
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="good_news-item">
                        <div class="good_news-image"><img src="/tmp/img/good_news-4.png" alt="good_news-image"></div>
                        <p>
                            Попробуйте прямо сейчас и вы больше никогда не вернётесь к неудобным форматам.
                        </p>
                        <div><a href="#register" class="register_button pop-up_a">Зарегистрироваться <span></span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-3 footer_logo col-xs-6">
                    <a href=""><img src="/tmp/img/footer_logo.png" alt="footer logo"></a>
                    <span>Оптовый on line <br> прайс-каталог товаров</span>
                </div>
                <div class="col-md-4 col-md-push-5 col-xs-6">
                    <div class="menu_block">
                        <a href="#sign-in" class="sign-in pop-up_a">Вход</a>
                        <a href="#register" class="register pop-up_a">Регистрация</a>
                    </div>
                </div>
                <div class="col-md-5 phone_and_mail col-md-pull-4 col-xs-12 clearfix">
                    <div class="phone">
                        <div class="title">Телефон</div>
                        <a href="">8-800-250-70-06</a></div>
                    <div class="mail">
                        <div class="title">Email</div>
                        <a href="mailto:avtodok@avtodok.com">avtodok@avtodok.com</a></div>
                </div>
            </div>
        </div>
    </div>

    <div id="register" class="pop-up mfp-hide">
        <div class="title">Регистрация</div>
        <a href="#sign-in" class="popup-sign_in pop-up_a">Вход</a>
        <form method="post" class="for_form">
            <div>
                <label>Email<span>*</span></label>
                <input type="text" name="email" required>
                <label class="error"></label>
            </div>
            <div></div>
            <div>
                <label>Пароль<span>*</span></label>
                <input type="password" name="password" required>
                <label class="error"></label>
            </div>
            <div>
                <label>Повторите пароль<span>*</span></label>
                <input type="password" name="repeat_password" required>
                <label class="error"></label>
            </div>
            <div>
                <label>Телефон<span>*</span></label>
                <input type="text" name="phone" required>
                <label class="error"></label>
            </div>
            <div>
                <label>Ваш город<span>*</span></label>
                <input type="text" name="city" required>
                <label class="error"></label>
            </div>
            <div>
                <label>Ф.И.О. или название организации<span>*</span></label>
                <input type="text" name="name" required>
                <label class="error"></label>
            </div>
            <div></div>
            <div><input type="submit" name="signup" value="Регистрация" class="button"></div>
        </form>
        <div class="text">
            Введённые данные проходят многоэтапную проверку. Если они введены не верно, учётная запись активирована не будет. Убедительная просьба вводить полные ФИО или название организации.
        </div>
    </div>

    <div id="sign-in" class="pop-up mfp-hide">
        <div class="title">Авторизация</div>
        <a href="#register" class="popup-register pop-up_a">Регистрация</a>
        <form method="post" class="for_form">
            <div>
                <label>Email<span>*</span></label>
                <input type="text" name="email" required>
                <label class="error"></label>
            </div>
            <div>
                <a href="#no-password" class="dont_know_password pop-up_a">Я забыл пароль</a>
                <label>Пароль<span>*</span></label>
                <input type="password" name="password" required>
                <label class="error"></label>
            </div>
            <div>
                <input type="submit" name="login" value="Авторизация" class="button">
            </div>
        </form>
    </div>

    <div id="no-password" class="pop-up mfp-hide">
        <div class="title">Напоминание пароля</div>
        <a href="#sign-in" class="popup-sign_in pop-up_a">Вход</a>
        <div class="text">
            Если вы забыли пароль, введите E-mail, который привязан к вашей учетной записи. На него вам будет выслана ссылка для смены пароля.
        </div>
        <form action="#" method="post" class="for_form">
            <div>
                <label>Email<span>*</span></label>
                <input type="text" name="email" required>
                <label class="error"></label>
            </div>
            <div>
                <input type="submit" value="Регистрация" class="button">
            </div>
        </form>
    </div>
    <link rel="stylesheet" href="/tmp/libs/magnific-popup/magnific-popup.css" />
    <script src="/tmp/libs/jquery/jquery-1.11.1.min.js"></script>
    <script src="/tmp/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="/tmp/libs/maskedinput/jquery.inputmask.bundle.min.js"></script>
    <script src="/tmp/js/common.js"></script>
