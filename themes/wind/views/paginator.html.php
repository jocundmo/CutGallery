<?php defined("SYSPATH") or die("No direct script access.") ?>
<?
// This is a generic paginator for album, photo and movie pages.  Depending on the page type,
// there are different sets of variables available.  With this data, you can make a paginator
// that lets you say "You're viewing photo 5 of 35", or "You're viewing photos 10 - 18 of 37"
// for album views.
//
// Available variables for all page types:
//   $page_type               - "collection", "item", or "other"
//   $page_subtype            - "album", "movie", "photo", "tag", etc.
//   $previous_page_url       - the url to the previous page, if there is one
//   $next_page_url           - the url to the next page, if there is one
//   $total                   - the total number of photos in this album
//
// Available for the "collection" page types:
//   $page                    - what page number we're on
//   $max_pages               - the maximum page number
//   $page_size               - the page size
//   $first_page_url          - the url to the first page, or null if we're on the first page
//   $last_page_url           - the url to the last page, or null if we're on the last page
//   $first_visible_position  - the position number of the first visible photo on this page
//   $last_visible_position   - the position number of the last visible photo on this page
//
// Available for "item" page types:
//   $position                - the position number of this photo
//
?>
<!-- Identify the css class for each icon -->
<? if ($page_type == "collection"): ?>
    <? $is_share = false;?>
    <? if (isset($item) && $item->level > 1): ?>
      <? $id_g_paginator = "id-g-paginator-level-2" ?>
      <? $class_seek_back = "ui-icon-seek-back-level-2" ?>
      <? $class_prev = "ui-icon-seek-prev-level-2" ?>
      <? $class_paginator_info = "ui-icon-paginator-info-level-2" ?>
      <? $class_next = "ui-icon-seek-next-level-2" ?>
    <? else: ?>
      <? $id_g_paginator = "id-g-paginator-level-1" ?>
      <? $class_seek_back = "ui-icon-seek-back-level-1" ?>
      <? $class_prev = "ui-icon-seek-prev-level-1" ?>
      <? $class_paginator_info = "ui-icon-paginator-info-level-1" ?>
      <? $class_next = "ui-icon-seek-next-level-1" ?>
    <? endif ?>
  <? elseif ($page_type == "item"): ?>
    <? $is_share = $this->parent_theme->is_share ?>
    <? $id_g_paginator = $is_share ? "id-g-paginator-share" : "id-g-paginator" ?>
    <? $class_seek_back = "ui-icon-seek-back" ?>
    <? $class_prev = "ui-icon-seek-prev" ?>
    <? $class_paginator_info = "ui-icon-paginator-info" ?>
    <? $class_next = "ui-icon-seek-next" ?>
<? endif ?>

<!--Identity the visibility for each icon-->
<? if (isset($item) && $item->level > 1): ?>
    <? $show_back = true ?>
<? else: ?>
    <? $show_back = false ?>
<? endif ?>
<? $show_prev = true ?>
<? $show_info = true ?>
<? $show_next = true ?>
<? if ($page_type == "item"): ?>
    <? $show_share = true ?>
    <? $show_download = true ?>
<? else: ?>
    <? $show_share = false ?>
    <? $show_download = false ?>
<? endif ?>
<? if ($is_share): ?>
    <? $show_back = false ?>
    <? $show_prev = false ?>
    <? $show_info = false ?>
    <? $show_next = false ?>
    <? $show_share = false ?>
    <? $show_download = true ?>
<? endif ?>
<ul id="<?=$id_g_paginator?>" class="g-paginator ui-helper-clearfix">
<? if($show_back): ?>
  <li class="g-back">    
      <a href ="<?= $back_page_url ?>" class="g-button ui-corner-all">
          <span id="span_back" class="ui-icon-2 <?=$class_seek_back?>" onmouseover=overItem1(this.id) onmouseout=leaveItem1(this.id)></span></a> <!-- CutGallery - ADDED -->
  </li>
<? endif ?>
<? if ($show_prev): ?>
  <li class="g-first">
  <? if ($page_type == "collection"): ?>
    <? if (isset($first_page_url)): ?>
<!--      <a href="<?= $first_page_url ?>" class="g-button ui-icon-left ui-corner-all">
        <span class="ui-icon ui-icon-seek-first"></span><?= t("First") ?></a>-->
    <? else: ?>
<!--      <a class="g-button ui-icon-left ui-state-disabled ui-corner-all">
        <span class="ui-icon ui-icon-seek-first"></span><?= t("First") ?></a>-->
    <? endif ?>
  <? endif ?>
  <? if (isset($previous_page_url)): ?>
    <a href="<?= $previous_page_url ?>" class="g-button ui-icon-left ui-corner-all">
      <span id="span_prev" class="ui-icon-2 <?=$class_prev?>" onmouseover=overItem1(this.id) onmouseout=leaveItem1(this.id)></span></a> <!-- CutGallery - REMOVE text -->
      
  <? else: ?>
    <a class="g-button ui-icon-left ui-state-disabled ui-corner-all">
      <span class="ui-icon-2 <?=$class_prev?>"></span></a> <!-- CutGallery - REMOVE text -->
  <? endif ?>
  </li>
<? endif ?>
<? if ($show_info): ?>
  <li class="g-info">      
    <? if ($total): ?>
      <? if ($page_type == "collection"): ?>
      <span class="ui-corner-all <?=$class_paginator_info?>">
        <?= /* @todo This message isn't easily localizable */
            t2("%from_number/%count",
               "%from_number-%to_number/%count",
               $total,
               array("from_number" => $first_visible_position,
                     "to_number" => $last_visible_position,
                     "count" => $total)) ?></span>
      <? else: ?>
        <?= t("%position/%total", array("position" => $position, "total" => $total)) ?>
      <? endif ?>
    <? else: ?>
      <span class="ui-corner-all <?=$class_paginator_info?>"> 
      <?= t("No items") ?></span>
    <? endif ?>
  </li>
<? endif ?>
<? if ($show_next): ?>
  <li class="g-text-right">
  <? if (isset($next_page_url)): ?>
    <a href="<?= $next_page_url ?>" class="g-button ui-icon-right ui-corner-all">  
      <span id="span_next" class="ui-icon-2 <?=$class_next?>" onmouseover=overItem1(this.id) onmouseout=leaveItem1(this.id)></span></a> <!--CutGallery - REMOVE-->
  <? else: ?>
    <a class="g-button ui-state-disabled ui-icon-right ui-corner-all">
      <span class="ui-icon-2 <?=$class_next?>"></span></a> <!--CutGallery - REMOVE-->
  <? endif ?>

  <? if ($page_type == "collection"): ?>
    <? if (isset($last_page_url)): ?>
<!--      <a href="<?= $last_page_url ?>" class="g-button ui-icon-right ui-corner-all">
        <span class="ui-icon ui-icon-seek-end"></span><?= t("Last") ?></a>-->
    <? else: ?>
<!--      <a class="g-button ui-state-disabled ui-icon-right ui-corner-all">
        <span class="ui-icon ui-icon-seek-end"></span><?= t("Last") ?></a>-->
    <? endif ?>
  <? endif ?>
  </li>
<? endif ?>  
<? if ($show_share): ?>
  <?= $this->parent_theme->share_photo_menu($item) ?>
<!--  <li class="g-share">
      <a href ="<?//= $this->parent_theme->share_photo_menu($item) ?>" class="g-button ui-corner-all">
          <span class="ui-icon-2 ui-icon-seek-share"></span></a>
  </li>-->
<? endif ?>
<? if ($show_download): ?>
  <li class="g-download-full">
      <a href ="<?= $download_full_url ?>" class="g-button ui-corner-all">
          <span id="span_download" class="ui-icon-2 ui-icon-seek-download" onmouseover=overItem1(this.id) onmouseout=leaveItem1(this.id)></span></a>
  </li>
<? endif ?>
</ul>
