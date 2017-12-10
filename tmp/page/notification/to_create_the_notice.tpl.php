<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Форма отправки уведомления
 * @version 2017.03.10
 */
?>
<div class="content">
    <form method="POST" id="toCreateTheNotice">
        <label>E-mail<label><br />
        <input name="to" type="text" /><br />
        <label>Заголовок<label><br />
        <input name="subject" type="text" /><br />
        <label>Текст</label><br />
        <textarea name="message"></textarea><br />
        <input name="toCreateTheNotice" type="submit" />
    </form>
</div>
