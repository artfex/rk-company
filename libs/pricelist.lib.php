<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Отображение товара
 * @version 201702.12
 */
class PriceList {

    /**
     * @var type
     */
    private $db;

    public function __construct() {
        $this->db = Connect::_self()->mysql();
    }

    /**
     * @description Получение прайс-листа
     * @param type $section
     * @param type $search
     * @return type
     */
    public function product($section, $search) {
        if ($search == 'new') {
            return $this->db->query("SELECT * FROM `pricelist` WHERE `new` = 1");
        } elseif ($search == 'top300') {
            return $this->db->query("SELECT * FROM `pricelist` WHERE `top300` = 1");
        } elseif ($search != NULL) {
            return $this->db->query("SELECT * FROM `pricelist` WHERE `vandor` LIKE '%$search%' OR `oem` LIKE '%$search%' ");
        } elseif ($section != 0 || $section != NULL) {
            return $this->db->query("SELECT * FROM `pricelist` WHERE `section` = $section");
        } else {
            return $this->db->query("SELECT * FROM `pricelist`");
        }
    }

}
