<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Данные страницы
 * @version 201703.10
 */
class Meta {

    /**
     * @description Запускаем скрипт установки соединения
     * @var type
     */
    private $db;
    private $route;

    public function __construct() {
        $this->db = Connect::_self()->mysql();
    }

    /**
     * @description Получаем данные о страницах
     * @return type
     */
    public function page() {
        return $this->db->query("SELECT * FROM `pagemeta`");
    }

    /**
     * @description Получить данные о данной странице
     * @param type $content
     * @return type
     */
    public function thispage($content) {
        $get_route = filter_input(INPUT_GET, 'route');
        $user_role = $this->user('role');
        $query = $this->db->query("SELECT * FROM `pagemeta`");
        while ($page = $query->fetch_array(MYSQLI_ASSOC)) {
// Если $_GET не пустое и если страница есть в базе данных и она доступна пользователю
            if (isset($get_route) && !empty($get_route) && $page['guid'] === $get_route && $page['role'] >= $user_role) {
                $result = $page["$content"];
            } elseif ($page['role'] == $user_role && $page['orderliness'] == 0) {
                $result = $page["$content"];
            }
        }
        return $result;
    }

    /**
     * @description Получить данные о данном пользователе
     * @param type $data
     * @return int
     */
    public function user($data) {
        $user_id = $_SESSION['user']['id'];
        if (isset($user_id) && !empty($user_id)) {
            $query = $this->db->query("SELECT * FROM `users` WHERE `id` = $user_id");
            $result = $query->fetch_array(MYSQLI_ASSOC);
            return $result["$data"];
        } else {
            return 10;
        }
    }

    /**
     * @description Получаем информацию о другом пользователе
     * @param type $user_id
     * @return boolean
     */
    public function users($user_id, $data) {
        $query = $this->db->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
        if (!$query) {
            return FALSE;
        }
        $result = $query->fetch_array(MYSQLI_ASSOC);
        return $result["$data"];
    }

}
