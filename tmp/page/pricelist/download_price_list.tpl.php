<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Загрузка прайс листа
 * @version 201703.07
 */
?>
<div class="content">
    <form method="POST" enctype="multipart/form-data">
        <legend>Обновление прайс-листа</legend>
        <b>Выберите файл Excel</b><br />
        <input type="file" name="filename" /><br />
        <input type="hidden" name="update" value="OK" /><br />
        <input type="submit" name="excelLoad" value="Загрузить" /><br />
    </form>
</div>
