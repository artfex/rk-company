<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description История покупок
 * @version 201701.30
 */
class Purchases {

    private $db;

    public function __construct() {
        $this->db = Connect::_self()->mysql();
    }

    /**
     * Список корзин
     * @return array|int
     */
    public function listBaskets() {
        $list = $this->db->query("SELECT * FROM `list_baskets`");
        if ($list->num_rows == 0) {
            return 0;
        } else {
            $array = array();
            foreach ($list as $value) {
                $user_id = $value['user_id'];
                $user = $this->db->query("SELECT `email`, `tel`, `country`, `name` FROM `users` WHERE `id` = '$user_id'");
                $user = $user->fetch_array(MYSQLI_ASSOC);
                array_push($array, array(
                    'id' => $value['id'],
                    'user_id' => $value['user_id'],
                    'maxsum' => $value['maxsum'],
                    'points' => $value['points'],
                    'date' => $value['date'],
                    'verification' => (int) $value['verification'],
                    'email' => $user['email'],
                    'tel' => $user['tel'],
                    'country' => $user['country'],
                    'name' => $user['name']
                ));
            }
            return $array;
        }
    }

    /**
     * Список покупок в корзине
     * @return array|int
     */
    public function purchaseHistory($baskets_id) {
        $query = $this->db->query("SELECT * FROM `purchase_history`");
        if ($list->num_rows == 0) {
            return 0;
        } else {
            return $query;
        }
    }

}
