<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Уведомления
 * @version 201703.11
 */
class Notification {

    /**
     * @var type
     */
    private $db;

    public function __construct() {
        $this->db = Connect::_self()->mysql();
    }

    /**
     * @description Инициализация процесса создания уведомления
     * @param type $data
     * @return boolean
     */
    public function toCreateTheNotice($data) {
        // Если таблицы 'message' не существует, то создаём её
        $db_message = $this->db->query("CREATE TABLE IF NOT EXISTS `message` (`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, `title` VARCHAR(40) NOT NULL, `description` VARCHAR(1000) NOT NULL, `from` INT(11) UNSIGNED NOT NULL, `date` INT(10) UNSIGNED NOT NULL , PRIMARY KEY (id))");
        if (!$db_message) {
            return FALSE;
        }
        // Если таблицы 'notification' не существует, то создаём её
        $db_notification = $this->db->query("CREATE TABLE IF NOT EXISTS `notification` (`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, `message_id` INT(11) UNSIGNED NOT NULL, `to` INT(11) UNSIGNED NOT NULL, `status` TINYINT(2) UNSIGNED NOT NULL, `date` INT(10) UNSIGNED NOT NULL , PRIMARY KEY (id))");
        if (!$db_notification) {
            return FALSE;
        }

        $meta = new Meta();
        $time = time(); // Время отправки сообщения
        $user_id = $meta->user('id'); // ID отправителя
        // Запускаем скрипт записи сообщения
        $functionMessage = $this->toCreateTheMessage($data, $user_id, $time);
        if (!$functionMessage) {
            return FALSE;
        }

        // Запускаем скрипт записи уведомления
        $functionNotification = $this->toCreateTheNotification($data, $user_id, $time);
        if (!$functionNotification) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @description Записываем сообщение в базу данных
     * @param type $data
     * @param type $user_id
     * @param type $time
     * @return boolean
     */
    public function toCreateTheMessage($data, $user_id, $time) {
        $subject = $data['subject']; // Заголовок сообщения
        $message = $data['message']; // Текст сообщения

        $result = $this->db->query("INSERT INTO `message` (`title`, `description`, `from`, `date`) VALUES('$subject', '$message', '$user_id', '$time')");
        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @description Отправляем уведомления пользователям
     * @param type $data
     * @param type $user_id
     * @param type $time
     * @return boolean
     */
    public function toCreateTheNotification($data, $user_id, $time) {
        // Вычисляем ID отправленного сообщения
        $message_db = $this->db->query("SELECT `id` FROM `message` WHERE `from` = '$user_id' AND `date` = '$time'");
        if (!$message_db) {
            return FALSE;
        }
        $message_array = $message_db->fetch_array(MYSQLI_ASSOC);
        $message_id = $message_array['id'];
        // Кому отправляем
        $to = $data['to'];
        if ($to === '') {
            for ($i = 1; $i < 10; $i ++) {
                $query = $this->db->query("SELECT `id` FROM `users` WHERE `role` = '$i'");
                foreach ($query as $users) {
                    $users_id = $users['id'];
                    $result = $this->db->query("INSERT INTO `notification` (`message_id`, `to`, `status`, `date`) VALUES('$message_id', '$users_id', 0, 0)");
                    if (!$result) {
                        return FALSE;
                    }
                }
            }
        }
        return TRUE;
    }

    /**
     * @description Уведомления
     * @param type $user_id
     * @return boolean
     */
    public function readNotification($user_id) {
        $query = $this->db->query("SELECT * FROM `notification` WHERE `to` = '$user_id' ORDER BY `id` DESC");
        if (!$query) {
            return FALSE;
        }
        return $query;
    }

    /**
     * @description Сообщения
     * @param type $message_id
     * @return boolean
     */
    public function readMessage($message_id, $data) {
        $query = $this->db->query("SELECT * FROM `message` WHERE `id` = '$message_id'");
        if (!$query) {
            return FALSE;
        }
        $result = $query->fetch_array(MYSQLI_ASSOC);
        return $result["$data"];
    }

    /**
     * @description Изменить статус уведомления
     */
    public function editStatusNotification($id) {
        $date = time();
        $query = $this->db->query("UPDATE `notification` SET `status` = 1, `date` = '$date' WHERE `id` = '$id'");
        if (!$query) {
            return FALSE;
        }
        return TRUE;
    }
}
