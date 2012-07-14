<?php defined("SYSPATH") or die("No direct script access.") ?>

<? if (access::can("view_full", $theme->item())): ?>
<!-- Use javascript to show the full size as an overlay on the current page -->
<script>
function overItem1(full_id){
    $("#" + full_id).removeClass("ui-icon-2")
    $("#" + full_id).addClass("ui-icon-2-highlight")
}
function leaveItem1(full_id){
    $("#" + full_id).removeClass("ui-icon-2-highlight")
    $("#" + full_id).addClass("ui-icon-2")
}</script>
<script type="text/javascript">
  $(document).ready(function() {
    full_dims = [<?= $theme->item()->width ?>, <?= $theme->item()->height ?>];
    $(".g-fullsize-link").click(function() {
      $.gallery_show_full_size(<?= html::js_string($theme->item()->file_url()) ?>, full_dims[0], full_dims[1]);
      return false;
    });

    // After the image is rotated or replaced we have to reload the image dimensions
    // so that the full size view isn't distorted.
    $("#g-photo").bind("gallery.change", function() {
      $.ajax({
        url: "<?= url::site("items/dimensions/" . $theme->item()->id) ?>",
        dataType: "json",
        success: function(data, textStatus) {
          full_dims = data.full;
        }
      });
    });
  });
</script>
<? endif ?>

<div id="g-item">
  <?= $theme->photo_top() ?>

  
  <div id="g-photo-top-decoration"  class="back_shadow_class"></div>
  <div id="g-photo"><div id="g-photo-decoration"  class="back_shadow_class">
    <?= $theme->resize_top($item) ?>
    <!--<?// if (access::can("view_full", $item)): ?>
    <a href="<?//= $item->file_url() ?>" class="g-fullsize-link" title="<?//= t("View full size")->for_html_attr() ?>">
      <? //endif ?> -->
      <?// here we show the thumb img first for user friendly, at behind, we load the resize img, when done, replace the resize with the fuzzy thumb image. ?>
      <?= $item->thumb_img(array("id" => "g-item-id-{$item->id}", "class" => "g-resize ui-corner-all pic_shadow"),null,false,$item->resize_width,$item->resize_height) ?>
      <!--<?// if (access::can("view_full", $item)): ?>
    </a>
    <?// endif ?>-->
    <?= $theme->resize_bottom($item) ?></div>
  </div>
  <script language="JavaScript" type="text/javascript">
	var img = new Image();
	img.src = "<?= $item->resize_url(); ?>";
	img.onload = function() {
	document.getElementById("g-item-id-<?=$item->id?>").src = this.src;
	}
  </script>
 
  <div id="g-photo-bottom-decoration" class="back_shadow_class">
         <?= $theme->paginator() ?>
  </div>

  <div id="g-info">
      <h1 title="<?= html::purify($item->title) ?>"><?= html::truncate(html::purify($item->title), 15) ?></h1>
    <div><?= nl2br(html::purify($item->description)) ?></div>
  </div>

</div>
