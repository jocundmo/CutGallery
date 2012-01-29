<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="g-admin-users-delete-user">
  <p>
    <!-- CutGallery - Refine warning message... -->
    <?= t("Really delete VIP <b>%vip_user</b>? If true, corresponding guest <b>%guest_user</b> will be deleted as well.", array("vip_user" => $user->display_name(), "guest_user" => substr($user->display_name(), 0, strlen($user->display_name()) - 4))) ?>
    <? //= t("Really delete <b>%name</b>?  Any photos, movies or albums owned by this user will transfer ownership to <b>%new_owner</b>.", array("name" => $user->display_name(), "new_owner" => identity::active_user()->display_name())) ?>
  </p>
  <?= $form ?>
</div>
