<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="add_photo_helper">
    <ul>
        <li>
            <?= t("批量上传请使用ftp服务")?>
        </li>
        <li><?= t("您可以打开您的资源管理器并在地址栏键入，或者使用ftp客户端访问如下")?></li>
        <li><?="<b> ftp://".$_SERVER['SERVER_ADDR'].'/'.$item->name."</b>" ?></li>
        <li><?="按提示输入ftp账号和密码（如有不知请咨询管理员）"?></li>
        <li><?="拖入您的照片，稍等片刻刷新页面就能看到啦"?></li>
    </ul>

<?= $form ?>
</div>