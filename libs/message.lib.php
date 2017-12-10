<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Отправка сообщений
 * @version 201703.14
 */
class Message {

    private $db;

    public function __construct() {
        $this->db = Connect::_self()->mysql();
    }

    /**
     * @description Отправка сообщения пользователя
     */
    public function sendMessage($data) {
        $meta = new Meta();
        $user_name = $meta->user('name');
        $user_mail = $meta->user('email');
        $user_tel = $meta->user('tel');
        $user_country = $meta->user('country');
        $header = "Имя: $user_name<br />"
                . "Email: $user_mail<br />"
                . "Телефон: $user_tel<br />"
                . "Город: $user_country<br /><br />";

        $message = $data['message'];

        Mail::new_mail("administrator", "Сообщение с программы от пользователя $user_name", "$header <b>$message</b>");
        Mail::new_mail("doubleDevelop", "Сообщение с RK-company от пользователя $user_name", "$header <b>$message</b>");
    }

    /**
     * @description Обратный звонок
     */
    public function callOrder($data) {
        $meta = new Meta();
        $user_name = $meta->user('name');
        $user_mail = $meta->user('email');
        $user_tel = $meta->user('tel');
        $new_tel = $data['tel'];
        $user_country = $meta->user('country');
        $message = "Имя: $user_name<br />"
                . "Email: $user_mail<br />"
                . "<b>Телефон: $new_tel</b><br />"
                . "Телефон,указанный при регистрации: $user_tel<br />"
                . "Город: $user_country<br /><br />";

        Mail::new_mail("administrator", "Обратный звонок от пользователя $user_name", $message);
    }

}
