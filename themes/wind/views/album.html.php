<?php defined("SYSPATH") or die("No direct script access.") ?>
<? // @todo Set hover on AlbumGrid list items for guest users ?>
<!--album.html.php start -->
<? if ($theme->item->level < 2): ?>
<script> 
// CutGallery

function clearItemCovers(){
    var selectionsContainer = document.getElementById("g-item-panel");
    var selections = selectionsContainer.getElementsByTagName("ul")
    //var selections = document.getElementsByName('g-item-panel-name');
    //alert(selections.length)

    for (var i=0;i<selections.length;i++){
        if (selections[i].id != ''){
        selections[i].style.display='none'
        }
    }
}
function showItemCover(v){
    //alert('g-item-cover-'+v)
    clearItemCovers();
    document.getElementById('g-item-panel-'+v).style.display='block';
    //document.getElementById('<?//='g-item-panel-'.$child->id?>').style.display='none'
}
function showDefaultCover(){ // default is the first one
    var selectionsContainer = document.getElementById("g-item-panel");
    var selections = selectionsContainer.getElementsByTagName("ul")
    //var selections = document.getElementsByName('g-item-panel-name');
    //alert(selections.length)

    for (var i=0;i<selections.length;i++){
        if (selections[i].id != ''){
        selections[i].style.display='block';
        //alert(selections[i].id)
        break;
        }
    }
}
$(function(){
    clearItemCovers();
    showDefaultCover();
})
</script>
<? endif ?>
<div id="g-info" style="display:none"> <!-- CutGallery - Hide -->
  <?= $theme->album_top() ?>
  <h1><?= html::purify($item->title) ?></h1>
  <div class="g-description"><?= nl2br(html::purify($item->description)) ?></div>
</div>
<div id="g-add-items">
    <? if ($theme->item->level < 2): ?>
    <ul id="album_header">
        <li id="album_header_cpation"><?= t("Albums") ?></li>
        <? if (access::can("add", $item)): ?>
        <li id="album_header_new"><?= $theme->add_album_menu() ?></li>
        <? endif ?>
    </ul>
    <? else: ?>
        <? if (access::can("add", $item)): ?>
            <?= $theme->add_photos_menu() ?>
        <? endif ?>
    <? endif ?>
</div>
<ul id="g-album-grid" class="ui-helper-clearfix <?= ($theme->item->level < 2) ? "album_container" : "photo_container"?>">
<? if (count($children)): ?>
  <? $index = 0; ?>
  <? foreach ($children as $i => $child): ?>
    <? $item_class = "g-photo"; ?>
    <? if ($child->is_album()): ?>
      <? $item_class = "g-album"; ?>
    <? endif ?> <!-- CutGallery - MODIFIED -->
    <li id="g-item-id-<?= $child->id ?>" class="g-item <?= $item_class ?>" <?= ($theme->item->level < 2) ? "onmouseover=showItemCover($child->id)" : ""?>>
    <?= $theme->thumb_top($child) ?>
    <a href="<?= $child->url() ?>">
      <? if ($child->has_thumb()): ?>
        <? if ($child->is_album()): ?>
            <? // if is Album, no thumb img to show.?>
        <? elseif ($child->is_photo()): ?>
            <?= $child->thumb_img(array("class" => "g-thumbnail ui-corner-all"), 150) ?>
        <? endif ?> 
      <? endif ?>
    </a>
    <?= $theme->thumb_bottom($child) ?>
    <?= $theme->context_menu($child, "#g-item-id-{$child->id} .g-thumbnail") ?>
    <h2><span class="<?= $item_class ?>"></span>
      <a href="<?= $child->url() ?>"><?= html::purify($child->title) ?></a></h2>
    <ul class="g-metadata">
      <?= $theme->thumb_info($child) ?>
    </ul>
  </li>
  <? $index++; ?>
  <? endforeach ?>
  <? if ($theme->item->level > 1):?>
      <? for (;$index < 25; $index++): ?>
      <li class="g-item g-photo"></li>
      <? endfor ?>
  <? endif ?>
<? else: ?>
<!--  <? // if ($user->admin || access::can("add", $item)): ?>
  <? //$addurl = url::site("uploader/index/$item->id") ?>
  <li><? //= t("There aren't any photos here yet! <a %attrs>Add some</a>.",
          //  array("attrs" => html::mark_clean("href=\"$addurl\" class=\"g-dialog-link\""))) ?></li>
  <? // else: ?>
  <li><? //= t("There aren't any photos here yet!") ?></li>
  <? // endif; ?>-->
  
  <?= t("There aren't any items yet!")?>
<? endif; ?>
</ul>
<? if ($theme->item->level < 2): ?>
<!-- CutGallery - ADDED -->
<div id="g-item-panel">    
<!--       <ul id="g-item-panel-default" class="album_panel_parent">
            <li id="g-item-cover-default" class="album_cover">
                <div>
                    <?//= $child->thumb_img(array("class" => "g-album-thumbnail ui-corner-all")) ?>
                </div>
            </li>
            <li id="g-item-prop-default" class="album_prop">

            </li>
            <li id="g-item-comments-default" class="album_comments">
                <span class="g-description"></span>
            </li>
        </ul>-->
       <? if (count($children)): ?>
          <? foreach ($children as $i => $child): ?>
                <ul id="g-item-panel-<?= $child->id ?>" class="album_panel_parent">
                    <li id="g-item-cover-<?= $child->id ?>" class="album_cover">
                        <div>
                            <? if ($child->is_album()): ?>
                                <a href='<?= $child->url() ?>'><?= $child->thumb_img(array("class" => "g-album-thumbnail ui-corner-all")) ?></a>
                            <? endif ?>
                        </div>
                    </li>
                    <li id="g-item-prop-<?= $child->id ?>" class="album_prop">
                        <span>Album Name: <?= html::purify($child->title) ?></span>
                        <span>Owner: <?= $child->owner_id ?></span>
                        <span>Pic Quantity:</span>
                        <? if (access::can("add", $item)): ?>
                            <?= $theme->edit_album_menu($child) ?>
                            <?= $theme->delete_album_menu($child) ?>
                            <?= $theme->add_photos_menu($child) ?>
                        <? endif ?>
                    </li>
                    <li id="g-item-comments-<?= $child->id ?>" class="album_comments">
                        <span class="g-description"><?= nl2br(html::purify($child->description)) ?></span>
                    </li>
                </ul>
        <? endforeach ?>
       <? endif ?>
</div>

<? endif ?>

<?= $theme->album_bottom() ?>

<?= $theme->paginator() ?>
<!--album.html.php end -->
