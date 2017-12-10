<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Список собственных уведомлений
 * @version 201703.13
 */
$notification = new Notification();
?>
<div class="content">
    <div class="products">
        <?php
        foreach ($notification->readNotification("$user_id") as $readNotification) {
            $id = (int) $readNotification['id'];
            $message_id = (int) $readNotification['message_id'];
            $status = (int) $readNotification['status'];
            $from = $notification->readMessage($message_id, 'from');
            ?>
            <div class="products__item product">
                <div class="product__cell-group">
                    <div class="product__cell product__cell_type_info">
                        <div class="product__label">Дата отправления</div>
                        <div class="product__caption" <?php if ($status === 1) { ?> style="font-weight: normal;" <?php } ?>><?php echo date('d M Y', $notification->readMessage($message_id, 'date')); ?> года</div>
                    </div>
                    <div class="product__cell product__cell_type_info">
                        <div class="product__label">Автор</div>
                        <div class="product__caption" <?php if ($status === 1) { ?> style="font-weight: normal;" <?php } ?>><?php echo $meta->users($from, 'name'); ?></div>
                    </div>
                    <div class="product__cell product__cell_type_info">
                        <div class="product__label">Заголовок</div>
                        <div class="product__caption" <?php if ($status === 1) { ?> style="font-weight: normal;" <?php } ?>><?php echo $notification->readMessage($message_id, 'title'); ?></div>
                    </div>
                    <div class="product__cell product__cell_type_description">
                        <div class="product__label">Содержимое</div>
                        <div class="product__caption" <?php if ($status === 1) { ?> style="font-weight: normal;" <?php } ?>><?php echo $notification->readMessage($message_id, 'description'); ?></div>
                    </div>
                </div>
            </div>
        <?php $notification->editStatusNotification($id); } ?>
    </div>
</div>
