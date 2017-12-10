<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Регистрация пользователя
 * @version 201703.17
 */
class Registration {

    private $db;

    public function __construct() {
        $this->db = Connect::_self()->mysql();
    }

    /**
     * @description Регистрация пользователя
     * @param type $data
     * @return boolean
     * @throws Exception
     */
    public function signup($data) {
        // Присваеваем переменные
        $email = Validate::clear(mb_strtolower($data['email']));
        $phone = substr(preg_replace("/[^0-9]/", '', $data['phone']), -10, 10);
        $country = $data['city'];
        $password = Validate::hashInit($data['password']);
        $repeat_password = Validate::hashInit($data['repeat_password']);
        $name = $data['name'];
        $time = time();

        // Проверяем данные на соответствия
        if (Validate::EmailValidate($email) === FALSE) {
            throw new Exception('Введите корректный E-mail');
        }
        if (!$this->UniqEmail($email)) {
            throw new Exception('Такой E-mail уже зарегистрирован');
        }

        if ($password !== $repeat_password) {
            throw new Exception('Пароль не совпадает');
        }

        if (strlen($phone) !== 10 || $phone === '' || $phone === 0) {
            throw new Exception("Введите корректный номер телефона");
        }
        if (!$this->UniqTel($phone)) {
            throw new Exception('Такой телефон уже зарегистрирован');
        }

        // Записываем данные в таблицу
        $query = $this->db->query("INSERT INTO `users` (`email`, `tel`, `country`, `password`, `name`, `date_register`) VALUES('$email', '$phone', '$country', '$password', '$name', '$time')");

        // Проверяем на наличие ошибок
        if ($query) {
            // Отправляется письмо проверки почты
            $id = $this->db->insert_id;
            $key_hash = Validate::hashInit("$email::$password");
            $link_activate = HTTP_PATH ."?route=activate/$id/$key_hash";
            Mail::new_mail($email, 'Подтверждение почты', "Здравствуйте, $name!<br />Вы только что зарегистрировались на сайте <a href='https://rk-company.com'>rk-company.com</a>.<br />Для подтверждения аккаунта, кликните по ссылке активации: $link_activate");
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @description Подтверждение почты
     * @param type $id
     * @param type $activate_key
     * @return boolean
     */
    public function verification_account($id, $activate_key) {
        // Выбрать пользователя в базе данных и присвоение переменных
        $query = $this->db->query("SELECT * FROM `users` WHERE `id` = $id");
        $result = $query->fetch_array(MYSQLI_ASSOC);
        $email = $result['email'];
        $password = $result['password'];
        $name = $result['name'];
        $phone = $result['tel'];
        $country = $result['country'];
        $key_hash = Validate::hashInit("$password::$email");
        $link_role = HTTP_PATH . "?route=role/$id/$key_hash";
        if ($activate_key === Validate::hashInit("$email::$password")) {
            if ($this->db->query("UPDATE `users` SET `activate` = 1 WHERE `email` = '$email'")) {
                Mail::new_mail("manager", "Активация аккаунта $name!", "E-mail: $email<br />Имя: $name<br />Телефон: $phone<br />Город: $country<br />Только что зарегистрировался. Для подтверждения аккаунта, перейдите в административную панель сайта или по ссылке: $link_role");
                Mail::new_mail($email, "Активация аккаунта!", "Здравствуйте, $name! Вы подтвердили свою почту, и теперь осталось дождаться проверки Вашей анкеты администратором сайта. После успешной проверки Вы получите уведомление на E-mail!");
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * @description Выдача прав пользователю
     * @param type $id
     * @param type $activate_key
     * @return boolean
     */
    public function role_account($id, $activate_key) {
        // Выбрать пользователя в базе данных и присвоение переменных
        $query = $this->db->query("SELECT * FROM `users` WHERE `id` = $id");
        $result = $query->fetch_array(MYSQLI_ASSOC);
        $email = $result['email'];
        $password = $result['password'];
        $name = $result['name'];
        if ($activate_key === Validate::hashInit("$password::$email")) {
            if ($this->db->query("UPDATE `users` SET `role` = 3 WHERE `email` = '$email'")) {
                Mail::new_mail($email, "Активация аккаунта!", "Здравствуйте, $name! Ваша анкета проверена и успешно активирована администратором сайта. Теперь Вы можете заходить на сайт <a href='https://rk-company.com'>rk-company.com</a> используя свой логин и пароль!");
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * @description Авторизация пользователя
     * @param type $data
     * @return boolean
     * @throws Exception
     */
    public function login($data) {
        // Присвоение переменных введённым данным
        $email = Validate::clear(mb_strtolower($data['email']));
        $password = Validate::hashInit($data['password']);
        $query = $this->db->query("SELECT `id`, `email`, `password`, `activate`, `role` FROM `users` WHERE `email` = '$email'");
        $result = $query->fetch_array(MYSQLI_ASSOC);
        if ($result['email'] === $email && $password === $result['password']) {
            if ($result['activate'] == 0) {
                throw new Exception('Ваша почта не подтверждена');
            } elseif ($result['role'] == 0) {
                throw new Exception('Администратор ещё не активировал Вашу запись');
            }
            setCookie("user_id", $result['id']);
            $_SESSION['user']['id'] = $result['id'];
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @description Проверка E-mail на существование
     * @param type $email
     * @return boolean
     */
    public function UniqEmail($email) {
        $query = $this->db->query("SELECT `id` FROM `users` WHERE `email` = '$email'");
        $result = $query->fetch_array(MYSQLI_ASSOC);
        if (empty($result['id'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @description Проверка Телефона на существование
     * @param type $phone
     * @return boolean
     */
    public function UniqTel($phone) {
        $query = $this->db->query("SELECT `id` FROM `users` WHERE `tel` = '$phone'");
        $result = $query->fetch_array(MYSQLI_ASSOC);
        if (empty($result['id'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
