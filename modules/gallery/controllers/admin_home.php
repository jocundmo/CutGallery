<?php defined("SYSPATH") or die("No direct script access.");

class Admin_Home_Controller extends Admin_Controller {
  public function index() {

    $view = new Admin_View("admin.html");
    $view->page_title = t("Admin");
    $view->content = new View("admin_home.html");
    $view->content->available = module::available();
    print $view;
  }
}


