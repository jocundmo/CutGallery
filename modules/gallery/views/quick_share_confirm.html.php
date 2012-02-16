<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="g-share-dialog" class="ui-helper-clearfix">
  <? if ($item->is_album()): ?>
    <!-- CutGallery - Couldn't be album here -->
    <?//= "share the album <b>%title</b>? All photos in the album will also be deleted."?>
    <?//= t("Delete the album <b>%title</b>? All photos and movies in the album will also be deleted.", array("title" => html::purify($item->title))) ?>
  <? else: ?>
    <input readonly="true" class="share-url" value='<?= t("%title", array("title" => html::purify("http://".$_SERVER["SERVER_NAME"].url::site("form/share/photos/".$item->hashed_name)))) ?>'></input>
    <span class="share-title">
        <?= t("Copy to clipboard") ?>
    </span>
  <? endif ?>
  <?= $form ?>
</div>