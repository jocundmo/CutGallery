<?php defined("SYSPATH") or die("No direct script access.") ?>
<div>
<?= t("Page is navigating... <br/> Login is successful... <br/>Please wait...<br/><a href=>Click</a> if your browser is not refreshed...") ?>
  <script>
      if (location.href.toLocaleString().indexOf("index.php", 0)> 0){
        location.href="albums";
        }
      else{
        location.href="index.php/albums";
        }
  </script>
</div>

