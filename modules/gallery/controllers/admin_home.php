<?php defined("SYSPATH") or die("No direct script access.");

class Admin_Home_Controller extends Admin_Controller {
  public function index() {
//    $user = identity::active_user();
    url::redirect("admin/users");
//    $view = new Admin_View("admin.html");
//    $view->page_title = t("Admin");
//    
//    $view->content = new View("user_profile.html");
//    $view->content->user = $user;
//    $view->content->contactable =
//      !$user->guest && $user->id != identity::active_user()->id && $user->email;
////    $view->content->editable =
////      identity::is_writable() && !$user->guest && $user->id == identity::active_user()->id;
//    $event_data = (object)array("user" => $user, "content" => array());
//    module::event("show_user_profile", $event_data);
//    $view->content->info_parts = $event_data->content;
////    $view->content = new View("admin_home.html");
////    $view->content->available = module::available();
//    print $view;
  }
}


