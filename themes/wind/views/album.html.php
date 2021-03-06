<?php defined("SYSPATH") or die("No direct script access.") ?>
<? // @todo Set hover on AlbumGrid list items for guest users ?>
<!--album.html.php start -->
<script>
function overItem1(full_id){
    $("#" + full_id).removeClass("ui-icon-2")
    $("#" + full_id).addClass("ui-icon-2-highlight")
}
function leaveItem1(full_id){
    $("#" + full_id).removeClass("ui-icon-2-highlight")
    $("#" + full_id).addClass("ui-icon-2")
}</script>
<? if ($theme->item->level < 2): ?>


<script> 
// CutGallery

function clearItemCovers(){
    var selectionsContainer = document.getElementById("g-item-panel");
    var selections = selectionsContainer.getElementsByTagName("ul");
    //var selections = document.getElementsByName('g-item-panel-name');
    //alert(selections.length)

    for (var i=0;i<selections.length;i++){
        if (selections[i].id != ''){
        selections[i].style.display='none'
        $("#g-album-grid li h2 a").css("color", "");
        $("#g-album-grid li").css("background-color", "")
        }
    }
}
var originalColor;
var originalBackColor;
function leaveItem(full_id){
    $("#" + full_id + " h2 a").css("color", originalColor + "");
    $("#" + full_id).css("background-color", originalBackColor + "");
}
function overItem(full_id){
    originalColor=$("#" + full_id + " h2 a").css("color");
    originalBackColor=$("#" + full_id).css("background-color");
    $("#" + full_id + " h2 a").css("color", "lightgrey");
    $("#" + full_id).css("background-color", "#545454");
}
function selectItem(full_id, container_id){
    clearItemCovers();
    document.getElementById(container_id).style.display='block';
    $("#" + full_id + " h2 a").css("color", "white");
    $("#" + full_id).css("background-color", "#949599");
    originalColor=$("#" + full_id + " h2 a").css("color");
    originalBackColor=$("#" + full_id).css("background-color");
}
function showDefaultCover(){ // default is the first one
    var album_panel_container = document.getElementById("g-item-panel");
    var album_panel_list = album_panel_container.getElementsByTagName("ul");
    var album_container = document.getElementById("g-album-grid");
    var album_list = album_container.getElementsByTagName("li");
    if (album_panel_list.length > 0 && album_list.length > 0){
            selectItem(album_list[0].id, album_panel_list[0].id);
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
<? if ($theme->item->level < 2): ?>

<ul id="album_header">
    <li id="album_header_cpation"><?= t("Albums") ?></li>
    <? if (access::can("add", $item)): ?>
    <li id="album_header_new"><?= $theme->add_album_menu() ?></li>
    <? endif ?>
</ul>
<? else: ?>
<?= $theme->paginator() ?>
<? if (access::can("add", $item)): ?>
    <?= $theme->add_photos_menu() ?>
    <?= $theme->add_photos_help_menu() ?>
<? endif ?>
<? endif ?>
<ul id="g-album-grid" class="ui-helper-clearfix <?= ($theme->item->level < 2) ? "album_container" : "photo_container"?>">
<? if (count($children)): ?>
  <? $index = 0; ?>
  <? foreach ($children as $i => $child): ?>
    <? $item_class = "g-photo"; ?>
    <? if ($child->is_album()): ?>
      <? $item_class = "g-album"; ?>
    <? endif ?> <!-- CutGallery - MODIFIED -->
    <li title="<?= ($theme->item->level < 2) ? t("Click album cover to enter"): "" ?>" id="g-item-id-<?= $child->id ?>" class="ui-corner-all g-item <?= $item_class ?>" <?= ($theme->item->level < 2) ? "onmouseout=leaveItem(this.id); onmouseover=overItem(this.id); onclick=\"selectItem(this.id, 'g-item-panel-$child->id');\"" : ""?>>
    <?= $theme->thumb_top($child) ?>
    <a href="<?= $_REQUEST['page'] == '' ? $child->url() : $child->url().'?page='.$_REQUEST['page'] ?>">
      <? if ($child->has_thumb()): ?>
        <? if ($child->is_album()): ?>
            <? // if is Album, no thumb img to show.?>
        <? elseif ($child->is_photo()): ?>
        <div id="back_shadow" class="ui-corner-all">
            <?= $child->thumb_img(array("class" => "g-thumbnail ui-corner-all"), 150) ?>
        </div>
        <? endif ?> 
      <? endif ?>
    </a>
    <?= $theme->thumb_bottom($child) ?>
    <?= $theme->context_menu($child, "#g-item-id-{$child->id} .g-thumbnail") ?>
   <h2><!-- <span class="<?//= $item_class ?>"></span>-->
        <? if ($child->is_album()): ?>  
            <a href="#"><?= html::purify($child->title) ?></a>
        <? else: ?>
            <a title="<?= html::purify($child->title) ?>" href="<?= $_REQUEST['page'] == '' ? $child->url() : $child->url().'?page='.$_REQUEST['page'] ?>"><?= html::truncate(html::purify($child->title), 15) ?></a>
        <? endif ?>
    </h2>
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
  
  <li><?= t("There aren't any items yet!")?></li>
  <? $index=0; ?>
  <? if ($theme->item->level > 1):?>
      <? for (;$index < 25; $index++): ?>
      <li class="g-item g-photo"></li>
      <? endfor ?>
  <? endif ?>
<? endif; ?>
</ul>
<? if ($theme->item->level < 2): ?>

 <script language="JavaScript" type="text/javascript">
        function LoadClearImage(item){
            var imga = new Image();
            imga.src = item.src.replace("thumbs", "resizes");
            imga.onload = function() {
                item.src = this.src;
            }
	}
        $(function(){
            var img_covers = $(".album_cover div a img");
            for (var i = 0; i < img_covers.length; i++){
                LoadClearImage(img_covers[i]);
                }
            
            });
  </script>
<!-- CutGallery - ADDED -->
<div id="g-item-panel">
<!-- <ul id="g-item-panel-default" class="album_panel_parent">
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
        </ul> -->
       <? if (count($children)): ?>
          <? foreach ($children as $i => $child): ?>
                <ul id="g-item-panel-<?= $child->id ?>" class="album_panel_parent">
                    <li id="g-item-cover-<?= $child->id ?>" class="album_cover ui-corner-all">
                        <div>
                            <? if ($child->is_album()): ?>  
                               <? if ($child->album_cover()): ?>
                                   <a style="display:block" href='<?= $child->url() ?>'><?= $child->thumb_img(array("class" => "g-album-thumbnail ui-corner-all", "id" => "img-cover-".$child->id)) ?></a>
                               <? else: ?>
                                   <a style="display:block" href='<?= $child->url() ?>'><img id="g-item-cover-no-item" class="g-album-thumbnail ui-corner-all" src="<?= url::file("themes/wind/images/album-cover-noitem.jpg")?>"/></a>
                               <? endif ?>
                                
                            <? endif ?>
                        </div>
                    </li>
                    <li id="g-item-prop-<?= $child->id ?>" class="album_prop">
                        <span title="<?= html::purify($child->title)?>"><?= t("Name").":" ?> <?= html::truncate(html::purify($child->title), 10) ?></span>
                        <span><?= t("Owner").":" ?> <?= user::lookup($child->owner_id)->name ?></span>
                        <span><?= t("Photos").":" ?> <?= item::lookup_photos_by_owner_and_album($child->owner_id, $child->id) ?></span> <!-- CutGallery - Fix the count of photos -->
                        <? if (access::can("add", $item)): ?>
                            <?= $theme->edit_album_menu($child) ?>
                            <?= $theme->delete_album_menu($child) ?>
                            <?= $theme->add_photos_menu($child) ?>
                        <? endif ?>
                    </li>
                    <li id="g-item-comments-<?= $child->id ?>" class="album_comments">
                        <span class="g-description"></br><?= html::max_rows(html::truncate(nl2br(html::purify($child->description)), 260), 2, 1) ?></span>
                    </li>
                </ul>
        <? endforeach ?>
       <? endif ?>
</div>

<? endif ?>

<?= $theme->album_bottom() ?>

<?= $theme->paginator() ?>
<? if ($theme->item->level > 1): ?>
    <? if (access::can("add", $item)): ?>
        <?= $theme->add_photos_menu() ?>
    <? endif ?>
<? endif ?>   
<!--album.html.php end -->
