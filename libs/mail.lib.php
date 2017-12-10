<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Работа с почтой
 * @version 201611.08
 */
class Mail {

    /**
     * @param type $to
     * @param type $subject
     * @param type $message
     * @return boolean
     */
    public static function new_mail($to, $subject, $message) {
        $headers = 'From: avtodok@avtodok.com' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        if ($to === 'administrator') {
            $to = 'avtodok@avtodok.com';
        }
        if ($to === 'manager') {
            $to = 'order@avtodok.com';
        }
        if ($to === 'develop') {
            $to = 'director@algoritm.tech';
        }
        if ($to === 'doubleDevelop') {
            $to = 'ashurbekovmagomed@yandex.ru';
        }
        if (mail($to, $subject, $message, $headers)) {
            return TRUE;
        }
        return FALSE;
    }

}
