<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Маршрутизация
 * @version 201703.14
 */
class Route {

    private static $tmp;
    private $meta;
    private static $get_route;
    private static $post;

    public function __construct() {
        self::$tmp = new Tmp();
        self::dispatcher();
        self::data();
    }

    /**
     * @description Маршрутизация данных
     * @return type
     */
    public static function dispatcher() {
        $meta = new Meta();
        $registration = new Registration();
        $get_route = filter_input(INPUT_GET, 'route');
        if (isset($get_route) && !empty($get_route)) {
            $route = explode('/', strip_tags($get_route));
            if ($route[0] === 'activate') {
                $activate_key = trim($route[2]);
                $id = intval($route[1]);

                if ($registration->verification_account($id, $activate_key)) {
                    self::location(HTTP_PATH . '?route=login', 3);
                    exit('E-mail подтверждён! ');
                } else {
                    exit('Произошла ошибка подтверждения E-mail! <a href="/">Вернуться на форму входа.</a>');
                }
            } elseif ($route[0] === 'role') {
                $activate_key = trim($route[2]);
                $id = intval($route[1]);

                if ($registration->role_account($id, $activate_key)) {
                    self::location(HTTP_PATH . '?route=login', 3);
                    exit('Пользователь активирован! <a href="/">Вернуться на форму входа.</a>');
                } else {
                    exit('Произошла ошибка активации пользователя! <a href="/">Вернуться на форму входа.</a>');
                }
            } elseif ($route[0] === 'logout') {
                setCookie("user_id", '');
                $_SESSION['user']['id'] = '';
            } else {
                foreach ($meta->page('') as $value) {
                    if ($route[0] === $value['guid']) {
                        return $value['guid'];
                    }
                }
            }
        }
    }

    /**
     * @description Работа с данными POST / COOKIE / SESSION
     */
    public static function data() {
        try {
            if (isset($_POST) && !empty($_POST)) {
                $registration = new Registration();
                $load = new Load();
                $cart = new Cart();
                $notification = new Notification();
                $message = new Message();
                if (isset($_POST['signup'])) {
                    if ($registration->signup($_POST)) {
                        die('Успешная регистрация! Перейдите на свою почту для активации акаунта<br><a href="/">Вернуться на главную страницу</a>');
                    } else {
                        echo '<div class="error">Произошла ошибка в момент регистрации!</div>';
                    }
                }
                if (isset($_POST['login'])) {
                    if ($registration->login($_POST)) {
                        self::location(HTTP_PATH);
                    } else {
                        echo '<div class="error">Ошибка при входе</div>';
                    }
                }
                if (isset($_POST['excelLoad'])) {
                    if ($load->excelLoad($_POST)) {
                        echo '<div class="error">Загрузка выполнена успешно</div>';
                    } else {
                        echo '<div class="error">Ошибка при загрузки файла</div>';
                    }
                }
                if (isset($_POST['top300Load'])) {
                    if ($load->top300Load($_POST)) {
                        echo '<div class="error">Загрузка выполнена успешно</div>';
                    } else {
                        echo '<div class="error">Ошибка при загрузки файла</div>';
                    }
                }
                if (isset($_POST['sendorder'])) {
                    if ($cart->sendOrder($_POST)) {
                        echo '<div class="error">Заказ успешно отправлен! <a href="/?route=table">Вернуться в прайс-лист?</a></div>';
                    } else {
                        echo '<div class="error">Ошибка отправки заказа!</div>';
                    }
                }
                if (isset($_POST['toCreateTheNotice'])) {
                    if ($notification->toCreateTheNotice($_POST)) {
                        echo '<div class="error">Рассылка выполнена</div>';
                    } else {
                        echo '<div class="error">Ошибка выполнения рассылки!</div>';
                    }
                }
                if (isset($_POST['sendMessage'])) {
                    $message->sendMessage($_POST);
                }
                if (isset($_POST['verificationPoints'])) {
                    $cart->verificationPoints($_POST);
                }
                if (isset($_POST['callOrder'])) {
                    $message->callOrder($_POST);
                }
            }
        } catch (Exception $ex) {
            echo '<div class="error">' . $ex->getMessage() . '</div>';
        }
    }

    /**
     * @discription Редирект
     * @param type $url
     * @param type $time
     */
    public static function location($url, $time = 0) {
        if ($time === 0) {
            @header('Location:' . $url);
        } else {
            @header('Refresh:' . $time . ';url=' . $url);
        }
    }

}
