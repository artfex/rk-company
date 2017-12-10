<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Загрузка ТОП-300
 * @version 201703.15
 */
?>
<div class="content">
    <form method="POST" enctype="multipart/form-data">
        <legend>Загрузка ТОП-300</legend>
        <b>Выберите файл Excel</b><br />
        <input type="file" name="filename" /><br />
        <input type="hidden" name="update" value="OK" /><br />
        <input type="submit" name="top300Load" value="Загрузить" /><br />
    </form>
</div>
