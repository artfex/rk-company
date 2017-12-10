<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Верхняя панель
 * @version 201703.13
 */

$user_id = $meta->user('id');
$section = (int) filter_input(INPUT_GET, 'section');
$search = filter_input(INPUT_GET, 'search');
?>
<link rel="stylesheet" href="/tmp/css/global.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar__outer">
            <div class="sidebar__inner">
                <div class="sidebar__header">
                    <a href="/" class="logo">R&amp;K company</a>
                    <div class="slogan">Оптовый online<br> прайс-каталог товаров</div>
                </div>
                <div class="sidebar__content">
                    <div class="sidebar__content-outer">
                        <div class="sidebar__content-inner">
                            <nav class="nav">
                                <ul class="nav__list">
                                    <li class="nav__item <?php
                                    if ($section === 1) {
                                        echo "nav__item_active";
                                    }
                                    ?>"><a href="/?route=price_list&section=1" class="nav__link">Клипсы</a></li>
                                    <li class="nav__item <?php
                                    if ($section === 2) {
                                        echo "nav__item_active";
                                    }
                                    ?>"><a href="/?route=price_list&section=2" class="nav__link">Металл</a></li>
                                    <li class="nav__item <?php
                                    if ($section === 3) {
                                        echo "nav__item_active";
                                    }
                                    ?>"><a href="/?route=price_list&section=3" class="nav__link">Стяжки</a></li>
                                    <li class="nav__item <?php
                                    if ($section === 4) {
                                        echo "nav__item_active";
                                    }
                                    ?>"><a href="/?route=price_list&section=4" class="nav__link">Разъёмы</a></li>
                                    <li class="nav__item <?php
                                    if ($section === 5) {
                                        echo "nav__item_active";
                                    }
                                    ?>"><a href="/?route=price_list&section=5" class="nav__link">Инструмент</a></li>
                                    <li class="nav__item <?php
                                    if ($search === 'new') {
                                        echo "nav__item_active";
                                    }
                                    ?>"><a href="/?route=price_list&search=new" class="nav__link">Новинки</a></li>
                                    <li class="nav__item <?php
                                    if ($search === 'top300') {
                                        echo "nav__item_active";
                                    }
                                    ?>"><a href="/?route=price_list&search=top300" class="nav__link">ТОП-300</a></li>
                                </ul>
                            </nav>
                            <div class="contacts">
                                <div class="contacts__tel">8 800 250-70-06</div>
                                <div class="contacts__email">avtodok@avtodok.com</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header class="header">
        <div class="toggle">
            <div class="toggle__arrow"></div>
            <div class="toggle__stick"></div>
        </div>
        <div class="search">
            <button onclick="Search()" class="search__btn"></button>
            <input type="text" class="search__input" placeholder="Поиск">
        </div>
        <div class="header__nav">
            <a href="#callorder" class="callorder popup-link">Заказать по телефону</a>
            <div class="profile dropdown">
                <a href="#" class="profile__link dropdown__toggle">
                    <img src="/tmp/content-images/userpic.png" alt="" class="profile__hero">
                </a>
                <div class="dropdown__menu">
                    <div class="dropdown__arrow"></div>
                    <div class="p-nav">
                        <?php
                        foreach ($meta->page() as $value) {
                            $guid = $value['guid'];
                            $title = $value['title'];
                            if ($meta->user('role') === 10 && $value['role'] === '10') {
                                echo "<div class='p-nav__item'><a href='/?route=$guid' class='p-nav__link'>$title</a></div>";
                            } elseif ($value['role'] >= $meta->user('role') && $meta->user('role') !== 10 && $value['role'] !== '10') {
                                echo "<div class='p-nav__item'><a href='/?route=$guid' class='p-nav__link'>$title</a></div>";
                            }
                        }
                        ?>
                        <div class="p-nav__item p-nav__item_type_exit"><a href="/?route=logout" class="p-nav__link">Выход</a></div>
                    </div>
                </div>
            </div>
            <div class="hcart dropdown">
                <a href="#" class="hcart__link dropdown__toggle"><span class="hcart__num"></span></a>
                <div class="dropdown__menu dropdown__menu_holder_hcart">
                    <div class="dropdown__arrow"></div>
                    <div class="minicart"></div>
                </div>
            </div>
            <div class="hnotice" onclick="location.href='/?route=to_read_own_notices'">
                <i class="material-icons notice-icon"></i><span class="hnotice__num"></span>
            </div>
            <div class="hnotice" onclick="orderTOP300(<?php echo $user_id; ?>)" alt="Добавить ТОП-300 в корзину">
                <i class="material-icons">add_shopping_cart</i><span class="htop300__num">ТОП-300</span>
            </div>
            <a href="#feedback" class="feedback popup-link"></a>
        </div>
    </header>
