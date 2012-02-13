<!DOCTYPE html> 
<html> 
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <? $theme->start_combining("script,css") ?>
    <title>
      <? if ($page_title): ?>
        <?= $page_title ?>
      <? else: ?>
        <? if ($theme->item()): ?>
          <?= $theme->item()->title ?>
        <? elseif ($theme->tag()): ?>
          <?= t("Photos tagged with %tag_title", array("tag_title" => $theme->tag()->name)) ?>
        <? else: /* Not an item, not a tag, no page_title specified.  Help! */ ?>
          <?= item::root()->title ?>
        <? endif ?>
      <? endif ?>
    </title>
    <link rel="shortcut icon"
          href="<?= url::file(module::get_var("gallery", "favicon_url")) ?>"
          type="image/x-icon" />
    <link rel="apple-touch-icon-precomposed"
          href="<?= url::file(module::get_var("gallery", "apple_touch_icon_url")) ?>" />
    <? if ($theme->page_type == "collection"): ?>
      <? if ($thumb_proportion != 1): ?>
        <? $new_width = round($thumb_proportion * 113) ?>
        <? $new_height = round($thumb_proportion * 140) ?>
        <style type="text/css">
        .g-view #g-content #g-album-grid .g-item {
          width: <?= $new_width ?>px;
          height: <?= $new_height ?>px;
          /* <?= $thumb_proportion ?> */
        }
        </style>
      <? endif ?>
    <? endif ?>

    <?= $theme->script("json2-min.js") ?>
    <?= $theme->script("jquery.js") ?>
    <?= $theme->script("jquery.form.js") ?>
    <?= $theme->script("jquery-ui.js") ?>
    <?= $theme->script("gallery.common.js") ?>
    <? /* MSG_CANCEL is required by gallery.dialog.js */ ?>
    <script type="text/javascript">
    var MSG_CANCEL = <?= t('Cancel')->for_js() ?>;
    </script>
    <?= $theme->script("gallery.ajax.js") ?>
    <?= $theme->script("gallery.dialog.js") ?>
    <?= $theme->script("superfish/js/superfish.js") ?>
    <?= $theme->script("jquery.localscroll.js") ?>

    <? /* These are page specific but they get combined */ ?>
    <? if ($theme->page_subtype == "photo"): ?>
    <?= $theme->script("jquery.scrollTo.js") ?>
    <?= $theme->script("gallery.show_full_size.js") ?>
    <? elseif ($theme->page_subtype == "movie"): ?>
    <?= $theme->script("flowplayer.js") ?>
    <? endif ?>

    <?= $theme->head() ?>

    <? /* Theme specific CSS/JS goes last so that it can override module CSS/JS */ ?>
    <?= $theme->script("ui.init.js") ?>
    <?= $theme->css("yui/reset-fonts-grids.css") ?>
    <?= $theme->css("superfish/css/superfish.css") ?>
    <?= $theme->css("themeroller/ui.base.css") ?>
    <?= $theme->css("screen.css") ?>
    <?= $theme->css("cutGallery-main.css") ?>
    <? if (locales::is_rtl()): ?>
    <?= $theme->css("screen-rtl.css") ?>
    <? endif; ?>
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="<?= $theme->url("css/fix-ie.css") ?>"
          media="screen,print,projection" />
    <![endif]-->

    <!-- LOOKING FOR YOUR CSS? It's all been combined into the link below -->
    <?= $theme->get_combined("css") ?>

    <!-- LOOKING FOR YOUR JAVASCRIPT? It's all been combined into the link below -->
    <?= $theme->get_combined("script") ?>
</head>
<!--  <head> 
    <title>I Love Smile</title> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" /> 
    <link href="<?//= url::file("themes/wind/Content/style.css") ?>" rel="stylesheet" type="text/css" /> 
    <script src="Scripts/jquery-1.4.4.min.js" type="text/javascript"></script> 
</head> -->
<body> 

<div id="mainHead">
    <div id="logo">
        <a href="<?= url::site() ?>"></a>
    </div>

    <div id="mainInfo">
        <ul>
            <? if (identity::active_user()->admin): ?>
                <li id="admin"><a href="<?= url::site("admin/home") ?>">admin</a></li>
            <? endif ?>
            <li><?= $theme->user_menu() ?></li>
        </ul>
    </div>

    <div id="mainNav">
        <ul>
            <li id="gallery"><a class="<?= ($theme->user->name == "guest" ? "g-dialog-link" : "") ?>" href="<?= url::site("albums")?>"></a></li>
            <li id="intro"><a href="<?= url::site("about") ?>"></a></li>
            <li id="contactus"><a href="<?= url::site("contact") ?>"></a></li>
        </ul>
    </div>

    <div class="div-clear"></div>
</div>

<div id="mainContent">
    <div id="g-content" class="yui-g">
      <?= $theme->messages() ?>
      <?= $content ?>
      <?= $theme->messages() ?>
    </div>
</div>

<div id="footer">
    <p> 
        Copyright reserved - internal released v1.3.2.0
    </p> 
</div>

<!--<div id="main"> 
    <div id="main-photo"> 
        <img src="<?//= url::file("themes/wind/images/indexphoto.jpg") ?>" alt="" /> 
    </div> 
</div> -->

</body> 
</html> 