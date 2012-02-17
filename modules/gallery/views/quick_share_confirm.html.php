<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
function CopyUrl() {
    if (navigator.userAgent.indexOf("MSIE") == -1) {
        alert("您的浏览器不支持此功能,请手工复制文本框中内容");
        return false;
    }
    clipboardData.setData('text', $("#fe_text").val());
    alert("复制成功，请粘贴到你的QQ/MSN上推荐给你的好友！内容如下：" + $("#fe_text").val());
}
</script>
<div id="g-share-dialog" class="ui-helper-clearfix">
  <? if ($item->is_album()): ?>
    <!-- CutGallery - Couldn't be album here -->
    <?//= "share the album <b>%title</b>? All photos in the album will also be deleted."?>
    <?//= t("Delete the album <b>%title</b>? All photos and movies in the album will also be deleted.", array("title" => html::purify($item->title))) ?>
  <? else: ?>
    <input id="fe_text" class="share-url" value='<?= t("%title", array("title" => html::purify("http://".$_SERVER["SERVER_NAME"].url::site("form/share/photos/".$item->hashed_name)))) ?>'></input>
    <span id="d_clip_button" class="share-title">
        <a onClick='CopyUrl();' href="#"><?= t("Copy to clipboard") ?></a> 
    </span>
  <? endif ?>
  <?= $form ?>
</div>