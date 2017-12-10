<?php

/**
 * @author Ашурбеков Магомед <cloud@cgen.pro>
 * @desk Подключение шаблона
 * @version 201611.15
 */
class Tmp {

    public $ext;
    private $variables = [];

    // Расширение шаблона
    public function __construct() {
        $this->ext = '.tpl.php';
    }

    /**
     * Присваиваем переменные шаблона
     * @param $name <string>
     * @param $value <mixed>
     */
    public function assign($name, $value) {
        $this->variables[$name] = $value;
    }

    // Отображение шаблона
    public function show_display($file_include) {
        // Экземпляр класса мета
        if (!file_exists(TMP . '/' . $file_include . $this->ext)) {
            throw new Exception('Файл шаблона не найден');
        } else {
            $meta = new Meta();
            require_once TMP . '/' . $file_include . $this->ext;
        }
    }

    public function __get($name) {
        if (isset($this->variables[$name])) {
            $variable = $this->variables[$name];
            return $variable;
        } else {
            return FALSE;
        }
    }

}
