<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Подключение к БД
 * @version 201701.25
 */
class Connect {

    private $dbname;
    private $host;
    private $user;
    private $password;
    private $_db;
    public static $_self = NULL;

    private function __construct() {

    }

    /**
     * @return type
     */
    public static function _self() {
        if (self::$_self == NULL) {
            self::$_self = new self();
        }
        return self::$_self;
    }

    /**
     * @description Метод для работы с СУБД MySQL
     * @return type
     */
    public function mysql() {
        $this->_db = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($this->_db->connect_error) {
            exit('(' . $this->_db->connect_errno . ') Ошибка подключения к базе данных!');
        } else {
            $this->_db->set_charset('UTF8');
            return $this->_db;
        }
    }

    /**
     * @param type $user
     * @param type $pass
     * @param type $dbname
     * @param type $host
     */
    public function setDatabase($user, $pass, $dbname, $host) {
        $this->user = $user;
        $this->password = $pass;
        $this->dbname = $dbname;
        $this->host = $host;
    }

}
