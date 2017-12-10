<?php

/**
 * @author Ашурбеков Магомед <cloud@cgen.pro>
 * @description Загрузка файлов
 * @version 201701.19
 */
class Load {

    private $db;

    public function __construct() {
        $this->db = Connect::_self()->mysql();
    }

    public function excelLoad($data) {
        $pricelist_db = $this->db->query("CREATE TABLE IF NOT EXISTS `pricelist` (`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, `vandor` VARCHAR(32) NOT NULL, `oem` VARCHAR(255) NOT NULL, `price100` VARCHAR(12), `price25` VARCHAR(12), `section` TINYINT(7) NOT NULL, `new` TINYINT(2) NOT NULL, `top300` TINYINT(2) NOT NUll, PRIMARY KEY (id))");
        if (!$pricelist_db) {
            return FALSE;
        }
        $max_file_size = 5; // Максимальный размер файла в МегаБайтах

        if ($data['update'] == 'OK') {

            // СТАРТ Загрузка файла на сервер
            if ($_FILES['filename']['size'] > $max_file_size * 1024 * 1024) {
                throw new Exception('Размер файла превышает ' . $max_file_size . ' Мб!');
            }
            $fileName = LIBS . '/excel/price.xls';
            if (copy($_FILES['filename']['tmp_name'], $fileName)) {
                echo ('Файл ' . '<b>' . $_FILES['filename']['name'] . '</b>' . ' успешно загружен!<br>');
            } else {
                throw new Exception('Ошибка загрузки файла<br>');
            }

            //СТАРТ Считывание из файла Excel и запись в БД
            require_once LIBS . '/excel/reader.php';
            $dataExcel = new Spreadsheet_Excel_Reader();
            $dataExcel->setOutputEncoding('UTF-8'); //Кодировка выходных данных
            $dataExcel->read($fileName);
            $this->db->query("TRUNCATE TABLE `pricelist`");

            for ($i = 0; $i <= $dataExcel->sheets[0]["numRows"]; $i++) {
                $cell = addslashes(mb_strtolower(trim($dataExcel->sheets[0]["cells"][$i][3])));
                switch ($cell) {
                    case 'клипса китай':
                        $china_clip = $i;
                        break;
                    case 'металл китай':
                        $china_metal = $i;
                        break;
                    case 'клипса турция':
                        $turkey_clip = $i;
                        break;
                    case 'металл турция':
                        $turkey_metal = $i;
                        break;
                    case 'клипса yt':
                        $yt_clip = $i;
                        break;
                    case 'металл yt':
                        $yt_metal = $i;
                        break;
                    case 'акция yt металл':
                        $action = $i;
                        break;
                    case 'стяжки (хомуты)':
                        $line_screed = $i;
                        break;
                    case 'разъемы':
                        $line_connectors = $i;
                        break;
                    case 'инструменты':
                        $line_chemistry = $i;
                        break;
                }
            }

            echo "<br />Клипсы китай на: $china_clip<br />"
            . "Металл китай на: $china_metal<br />"
            . "Клипсы Турция на: $turkey_clip<br />"
            . "Металл Турция на: $turkey_metal<br />"
            . "Клипсы YT на: $yt_clip<br />"
            . "Металл YT на: $yt_metal<br />"
            . "Акции на: $action<br />"
            . "Стяжки на: $line_screed<br />"
            . "Разъёмы на: $line_connectors<br />"
            . "Автохимия на: $line_chemistry<br />";

            // Загружаем клипсы
            for ($i = $china_clip; $i < $china_metal; ++$i) {
                $cell1 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][2]));
                $cell2 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][3]));
                $cell3 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $cell4 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][6]));
                $cell5 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][8]));
                if ($cell5 == 'new') {
                    $new = 1;
                } else {
                    $new = 0;
                }

                if ($cell1 != '') {
                    $result = $this->db->query("INSERT INTO `pricelist` (`vandor`, `oem`, `price100`, `price25`, `section`, `new`) VALUES('$cell1', '$cell2', '$cell3', '$cell4', 1, '$new')");
                }
            }
            for ($i = $turkey_clip; $i < $turkey_metal; ++$i) {
                $cell1 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][2]));
                $cell2 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][3]));
                $cell3 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $cell4 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][6]));
                $cell5 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][8]));
                if ($cell5 == 'new') {
                    $new = 1;
                } else {
                    $new = 0;
                }

                if ($cell1 != '') {
                    $result = $this->db->query("INSERT INTO `pricelist` (`vandor`, `oem`, `price100`, `price25`, `section`, `new`) VALUES('$cell1', '$cell2', '$cell3', '$cell4', 1, '$new')");
                }
            }
            for ($i = $yt_clip; $i < $yt_metal; ++$i) {
                $cell1 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][2]));
                $cell2 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][3]));
                $cell3 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $cell4 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][6]));
                $cell5 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][8]));
                if ($cell5 == 'new') {
                    $new = 1;
                } else {
                    $new = 0;
                }

                if ($cell1 != '') {
                    $result = $this->db->query("INSERT INTO `pricelist` (`vandor`, `oem`, `price100`, `price25`, `section`, `new`) VALUES('$cell1', '$cell2', '$cell3', '$cell4', 1, '$new')");
                }
            }
            // Закончили загружать клипсы
            // Загрузка металла
            for ($i = $china_metal; $i < $turkey_clip; ++$i) {
                $cell1 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][2]));
                $cell2 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][3]));
                $cell3 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $cell4 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][6]));
                $cell5 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][8]));
                if ($cell5 == 'new') {
                    $new = 1;
                } else {
                    $new = 0;
                }

                if ($cell1 != '') {
                    $result = $this->db->query("INSERT INTO `pricelist` (`vandor`, `oem`, `price100`, `price25`, `section`, `new`) VALUES('$cell1', '$cell2', '$cell3', '$cell4', 2, '$new')");
                }
            }
            for ($i = $turkey_metal; $i < $yt_clip; ++$i) {
                $cell1 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][2]));
                $cell2 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][3]));
                $cell3 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $cell4 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][6]));
                $cell5 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][8]));
                if ($cell5 == 'new') {
                    $new = 1;
                } else {
                    $new = 0;
                }

                if ($cell1 != '') {
                    $result = $this->db->query("INSERT INTO `pricelist` (`vandor`, `oem`, `price100`, `price25`, `section`, `new`) VALUES('$cell1', '$cell2', '$cell3', '$cell4', 2, '$new')");
                }
            }
            for ($i = $yt_metal; $i < $action; ++$i) {
                $cell1 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][2]));
                $cell2 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][3]));
                $cell3 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $cell4 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][6]));
                $cell5 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][8]));
                if ($cell5 == 'new') {
                    $new = 1;
                } else {
                    $new = 0;
                }

                if ($cell1 != '') {
                    $result = $this->db->query("INSERT INTO `pricelist` (`vandor`, `oem`, `price100`, `price25`, `section`, `new`) VALUES('$cell1', '$cell2', '$cell3', '$cell4', 2, '$new')");
                }
            }
            // Закочили загружать металл
            // Загружаем стяжки
            for ($i = $line_screed; $i < $line_connectors; ++$i) {
                $cell1 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][2]));
                $cell2 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][3]));
                $cell3 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $cell4 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][6]));
                $cell5 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][8]));
                if ($cell5 == 'new') {
                    $new = 1;
                } else {
                    $new = 0;
                }

                if ($cell1 != '') {
                    $result = $this->db->query("INSERT INTO `pricelist` (`vandor`, `oem`, `price100`, `price25`, `section`, `new`) VALUES('$cell1', '$cell2', '$cell3', '$cell4', 3, '$new')");
                }
            }
            // Закончили загружать стяжки
            // Загружаем разъёмы
            for ($i = $line_connectors; $i < $line_chemistry; ++$i) {
                $cell1 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][2]));
                $cell2 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][3]));
                $cell3 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $cell4 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][6]));
                $cell5 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][8]));
                if ($cell5 == 'new') {
                    $new = 1;
                } else {
                    $new = 0;
                }

                if ($cell1 != '') {
                    $result = $this->db->query("INSERT INTO `pricelist` (`vandor`, `oem`, `price100`, `price25`, `section`, `new`) VALUES('$cell1', '$cell2', '$cell3', '$cell4', 4, '$new')");
                }
            }
            // Закончили загружать разъёмы
            // Загружаем очистители
            for ($i = $line_chemistry; $i <= $dataExcel->sheets[0]["numRows"]; ++$i) {
                $cell1 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][2]));
                $cell2 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][3]));
                $cell3 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $cell4 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][6]));
                $cell5 = addslashes(trim($dataExcel->sheets[0]["cells"][$i][8]));
                if ($cell5 == 'new') {
                    $new = 1;
                } else {
                    $new = 0;
                }

                if ($cell1 != '') {
                    $result = $this->db->query("INSERT INTO `pricelist` (`vandor`, `oem`, `price100`, `price25`, `section`, `new`) VALUES('$cell1', '$cell2', '$cell3', '$cell4', 5, '$new')");
                }
            }
            if (!$result) {
                echo $cell1;
                throw new Exception('Цены не обновлены');
            }
        }
    }

    /**
     * @description Загрузка ТОП-300
     */
    public function top300Load($data) {
        $max_file_size = 5; // Максимальный размер файла в МегаБайтах
        if ($data['update'] == 'OK') {
            // СТАРТ Загрузка файла на сервер
            if ($_FILES['filename']['size'] > $max_file_size * 1024 * 1024) {
                throw new Exception('Размер файла превышает ' . $max_file_size . ' Мб!');
            }
            $fileName = LIBS . '/excel/top300.xls';
            if (copy($_FILES['filename']['tmp_name'], $fileName)) {
                echo ('Файл ' . '<b>' . $_FILES['filename']['name'] . '</b>' . ' успешно загружен!<br>');
            } else {
                throw new Exception('Ошибка загрузки файла<br>');
            }

            //СТАРТ Считывание из файла Excel и запись в БД
            require_once LIBS . '/excel/reader.php';
            $dataExcel = new Spreadsheet_Excel_Reader();
            $dataExcel->setOutputEncoding('UTF-8'); //Кодировка выходных данных
            $dataExcel->read($fileName);
            $this->db->query("UPDATE SET `top300` = 0 FROM `pricelist`");
            $message = '';

            for ($i = 0; $i <= $dataExcel->sheets[0]["numRows"]; $i++) {
                $cell = addslashes(trim($dataExcel->sheets[0]["cells"][$i][4]));
                $result = $this->db->query("UPDATE `pricelist` SET `top300` = 1 WHERE `vandor` = '$cell'");
                if (!$result) {
                    $message = "$message Артикула $cell нет в базе<br />";
                }
            }
        }
        echo $message;
        return TRUE;
    }

}
