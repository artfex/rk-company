<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @desk Валидация
 * @version 201610.31
 */
class Validate {

    public function __construct() {

    }

    /**
     * @description Проверка, авторизован ли пользователь
     * @return boolean
     */
    public static function UserStatus() {
        // Фильтруем глобальные переменные
        $session = filter_input(INPUT_SESSION, 'user', 'id');
        $cookie = filter_input(INPUT_COOKIE, 'user', 'id');

        if (isset($session) && !empty($session) || isset($cookie)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Отчищаем от тегов строковые переменные
     * @param <string> $field - Поле
     * @param <boolean> $mode - Использовать htmlspecialchars или strip_tags
     */
    public static function clear($field, $mode = FALSE) {
        if ($mode === TRUE) {
            return htmlspecialchars($field);
        } else {
            return strip_tags($field);
        }
    }

    /**
     * @description Хэширование данных
     * @param type $data
     * @return type
     */
    public static function hashInit($data) {
        return hash('sha256', $data);
    }

    /**
     * @description Хэширование данных
     * @param type $email
     * @return boolean
     */
    public static function EmailValidate($email) {
        return TRUE;
    }

}
