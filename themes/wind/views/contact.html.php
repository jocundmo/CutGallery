<?php defined("SYSPATH") or die("No direct script access.") ?>
  <script language="JavaScript" type="text/javascript">
	var img = new Image();
	img.src = "<?= url::file("themes/wind/images/contact-us.png") ?>";
	img.onload = function() {
	document.getElementById("img-about-us").src = this.src;
	}
  </script>
<div id="contact_content">
    <img id="img-about-us" title="call us" src="<?= url::file("themes/wind/images/contact-us-thumb.png") ?>" />
</div>