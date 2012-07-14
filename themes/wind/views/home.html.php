<?php defined("SYSPATH") or die("No direct script access.") ?>
<script language="JavaScript" type="text/javascript">
	var img1 = new Image();
        var img2 = new Image();
        var img3 = new Image();
        var img4 = new Image();
	img1.src = "<?= url::file("themes/wind/homepic/home-pic1.jpg") ?>";
        img2.src = "<?= url::file("themes/wind/homepic/home-pic2.jpg") ?>";
        img3.src = "<?= url::file("themes/wind/homepic/home-pic3.jpg") ?>";
        img4.src = "<?= url::file("themes/wind/homepic/home-pic4.jpg") ?>";

	img1.onload = function() {
	document.getElementById("home_pic1").src = this.src;
	}
        img2.onload = function() {
	document.getElementById("home_pic2").src = this.src;
	}
        img3.onload = function() {
	document.getElementById("home_pic3").src = this.src;
	}
        img4.onload = function() {
	document.getElementById("home_pic4").src = this.src;
	}
</script>
<div id="home_pictures" class="ui-corner-all">
    <ul>
        <li><img id="home_pic1" src="<?= url::file("themes/wind/homepic/home-pic1-thumb.jpg") ?>"/></li>
        <li><img id="home_pic2" src="<?= url::file("themes/wind/homepic/home-pic2-thumb.jpg") ?>"/></li>
    </ul>
    <ul>
        <li><img id="home_pic3" src="<?= url::file("themes/wind/homepic/home-pic3-thumb.jpg") ?>"/></li>
        <li><img id="home_pic4" src="<?= url::file("themes/wind/homepic/home-pic4-thumb.jpg") ?>"/></li>
    </ul>
<!--<table id="home_table" >
    <tr>
        <td>
            <img src="<?= url::file("themes/wind/homepic/site0/home-pic1.jpg") ?>"/>
        </td>
        <td>
            <img src="<?= url::file("themes/wind/homepic/site0/home-pic2.jpg") ?>"/>
        </td>
        
    </tr>
    <tr>
        <td>
            <img src="<?= url::file("themes/wind/homepic/site0/home-pic3.jpg") ?>"/>
        </td>
        <td>
            <img src="<?= url::file("themes/wind/homepic/site0/home-pic1.jpg") ?>"/>
        </td>
    </tr>
</table>-->
</div>
<!--   -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;
<div id="home_pictures">
    <ul  class="Slides" id="Slides">
        <? $index = rand(0, 4); ?>
        <li><img style="width: 318px; height: 510px;"src="<?= url::file("themes/wind/homepic/site$index/home-pic1.jpg") ?>"/></li>
        <li><img style="width: 318px; height: 510px;"src="<?= url::file("themes/wind/homepic/site$index/home-pic2.jpg") ?>"/></li>
        <li><img style="width: 318px; height: 510px;"src="<?= url::file("themes/wind/homepic/site$index/home-pic3.jpg") ?>"/></li>
    </ul>
</div>
-->