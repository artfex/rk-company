<?php

/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Количество во всплывающем окне
 * @version 201702.25
 */
$id = (int) filter_input(INPUT_POST, 'id');
$vandor = filter_input(INPUT_POST, 'vandor');
$sectiondb = (int) filter_input(INPUT_POST, 'sectiondb');
$type = filter_input(INPUT_POST, 'type');
$user_id = (int) filter_input(INPUT_POST, 'user_id');
if ($type == 'step') {
    $msg = "<button class = 'operator minus' onclick = \"TableStep('$id', '$sectiondb', 'minus')\">-</button>"
            . "<input class = '$id' type = 'text' value = '0' disabled = ''>"
            . "<button class = 'operator plus' onclick = \"TableStep('$id', '$sectiondb', 'plus')\">+</button>";
} elseif ($type == 'addcard') {
    $msg = "<button class='btn btn_type_success btn_size_md' onclick=\"addToCart('$id', '$vandor', '$user_id', '')\">В корзину</button>";
}
echo $msg;
