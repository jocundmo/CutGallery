<?php defined("SYSPATH") or die("No direct script access.") ?>
<li>
  <? $name = $menu->label->for_html() ?>
  <? $hover_text = t("Your profile")->for_html_attr() ?>
  <?= t("Logged in as %name", array("name" => html::mark_clean(
          "<span title='$hover_text' id='$menu->id'>{$name}</span>"))) ?>
        <? //"<a href='$menu->url' title='$hover_text' id='$menu->id'>{$name}</a>")))  // CutGallery - Disabled the user profile link ?>
</li>
