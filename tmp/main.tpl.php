<?php

/**
 * @author Ашурбеков Магомед <cloud@cgen.pro>
 * @description Структура шаблона
 * @version 201702.06
 */
include_once 'header.tpl.php';
if ($meta->user('role') > 0 && $meta->user('role') !== 10) {
    include_once './tmp/top.tpl.php';
}
include_once './tmp/page/' . $meta->thispage('partition') . '/' . $meta->thispage('guid') . '.tpl.php';
if ($meta->user('role') > 0 && $meta->user('role') !== 10) {
    include_once './tmp/bottom.tpl.php';
}
include_once 'footer.tpl.php';
