<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Поиск
 * @version 201702.12
 */

require_once './connect.php';

$search = filter_input(INPUT_POST, 'search');

$query = $mysqli->query("SELECT `id`, `vandor`, `img`, `oem`");
