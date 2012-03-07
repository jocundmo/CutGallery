<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="home_pictures">
    <ul  class="Slides" id="Slides">
        <? $index = rand(0, 4); ?>
        <li><img style="width: 318px; height: 510px;"src="<?= url::file("themes/wind/homepic/site$index/home-pic1.jpg") ?>"/></li>
        <li><img style="width: 318px; height: 510px;"src="<?= url::file("themes/wind/homepic/site$index/home-pic2.jpg") ?>"/></li>
        <li><img style="width: 318px; height: 510px;"src="<?= url::file("themes/wind/homepic/site$index/home-pic3.jpg") ?>"/></li>
    </ul>
</div>