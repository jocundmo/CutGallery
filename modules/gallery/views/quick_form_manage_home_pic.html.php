<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="manage_home_pic_helper">
    <ul>
        <li>
            <?= t("请使用ftp服务")?>
        </li>
        <li><?= t("您可以打开您的资源管理器并在地址栏键入，或者使用ftp客户端访问如下")?></li>
        <li><?= t("首页图片现一共支持5套替换")?></li>
        <? for ($i=0; $i<5; $i++): ?>
            <li><?= t("若要替换第".$i."套图，请使用如下地址：ftp://www.ilovesmile.hk/homepic/site".$i."")?></li>
        <? endfor ?>
        <li><?= t("按提示输入ftp账号和密码（如有不知请咨询管理员）")?></li>
        <li><?= t("拖入您的照片，稍等片刻刷新页面就能看到啦") ?></li>
    </ul>
<?= $form ?>
</div>