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
            <li><?= t("替换第".$i."套图，请输入如下地址：ftp://www.ilovesmile.hk/homepic/site".$i."")?></li>
        <? endfor ?>
        <li><?= t("按提示输入ftp账号和密码（如有不知请咨询管理员）")?></li>
        <li><?= t("拖入您需要更换的图片") ?></li>
        <li><?= t("图片格式为“318*510”") ?></li>
        <li><?= t("图片名为“home-pic1.jpg，home-pic2.jpg 和 home-pic3.jpg”，单张大小不要超过50k") ?></li>
        <li><?= t("稍等片刻刷新页面") ?></li>
    </ul>
<?= $form ?>
</div>